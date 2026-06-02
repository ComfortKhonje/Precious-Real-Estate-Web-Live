<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServicesController extends Controller
{
    public function __invoke(): View
    {
        $services = Service::query()
            ->where('visible', true)
            ->orderBy('title')
            ->get();

        return view('pages.services', compact('services'));
    }
}
