# Deploying PREC to cPanel

Written 2026-09-03 alongside the full audit. Read this once before the first
deploy; after that only the "Routine deploy" section matters.

---

## 0. Why the odd folder layout

Laravel's document root is supposed to be its `public/` folder only —
everything else (including `.env`, which holds the database password) must sit
**above** the web root or it is downloadable over HTTP.

cPanel's document root is fixed at `public_html/`, so the standard workaround
is:

```
/home/CPANELUSER/
├── precious-real-estate-web/     <- the app (app/, config/, routes/, .env, vendor/, storage/)
├── repositories/                 <- where cPanel Git clones the repo
└── public_html/                  <- document root
    ├── index.php                 <- deploy/public_html-index.php, renamed
    ├── .htaccess                 <- from public/.htaccess
    ├── build/                    <- from public/build
    ├── brand-assets/             <- from public/brand-assets
    ├── storage                   <- symlink to ../precious-real-estate-web/storage/app/public
    └── robots.txt, favicon.ico, ...
```

`deploy/public_html-index.php` is the front controller rewritten to point one
level up at the app folder. It is the only file that knows about this layout.

---

## 1. First-time setup

### 1.1 Create the app folder and upload code once

Easiest first pass is a plain SFTP/File Manager upload of everything except
`node_modules/`, then let Git take over for subsequent deploys.

### 1.2 Production `.env`

Copy `.env.example` to `/home/CPANELUSER/precious-real-estate-web/.env` and set:

```dotenv
APP_NAME="Precious Real Estate Consulting"
APP_ENV=production
APP_DEBUG=false           # <- non-negotiable, see below
APP_URL=https://preciousrealestate.mw
APP_KEY=                  # php artisan key:generate

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=<cpanel db name>
DB_USERNAME=<cpanel db user>
DB_PASSWORD=<strong password>

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_LIFETIME=120

CACHE_STORE=database
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=mail.preciousrealestate.mw
MAIL_PORT=465
MAIL_USERNAME=info@preciousrealestate.mw
MAIL_PASSWORD=<mailbox password>
MAIL_SCHEME=smtps
MAIL_FROM_ADDRESS=info@preciousrealestate.mw
MAIL_FROM_NAME="Precious Real Estate Consulting"

# Optional, once a GA4 property exists
GOOGLE_ANALYTICS_ID=
```

**`APP_DEBUG=false` is the single highest-priority setting on this server.**
With it true, any error page prints the full stack trace, file paths, SQL and
bound query values — including the database password — to whoever triggered it.

### 1.3 Permissions and the storage symlink

```bash
cd ~/precious-real-estate-web
chmod -R 775 storage bootstrap/cache
php artisan storage:link
```

Then confirm `public_html/storage` exists and is a symlink. Without it every
CMS-uploaded property photo and article cover 404s, no matter what the code
does. If cPanel blocks symlink creation, create the link manually from the
Terminal, or fall back to a cron that rsyncs `storage/app/public` into
`public_html/storage`.

### 1.4 Database and first admin account

```bash
php artisan migrate --force
php artisan db:seed --class=ServiceSeeder
php artisan db:seed --class=TeamMemberSeeder
php artisan prec:create-user "Precious Tembo" precious@preciousrealestate.mw
```

The command prints a generated password once — change it immediately from the
CMS Settings page.

Do **not** run `db:seed --class=UserSeeder`: it creates demo accounts whose
password is literally `password`. It now refuses to run outside local/testing,
but check the live `users` table anyway and delete anything ending in
`@preciousrealestate.test`.

### 1.5 Optimised images

The repo ships a `.webp` sibling for every brand image, and `public/.htaccess`
serves it automatically to browsers that support WebP. If new brand images are
added later:

```bash
php artisan prec:optimize-images
```

Commit the generated `.webp` files.

### 1.6 Upload size limits

Found 2026-09-04: a team-member photo upload threw a raw
`PostTooLargeException` page in production-equivalent conditions. Root cause
was a mismatch, not a code bug — the app's own validation allows images up
to 5MB (`max:5120`), but PHP's `upload_max_filesize`/`post_max_size` were
smaller than that, so PHP rejected the request before Laravel ever got to
validate it.

