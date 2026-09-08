<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\ServiceIcon;
use App\Services\MediaService;
use Illuminate\Http\Request;

class ServiceIconsController extends Controller
{
    /**
     * Add a new icon to the shared library (called from the icon picker
     * modal on the service create/edit forms). Returns JSON so the picker
     * can drop the new icon straight into its grid without a full reload.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:service_icons,name',
            'black_icon' => 'required|file|mimes:svg|max:512',
            'yellow_icon' => 'required|file|mimes:svg|max:512',
        ]);

        $path = app(MediaService::class)->uploadIconPair(
            $request->file('black_icon'),
            $request->file('yellow_icon'),
            'service-icons'
        );

        $icon = ServiceIcon::create([
            'name' => $data['name'],
            'path' => $path,
        ]);

        return response()->json([
            'id' => $icon->id,
            'name' => $icon->name,
            'black_url' => $icon->blackUrl(),
            'yellow_url' => $icon->yellowUrl(),
        ], 201);
    }

    /**
     * Remove an icon from the library. Services still pointing at it fall
     * back to no icon (service_icon_id nullOnDelete) rather than a broken
     * image — deletion never fails just because it's in use.
     */
    public function destroy(ServiceIcon $serviceIcon)
    {
        $serviceIcon->delete();

        return response()->json(['status' => 'deleted']);
    }
}
