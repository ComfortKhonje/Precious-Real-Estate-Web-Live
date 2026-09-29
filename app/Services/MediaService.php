<?php

namespace App\Services;

use enshrined\svgSanitize\Sanitizer;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class MediaService
{
    protected ImageManager $manager;

    protected string $disk = 'public';

    protected string $basePath = 'precious-real-estate';

    public function __construct()
    {
        $this->manager = ImageManager::usingDriver(Driver::class);
    }

    /**
     * Upload and optimize an image file
     *
     * @param  string  $folder  e.g., 'properties/property-15/gallery' or 'announcements/featured'
     * @return string The base directory path of the uploaded image
     */
    public function upload(UploadedFile $file, string $folder): string
    {
        $uuid = Str::uuid()->toString();
        $directory = "{$this->basePath}/{$folder}/{$uuid}";

        Storage::disk($this->disk)->makeDirectory($directory);

        $this->ensureProcessingHeadroom();

        try {
            $image = $this->manager->decode(
                file_get_contents($file->getRealPath())
            );

            // LARGE
            $large = $image->scaleDown(width: 1600);
            Storage::disk($this->disk)->put(
                "{$directory}/large.webp",
                $large->encode(new WebpEncoder(quality: 85))
            );

            // MEDIUM
            $medium = $image->scaleDown(width: 800);
            Storage::disk($this->disk)->put(
                "{$directory}/medium.webp",
                $medium->encode(new WebpEncoder(quality: 80))
            );

            // THUMBNAIL
            $thumb = $image->cover(300, 300);
            Storage::disk($this->disk)->put(
                "{$directory}/thumbnail.webp",
                $thumb->encode(new WebpEncoder(quality: 75))
            );

            // ORIGINAL
            $file->storeAs(
                $directory,
                'original.'.$file->getClientOriginalExtension(),
                $this->disk
            );

            return $directory;

        } catch (\Throwable $e) {

            Log::error('Media upload failed: '.$e->getMessage());

            $file->storeAs(
                $directory,
                'original.'.$file->getClientOriginalExtension(),
                $this->disk
            );

            return $directory;
        }
    }

    /**
     * GD holds a decoded photo uncompressed in memory: a 12-megapixel phone
     * photo peaks around 120MB while its WebP sizes are made, and takes a
     * couple of seconds. On shared hosting's usual 128MB / 30s defaults, a
     * large photo — or a gallery of several — ended in a fatal "memory
     * exhausted" or "maximum execution time" error, which no catch block
     * can handle, so staff saw a bare 500 (reported 2026-09-29). Raise both
     * for this request only; public/.user.ini raises them too, but some
     * hosts ignore that file. Never lowers a limit that is already higher.
     */
    protected function ensureProcessingHeadroom(): void
    {
        $limit = ini_get('memory_limit');

        if ($limit !== '-1' && $this->bytes($limit) < 256 * 1024 * 1024) {
            @ini_set('memory_limit', '256M');
        }

        // Fresh allowance per image, so a whole gallery isn't bound by one
        // 30-second budget.
        @set_time_limit(60);
    }

    protected function bytes(string $value): int
    {
        $value = trim($value);
        $number = (int) $value;

        return match (strtolower(substr($value, -1))) {
            'g' => $number * 1024 ** 3,
            'm' => $number * 1024 ** 2,
            'k' => $number * 1024,
            default => $number,
        };
    }

    /**
     * Store a black/yellow SVG icon pair as-is (no raster processing — these
     * are vector files, and Intervention's decode() only handles raster
     * formats). Returns the shared directory, mirroring upload()'s
     * directory-per-asset convention but with a color suffix instead of a
     * size suffix.
     */
    public function uploadIconPair(UploadedFile $black, UploadedFile $yellow, string $folder): string
    {
        $uuid = Str::uuid()->toString();
        $directory = "{$this->basePath}/{$folder}/{$uuid}";

        $blackSvg = $this->sanitizeSvg($black);
        $yellowSvg = $this->sanitizeSvg($yellow);

        Storage::disk($this->disk)->makeDirectory($directory);
        Storage::disk($this->disk)->put("{$directory}/black.svg", $blackSvg);
        Storage::disk($this->disk)->put("{$directory}/yellow.svg", $yellowSvg);

        return $directory;
    }

    /**
     * SVG is XML and can carry <script>, event handlers and external
     * references. These files are served from the site's own domain, so an
     * unsanitized one would run script as the site. Strip everything that
     * isn't plain drawing markup; refuse the file if nothing usable is left.
     */
    protected function sanitizeSvg(UploadedFile $file): string
    {
        $sanitizer = new Sanitizer;
        $sanitizer->removeRemoteReferences(true);

        $clean = $sanitizer->sanitize((string) file_get_contents($file->getRealPath()));

        if (! $clean) {
            throw ValidationException::withMessages([
                'icon' => "{$file->getClientOriginalName()} isn't a valid SVG file.",
            ]);
        }

        return $clean;
    }

    /**
     * Delete an entire media directory
     */
    public function delete(?string $directory): void
    {
        if (! $directory) {
            return;
        }

        if (Storage::disk($this->disk)->exists($directory)) {
            Storage::disk($this->disk)->deleteDirectory($directory);
        }
    }

    /**
     * Replace an old media directory with a new upload
     */
    public function replace(UploadedFile $file, string $folder, ?string $oldDirectory): string
    {
        $this->delete($oldDirectory);

        return $this->upload($file, $folder);
    }
}