`public/.user.ini` in this repo raises both — most cPanel hosts (PHP-FPM or
suPHP) honor a `.user.ini` in the docroot automatically, no hosting-panel
change needed. **Verify after deploy**: try a >2MB image upload in the CMS.
If it still fails, the host has disabled `.user.ini` overrides — go to
cPanel → **MultiPHP INI Editor** → select the domain → raise
`upload_max_filesize` and `post_max_size` there directly (match the values
in `public/.user.ini`).

A friendly error (not a raw exception page) now shows either way — see
`bootstrap/app.php`'s `PostTooLargeException` handler — but the goal is for
users to never hit it, since the CMS upload form now also blocks
oversized files client-side before they're submitted.

---

## 2. Wiring up GitHub -> cPanel

### Path A — cPanel Git Version Control (preferred if available)

1. cPanel -> Files -> **Git™ Version Control** -> Create.
2. Clone URL: `https://github.com/jannytheedesigner/precious-real-estate-web.git`
   Repository path: `/home/CPANELUSER/repositories/precious-real-estate-web`.
3. Edit `.cpanel.yml` in the repo root and replace **`CPANELUSER`** with the
   real cPanel username in both `export` lines. Commit and push.
4. In cPanel, open the repo -> **Pull or Deploy** -> *Update from Remote*, then
   *Deploy HEAD Commit*.

This is deploy-on-click, not deploy-on-push. Push-triggered deploys need a
webhook receiver, which is more moving parts than this project needs.

If `composer` isn't on PATH for the account, comment out the composer line in
`.cpanel.yml` and upload `vendor/` by SFTP after any dependency change.

### Path B — GitHub Actions -> SFTP (if Git Version Control is unavailable)

Add FTP credentials as repository secrets (`FTP_SERVER`, `FTP_USERNAME`,
`FTP_PASSWORD`) and add a deploy job using `SamKirkland/FTP-Deploy-Action`.
Everything the server needs is already committed, so no build step is required
on the host.

Either way, `.github/workflows/ci.yml` runs the test suite and fails the build
if `public/build` is stale — so a broken deploy gets caught before it ships.

---

## 3. Routine deploy

```bash
npm run build          # only if CSS/JS changed
php artisan test       # must be green
git add -A && git commit && git push
```

Then in cPanel: Git Version Control -> *Update from Remote* -> *Deploy HEAD Commit*.

After any deploy that changed `config/`, `routes/` or Blade files:

```bash
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

`.cpanel.yml` already does this. If a page 500s right after a deploy, the first
thing to try is `php artisan optimize:clear` — a stale compiled view was the
exact cause of one of the bugs found in the 2026-09-03 audit.

---

## 4. Taking the site down for maintenance

Superseded 2026-09-09 — the `.htaccess` approach below required editing raw
Apache config on the live server by hand every time and was easy to forget to
revert. Use the CMS instead: **Settings → Site Status → Enable Maintenance
Mode**. It calls `php artisan down` under the hood, which already returns a
real `503` with `Retry-After` (no redirect, no SEO risk — the exact problem
the `.htaccess` rule below was working around), and the CMS itself
(`/cms/*`, configured in `bootstrap/app.php`) stays reachable so whoever
turned it on can always turn it back off from the same screen — no SSH
needed, and no way to lock yourself out.

Only reach for the terminal if the CMS itself is unreachable:

```bash
php artisan down --retry=60   # take the public site down
php artisan up                # bring it back
```

<details>
<summary>Old method (kept for reference only — don't use)</summary>

The correct way is a real `503` with `Retry-After`, not a redirect — a redirect
risks Google indexing the maintenance page in place of real URLs. Put this at
the very top of `public_html/.htaccess`:

```apache
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/assets/
RewriteCond %{REQUEST_URI} !^/maintenance\.html$
RewriteCond %{REMOTE_ADDR} !^YOUR\.IP\.HERE$
RewriteRule ^(.*)$ - [R=503,L]

ErrorDocument 503 /maintenance.html
Header always set Retry-After "7200"
```

Remove those lines to bring the site back. Nothing in the app is touched.

</details>

---

## 5. Post-deploy smoke check

Open each of these and confirm a 200, not a 500:

- `/` , `/about`, `/services`, `/team`, `/contact`, `/inquiry`, `/news`
- `/properties` and one property detail page
- `/sitemap.xml` and `/robots.txt`
- `/cms/login`, then every CMS screen after logging in
- Submit the inquiry form on a property page and confirm the row appears under
  CMS -> Inquiries with the property reference attached
- Add one property with a photo and confirm the image renders on the public site
  (this is the storage-symlink check)
