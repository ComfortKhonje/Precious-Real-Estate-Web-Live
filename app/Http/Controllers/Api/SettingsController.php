<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        // Only return non-sensitive settings for general view
        $sensitiveKeys = ['api_key', 'secret', 'password', 'token', 'stripe', 'mail_'];
        
        $settings = Setting::where(function ($query) use ($sensitiveKeys) {
            foreach ($sensitiveKeys as $key) {
                $query->where('key', 'not like', '%' . $key . '%');
            }
        })->get();

        return response()->json($settings);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string',
            'value' => 'nullable|string',
        ]);

        $setting = Setting::updateOrCreate(['key' => $data['key']], ['value' => $data['value'] ?? null]);
        return response()->json($setting, 201);
    }

    public function update(Request $request, $key)
    {
        $data = $request->validate([
            'value' => 'nullable|string',
        ]);

        $setting = Setting::updateOrCreate(['key' => $key], ['value' => $data['value'] ?? null]);
        return response()->json($setting);
    }
}
