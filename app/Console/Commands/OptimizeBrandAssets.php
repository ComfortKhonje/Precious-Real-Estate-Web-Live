<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Symfony\Component\Finder\Finder;

/**
 * public/brand-assets/ is ~20MB of raw PNG/JPG exports referenced directly
 * across every page — the single biggest cause of the load-time complaint
 * PREC raised.
 *
 * Rather than rewriting hundreds of asset() calls (and risking a broken
 * image on a page nobody re-checks), this writes a sibling WebP for every
 * source image: `Hero Image.png` gets `Hero Image.png.webp`. The rewrite
 * block in public/.htaccess then serves the .webp automatically to any
 * browser that sends `Accept: image/webp`, and silently falls back to the
 * original for anything that doesn't — or for any image this command
 * hasn't converted.
 *
 *   php artisan prec:optimize-images            # convert what's missing
 *   php artisan prec:optimize-images --force    # re-convert everything
 */
class OptimizeBrandAssets extends Command
{
    protected $signature = 'prec:optimize-images
                            {--force : Re-encode images that already have a .webp sibling}
                            {--quality=78 : WebP quality, 1-100}
                            {--max-width=1920 : Downscale anything wider than this}';

    protected $description = 'Generate optimized WebP siblings for public/brand-assets images';

    public function handle(): int
    {
        $root = public_path('brand-assets');

        if (! is_dir($root)) {
            $this->error("Not found: {$root}");

            return self::FAILURE;
        }

        $manager = ImageManager::usingDriver(Driver::class);
        $quality = (int) $this->option('quality');
        $maxWidth = (int) $this->option('max-width');
        $force = (bool) $this->option('force');

        $files = Finder::create()
            ->files()
            ->in($root)
            ->name('/\.(png|jpe?g)$/i');

        $converted = 0;
        $skipped = 0;
        $bytesBefore = 0;
        $bytesAfter = 0;

        foreach ($files as $file) {
            $source = $file->getRealPath();
            $target = $source.'.webp';

            if (! $force && file_exists($target) && filemtime($target) >= filemtime($source)) {
                $skipped++;

                continue;
            }

            try {
                $image = $manager->decode(file_get_contents($source));

                if ($image->width() > $maxWidth) {
                    $image = $image->scaleDown(width: $maxWidth);
                }

                file_put_contents($target, (string) $image->encode(new WebpEncoder(quality: $quality)));
            } catch (\Throwable $e) {
                $this->warn('Skipped '.$file->getRelativePathname().': '.$e->getMessage());

                continue;
            }

            $bytesBefore += $file->getSize();
            $bytesAfter += filesize($target);
            $converted++;

            $this->line(sprintf(
                '  %s  %s -> %s',
                $file->getRelativePathname(),
                $this->human($file->getSize()),
                $this->human(filesize($target))
            ));
        }

        $this->newLine();
        $this->info("Converted {$converted}, skipped {$skipped} (already current).");

        if ($converted > 0) {
            $saved = $bytesBefore - $bytesAfter;
            $this->info(sprintf(
                'Converted set: %s -> %s (%s saved, %d%% smaller).',
                $this->human($bytesBefore),
                $this->human($bytesAfter),
                $this->human($saved),
                $bytesBefore > 0 ? round($saved / $bytesBefore * 100) : 0
            ));
        }

        $this->comment('Serving these requires the WebP rewrite block in public/.htaccess (Apache/cPanel).');

        return self::SUCCESS;
    }

    private function human(int $bytes): string
    {
        if ($bytes >= 1_048_576) {
            return round($bytes / 1_048_576, 2).' MB';
        }

        return round($bytes / 1024).' KB';
    }
}
