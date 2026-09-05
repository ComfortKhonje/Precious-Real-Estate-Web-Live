<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Services\MediaService;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query()->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->get('search');
            // Grouped: without the closure the orWhere escaped the outer
            // filters, so searching while filtered returned unrelated rows.
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")->orWhere('location', 'like', "%{$s}%");
            });
        }

        if ($request->filled('location')) {
            $query->where('location', $request->get('location'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $properties = $query->paginate(20)->withQueryString();

        // The view renders Location and Type filter dropdowns from these.
        // Neither was ever passed, so the CMS Property Listings page threw
        // "Undefined variable $locations" and 500'd. Fixed 2026-09-03.
        $locations = Property::query()
            ->whereNotNull('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        $types = Property::TYPES;

        return view('cms.properties.index', compact('properties', 'locations', 'types'));
    }

    public function create()
    {
        return view('cms.properties.create');
    }

    /**
     * Shared validation rules for both create and edit. $featuredRequired
     * is false on update since an existing image doesn't need re-uploading.
     */
    private function rules(bool $featuredRequired): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|in:'.implode(',', Property::CATEGORIES),
            'type' => 'required|string|in:'.implode(',', Property::TYPES),
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|in:'.implode(',', Property::CURRENCIES),
            'location' => 'required|string|max:255',
            'status' => 'required|string|in:'.implode(',', Property::STATUSES),
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'land_size' => 'nullable|string|max:255',
            'parking_spaces' => 'nullable|integer|min:0',
            'features' => 'nullable|string',
            'nearby_amenities' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_available' => 'nullable|boolean',
            'featured_image' => ($featuredRequired ? 'required' : 'nullable').'|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
        ];
    }

    private function featuresFromInput(Request $request): array
    {
        return collect(explode(',', $request->input('features', '')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();
    }

    private function nearbyAmenitiesFromInput(Request $request): array
    {
        return collect(explode(',', $request->input('nearby_amenities', '')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(featuredRequired: true));

        unset($data['gallery'], $data['remove_images']);
        $data['features'] = $this->featuresFromInput($request);
        $data['nearby_amenities'] = $this->nearbyAmenitiesFromInput($request);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_available'] = $request->boolean('is_available');

        $media = app(MediaService::class);

        // Featured image: stored both as PropertyImage (is_featured=true)
        // and denormalized onto properties.featured_image, so list/card
        // views can read a plain column instead of eager-loading a
        // relationship for every row.
        $featuredPath = $media->upload($request->file('featured_image'), 'properties/gallery');
        $data['featured_image'] = $featuredPath;

        $property = Property::create($data);

        PropertyImage::create([
            'property_id' => $property->id,
            'image_path' => $featuredPath,
            'is_featured' => true,
            'sort_order' => 0,
        ]);

        foreach ($request->file('gallery', []) as $i => $file) {
            $path = $media->upload($file, 'properties/gallery');
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'is_featured' => false,
                'sort_order' => $i + 1,
            ]);
        }

        return redirect()->route('cms.properties.index')->with('status', 'Property created.');
    }

    public function edit(Property $property)
    {
        return view('cms.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $data = $request->validate($this->rules(featuredRequired: false));

        unset($data['gallery'], $data['remove_images']);
        $data['features'] = $this->featuresFromInput($request);
        $data['nearby_amenities'] = $this->nearbyAmenitiesFromInput($request);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_available'] = $request->boolean('is_available');

        $media = app(MediaService::class);

        // Remove images the user unchecked in the edit form (never the
        // featured image this way — replacing it is a separate action below).
        $toRemove = collect($request->input('remove_images', []));
        if ($toRemove->isNotEmpty()) {
            $property->images()->whereIn('id', $toRemove)->get()->each->delete();
        }

        if ($request->hasFile('featured_image')) {
            $oldFeatured = $property->images()->where('is_featured', true)->first();
            $newPath = $media->replace($request->file('featured_image'), 'properties/gallery', $oldFeatured?->image_path);
            $data['featured_image'] = $newPath;

            if ($oldFeatured) {
                $oldFeatured->update(['image_path' => $newPath]);
            } else {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $newPath,
                    'is_featured' => true,
                    'sort_order' => 0,
                ]);
            }
        }

        $nextSort = (int) $property->images()->max('sort_order') + 1;
        foreach ($request->file('gallery', []) as $i => $file) {
            $path = $media->upload($file, 'properties/gallery');
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'is_featured' => false,
                'sort_order' => $nextSort + $i,
            ]);
        }

        $property->update($data);

        return redirect()->route('cms.properties.index')->with('status', 'Property updated.');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('cms.properties.index')->with('status', 'Property deleted.');
    }
}
