<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->string('image_type')->default('gallery'); // e.g., 'cover', 'gallery'
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Move existing property JSON media to property_images
        $properties = DB::table('properties')->get();
        foreach ($properties as $property) {
            if ($property->media) {
                $mediaPaths = json_decode($property->media, true);
                if (is_array($mediaPaths)) {
                    foreach ($mediaPaths as $index => $oldPath) {
                        $newPath = $oldPath; // Default to keeping the old path

                        if (Storage::disk('public')->exists($oldPath)) {
                            try {
                                $uuid = Str::uuid()->toString();
                                $newDir = "precious-real-estate/properties/property-{$property->id}/gallery/{$uuid}";
                                Storage::disk('public')->makeDirectory($newDir);

                                $ext = pathinfo($oldPath, PATHINFO_EXTENSION) ?: 'webp';
                                $newPath = "{$newDir}/large.{$ext}";

                                Storage::disk('public')->copy($oldPath, $newPath);
                                // Set new directory path as the image path, matching MediaService return logic
                                $newPath = $newDir;
                            } catch (Exception $e) {
                                // Fallback to old path if copy fails
                                $newPath = $oldPath;
                            }
                        }

                        DB::table('property_images')->insert([
                            'property_id' => $property->id,
                            'image_path' => $newPath,
                            'image_type' => 'gallery',
                            'is_featured' => $index === 0,
                            'sort_order' => $index,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('media');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->json('media')->nullable();
        });

        Schema::dropIfExists('property_images');
    }
};
