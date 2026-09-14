# Deploying PREC to cPanel

Rewritten 2026-09-14 for launch. The hosting account (`prec`, PHP 8.4) has
**no shell access** — no Terminal, no SSH, and cPanel Git Version Control
can't pull a private GitHub repo without it. So nothing on the server is
ever run by hand. Deploys are fully automatic:

```
git push origin main
  -> GitHub Actions: tests, composer install --no-dev, npm run build
  -> FTPS upload of changed files only
  -> RELEASE file (commit SHA) uploaded last
cPanel cron, every minute: php artisan schedule:run
  -> prec:post-deploy sees the new RELEASE:
     migrate, first-run seed, storage link, config/route/view cache
```

Progress: GitHub > Actions tab, then `storage/logs/deploy.log` on the server
(File Manager), or CMS > Settings > Deployment.

---

## 0. Folder layout on the server

```
/home/prec/
├── precious-real-estate-web/     <- app code, vendor/, storage/, .env  (NOT web-reachable)
│   └── RELEASE                   <- commit SHA of the latest upload
└── public_html/                  <- web root: index.php, .htaccess, build/, brand-assets/
    └── storage -> ../precious-real-estate-web/storage/app/public   (created automatically)
```

`.env` holds the database and mailbox passwords, so it must live **above**
`public_html`. `bootstrap/app.php` detects this layout (no `public/` inside
the app folder, `public_html` next to it) and uses `public_html` as the
public path. `deploy/public_html-index.php` becomes `public_html/index.php`.

---

## 1. One-time setup (in order)

### 1.1 PHP
cPanel > **MultiPHP Manager** > preciousrealestate.mw > **PHP 8.4**.
cPanel > **Select PHP Version** > Extensions (if that screen exists): make sure
`pdo_mysql`, `mbstring`, `gd`, `fileinfo`, `zip`, `intl`, `bcmath` are ticked.

### 1.2 SSL
cPanel > **SSL/TLS Status** > run AutoSSL for `preciousrealestate.mw` and
`www.preciousrealestate.mw`. The site must load over `https://` before
launch (secure cookies and HSTS depend on it).

### 1.3 Database
cPanel > **MySQL Databases**:
1. Create database `prec_website` (cPanel shows it as `prec_website`).
2. Create user `prec_webuser` with a generated strong password.
3. Add the user to the database with **ALL PRIVILEGES**.

### 1.4 Mailbox and email deliverability
1. cPanel > **Email Accounts** > create `info@preciousrealestate.mw`
   (skip if it exists). Note the password.
2. cPanel > **Email Deliverability** > for `preciousrealestate.mw`, fix/install
   **SPF** and **DKIM** if they show a problem. Without these, inquiry
   notifications and password-reset emails land in spam or get rejected.
3. The SMTP host/port are under Email Accounts > Connect Devices. Default
   assumption: `mail.preciousrealestate.mw`, port 465, SSL.

### 1.5 FTP credentials for GitHub
Use the main cPanel account's FTP login (its home is `/home/prec`), or create
one in cPanel > **FTP Accounts** with directory `/home/prec` (the account
root, not `public_html`). In GitHub > repo > Settings > Secrets and
variables > **Actions**, add:

| Secret | Value |
| --- | --- |
| `FTP_SERVER` | `ftp.preciousrealestate.mw` (or the server hostname cPanel shows) |
| `FTP_USERNAME` | e.g. `prec` or `deploy@preciousrealestate.mw` |
| `FTP_PASSWORD` | its password |

Also create an Environment named `production` (Settings > Environments) —
the deploy job runs in it, so you can add required reviewers later if you want.

### 1.6 Production `.env`
1. Leave `APP_KEY=` empty — `prec:post-deploy` generates it on the first run.
2. cPanel > **File Manager** > Settings > tick **Show Hidden Files**.
3. Create folder `/home/prec/precious-real-estate-web` if it doesn't exist.
4. Inside it create `.env`, paste `deploy/env.production.example`, and fill
   in every `<...>`: DB password, mailbox password, and a strong
   `CMS_BOOTSTRAP_PASSWORD` for the first Super Admin.
5. Permissions on `.env`: **600** (File Manager > right click > Change Permissions).

`APP_DEBUG=false` is non-negotiable: with it on, any error page prints the
database password to whoever triggered it.

### 1.7 Clear out the old site
Back up anything currently in `public_html` you want to keep, then empty it
(keep `cgi-bin` and `.well-known` if present — AutoSSL uses the latter).

