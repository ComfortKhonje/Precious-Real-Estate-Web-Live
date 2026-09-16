<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show contact information edit form
     */
    public function index()
    {
        // Get all contact settings
        $settings = Setting::whereIn('key', [
            'office_name',
            'office_address_lilongwe',
            'office_address_blantyre',
            'postal_address',
            'office_phone',
            'office_phone_secondary',
            'office_email',
            'working_hours',
            'latitude',
            'longitude',
            'facebook_url',
            'instagram_url',
            'linkedin_url',
            'tiktok_url',
            'whatsapp_number',
        ])->pluck('value', 'key');

        return view('cms.contact.index', compact('settings'));
    }

    /**
     * Update contact information
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'office_name' => 'nullable|string|max:255',
            'office_address_lilongwe' => 'nullable|string|max:500',
            'office_address_blantyre' => 'nullable|string|max:500',
            'postal_address' => 'nullable|string|max:500',
            'office_phone' => 'nullable|string|max:20',
            'office_phone_secondary' => 'nullable|string|max:20',
            'office_email' => 'nullable|email|max:255',
            'working_hours' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'facebook_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'linkedin_url' => 'nullable|url|max:500',
            'tiktok_url' => 'nullable|url|max:500',
            'whatsapp_number' => 'nullable|string|max:20',
        ]);

        // Update or create each setting
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('cms.contact.index')
            ->with('success', 'Contact information updated successfully!');
    }
}
