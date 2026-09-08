<?php

namespace Database\Seeders;

use App\Models\ServiceIcon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceIconSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Migrates the static black/yellow SVG pairs that used to live directly
     * in public/brand-assets/services-icons into the new DB-backed icon
     * library, so the CMS picker has real entries to show out of the box.
     */
    public function run(): void
    {
        $icons = [
            'Property Valuation' => 'Property-Valuation',
            'Property Management' => 'Property-Management',
            'Sales And Letting' => 'Sales-and-Letting',
            'Property Development' => 'Property-Development',
            'Title Deed Processing' => 'Title-Deed-Processing',
        ];

        $sourceDir = public_path('brand-assets/services-icons');

        foreach ($icons as $name => $fileBase) {
            $blackSource = "{$sourceDir}/{$fileBase}-Black.svg";
            $yellowSource = "{$sourceDir}/{$fileBase}-Yellow.svg";

            if (! File::exists($blackSource) || ! File::exists($yellowSource)) {
                $this->command?->warn("Skipping {$name}: source SVGs not found in {$sourceDir}");

                continue;
            }

            $existing = ServiceIcon::where('name', $name)->first();
            if ($existing) {
                continue;
            }

            $directory = 'precious-real-estate/service-icons/'.Str::uuid()->toString();
            Storage::disk('public')->makeDirectory($directory);
            Storage::disk('public')->put("{$directory}/black.svg", File::get($blackSource));
            Storage::disk('public')->put("{$directory}/yellow.svg", File::get($yellowSource));

            ServiceIcon::create(['name' => $name, 'path' => $directory]);
        }
    }
}
