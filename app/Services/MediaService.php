<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
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

        } catch (\Exception $e) {

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

        Storage::disk($this->disk)->makeDirectory($directory);
        Storage::disk($this->disk)->put("{$directory}/black.svg", file_get_contents($black->getRealPath()));
        Storage::disk($this->disk)->put("{$directory}/yellow.svg", file_get_contents($yellow->getRealPath()));

        return $directory;
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