### 1.8 First deploy
Merge to `main` and push (or GitHub > Actions > Deploy to cPanel > Run
workflow). The **first** upload includes all of `vendor/` — thousands of
files — so allow 15–30 minutes. Later deploys only send what changed.

### 1.9 Cron (this is what finishes every deploy)
cPanel > **Cron Jobs** > Add New Cron Job:
- Common Settings: **Once Per Minute** (`* * * * *`)
- Command:
  ```
  /opt/alt/php84/usr/bin/php /home/prec/precious-real-estate-web/artisan schedule:run >> /home/prec/cron.log 2>&1
  ```
  This server is CloudLinux: the domain runs `alt-php84` (MultiPHP Manager),
  whose binary is `/opt/alt/php84/usr/bin/php`. The `ea-php84` paths do not
  exist here. `cron.log` in the home folder shows any error; switch the end
  to `>> /dev/null 2>&1` once things are stable if it grows too large.

Within a minute of the upload finishing, `storage/logs/deploy.log` should show
migrations, the first-run seed (services, icons, team), the Super Admin
creation, the storage link and the caches, ending in `Release <sha> is live.`

### 1.10 Folder permissions
File Manager: `precious-real-estate-web/storage` and
`precious-real-estate-web/bootstrap/cache` need to be writable — **755** on
folders is normal for cPanel (PHP runs as your user). If `deploy.log`
doesn't appear, check these first.

### 1.11 First login and staff accounts
1. Open `https://preciousrealestate.mw/cms/login` and log in with
   `CMS_BOOTSTRAP_EMAIL` / `CMS_BOOTSTRAP_PASSWORD`.
2. **Delete the `CMS_BOOTSTRAP_PASSWORD` line from `.env`** (it's only ever
   used while there are no accounts, but it shouldn't sit on disk).
3. CMS > **Staff Accounts** > Add Account for each person. Leave
   "Require a new password at first login" on.
4. CMS > Settings > **Send Test Email** — confirms SMTP works.

Roles:

| Role | Can do |
| --- | --- |
| Super Admin | Everything, including managing other Super Admins |
| Admin | All content, inquiries (incl. delete), contact info, analytics, settings, maintenance mode, staff accounts (Admins/Editors) |
| Editor | Properties, services, updates, team members; read inquiries |

Anyone can reset a forgotten password from the login page (emailed link, 60 minutes).

---

## 2. Routine deploy

```bash
npm run build          # if CSS/JS changed — CI fails if public/build is stale
php artisan test
git push origin dev    # CI runs
# merge dev -> dev-test -> main (PRs); the push to main deploys
```

## 3. If something goes wrong

- **GitHub Actions red on "test"** — nothing was uploaded; fix and push again.
- **Upload finished but site unchanged/500** — read
  `precious-real-estate-web/storage/logs/deploy.log` and `laravel-*.log`.
  A failed post-deploy step is retried every minute until it succeeds.
- **Force a re-run of post-deploy** — delete
  `precious-real-estate-web/storage/app/deployed-release` in File Manager.
- **Is cron running?** If `deploy.log` never appears, the cron command path is
  wrong. cPanel emails cron output if you temporarily remove `>> /dev/null 2>&1`.
- **Uploads > 2MB fail** — `public/.user.ini` raises the limits; if the host
  ignores it, set `upload_max_filesize=6M` and `post_max_size=40M` in cPanel >
  MultiPHP INI Editor.

## 4. Maintenance mode

CMS > Settings > Site Status > Enable Maintenance Mode. Real `503` with
`Retry-After`; `/cms` stays reachable so it can always be turned back off.

## 5. Post-deploy smoke check

- `/`, `/about`, `/services`, `/team`, `/contact`, `/inquiry`, `/updates`,
  `/properties` and one property detail page — all 200
- `/sitemap.xml`, `/robots.txt`
- `/.env` and `/precious-real-estate-web/.env` — must NOT be downloadable
- `/cms/login`, then every CMS screen
- Submit the inquiry form; confirm it appears in CMS > Inquiries **and** the
  notification email arrives
- Add a property with a photo; confirm the photo shows on the public site
  (storage link check)

## 6. If shell access is ever enabled

`php artisan prec:create-user "Name" email --role=admin` works for
accounts, and `php artisan prec:post-deploy --force` re-runs the deploy steps.
The FTP workflow keeps working either way.
