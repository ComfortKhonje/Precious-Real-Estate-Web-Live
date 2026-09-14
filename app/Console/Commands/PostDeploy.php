<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Models\User;
use Database\Seeders\ProductionSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

/**
 * Finishes a deploy on a host with no shell access.
 *
 * GitHub Actions uploads the code over FTP and, as its very last step,
 * writes a RELEASE file (the commit SHA) into the app root. cPanel's cron
 * runs `schedule:run` every minute, which runs this command. When RELEASE
 * differs from the last SHA recorded in storage/app/deployed-release, it
 * runs everything `php artisan ...` would normally be typed for — then
 * records the SHA so the next minute is a no-op.
 *
 * Output goes to storage/logs/deploy.log (readable in cPanel File Manager)
 * and the last result is shown on CMS > Settings.
 */
class PostDeploy extends Command
{
    protected $signature = 'prec:post-deploy {--force : Run even if this release was already deployed}';

    protected $description = 'Run migrations, caches and first-run setup after an FTP deploy';

    public function handle(): int
    {
        $release = $this->currentRelease();
        $deployed = $this->deployedRelease();

        if (! $this->option('force') && ($release === null || $release === $deployed)) {
            return self::SUCCESS;
        }

        $this->log("Deploying release {$release} (previous: ".($deployed ?? 'none').')');

        try {
            // First deploy: the .env is created by hand in File Manager with
            // an empty APP_KEY= line (nobody on the team can run
            // key:generate). Fill it in here, before anything is encrypted.
            if (empty(config('app.key'))) {
                $this->step('key:generate', ['--force' => true]);
            }

            $this->installFrontController();

            $this->step('migrate', ['--force' => true]);

            if (Service::count() === 0) {
                $this->log('Empty database — seeding services, icons and team.');
                $this->step('db:seed', ['--class' => ProductionSeeder::class, '--force' => true]);
            }

            $this->bootstrapFirstAdmin();

            if (! File::exists(public_path('storage'))) {
                $this->step('storage:link');
            }

            // Skipped under the test suite only: caching config mid-test
            // resets the in-memory database and would leave cache files in
            // the developer's checkout.
            if (! app()->runningUnitTests()) {
                $this->step('optimize:clear');
                $this->step('config:cache');
                $this->step('route:cache');
                $this->step('view:cache');
            }
        } catch (\Throwable $e) {
            $this->log('FAILED: '.$e->getMessage());
            report($e);

            // Not recorded as deployed, so the next cron tick retries.
            return self::FAILURE;
        }

        File::put($this->deployedReleasePath(), (string) $release);
        $this->log("Release {$release} is live.");

        return self::SUCCESS;
    }

    /**
     * Creates the first Super Admin from config/cms.php — only when there
     * are no accounts at all, so a leftover .env value can never recreate
     * or overwrite anyone later.
     */
    private function bootstrapFirstAdmin(): void
    {
        if (User::query()->exists()) {
            return;
        }

        $admin = config('cms.bootstrap_admin');

        $validator = Validator::make($admin, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(8)],
        ]);

        if ($validator->fails()) {
            $this->log('No CMS accounts yet and CMS_BOOTSTRAP_* is missing or invalid in .env: '.implode(' ', $validator->errors()->all()));

            return;
        }

        User::create([
            'name' => $admin['name'],
            'email' => $admin['email'],
            'password' => $admin['password'],
            'role' => User::SUPER_ADMIN,
        ]);

        $this->log("Created first Super Admin {$admin['email']}. Remove CMS_BOOTSTRAP_PASSWORD from .env now.");
    }

    /**
     * public_html/index.php is installed from here instead of over FTP:
     * the host refused that one file on every FTPS upload (the transfer
     * died with a TLS alert on exactly that file, twice). It ships inside
     * the app folder as deploy/public_html-index.php and is copied across
     * locally. Only in the cPanel layout — never over a local public/.
     */
    private function installFrontController(): void
    {
        $source = base_path('deploy/public_html-index.php');
        $target = public_path('index.php');

        if (public_path() === base_path('public') || ! File::exists($source)) {
            return;
        }

        if (File::exists($target) && File::get($target) === File::get($source)) {
            return;
        }

        File::copy($source, $target);
        $this->log('Installed public_html/index.php');
    }

    private function step(string $command, array $arguments = []): void
    {
        $exitCode = Artisan::call($command, $arguments);
        $output = trim(Artisan::output());

        $this->log("$ artisan {$command}".($output !== '' ? "\n{$output}" : ''));

        if ($exitCode !== 0) {
            throw new \RuntimeException("artisan {$command} exited with code {$exitCode}");
        }
    }

    private function log(string $message): void
    {
        $this->line($message);
        File::append(storage_path('logs/deploy.log'), '['.now()->toDateTimeString()."] {$message}\n");
    }

    private function currentRelease(): ?string
    {
        $path = base_path('RELEASE');

        return File::exists($path) ? trim(File::get($path)) ?: null : null;
    }

    private function deployedRelease(): ?string
    {
        $path = $this->deployedReleasePath();

        return File::exists($path) ? trim(File::get($path)) ?: null : null;
    }

    private function deployedReleasePath(): string
    {
        return storage_path('app/deployed-release');
    }

    /** For CMS > Settings: the release currently live, and when it went live. */
    public static function status(): array
    {
        $path = storage_path('app/deployed-release');

        return [
            'release' => File::exists($path) ? trim(File::get($path)) : null,
            'deployed_at' => File::exists($path) ? \Illuminate\Support\Carbon::createFromTimestamp(File::lastModified($path)) : null,
            'pending' => File::exists(base_path('RELEASE'))
                && (! File::exists($path) || trim(File::get(base_path('RELEASE'))) !== trim(File::get($path))),
        ];
    }
}
