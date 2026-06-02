<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    protected array $defaultTitles = [
        'Property Valuation',
        'Property Management',
        'Property Development',
        'Property Sales & Letting',
        'Title Deed Processing',
    ];

    public function index()
    {
        foreach ($this->defaultTitles as $title) {
            Service::firstOrCreate(['title' => $title], [
                'short_description' => '',
                'content' => '',
                'banner_image' => '',
                'icon' => '',
                'visible' => true,
            ]);
        }

        $services = Service::orderBy('title')->get();

        return view('cms.services.index', compact('services'));
    }

    public function edit(string $slug)
    {
        $title = str($slug)->replace('-', ' ')->title();
        $service = Service::where('title', $title)->firstOrFail();

        return view('cms.services.edit', compact('service'));
    }

    public function update(Request $request, string $slug)
    {
        $title = str($slug)->replace('-', ' ')->title();
        $service = Service::where('title', $title)->firstOrFail();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'visible' => 'nullable|boolean',
        ]);

        $data['visible'] = $request->boolean('visible');
        $service->update($data);

        return redirect()->route('cms.services.index')->with('status', 'Service updated.');
    }
}
