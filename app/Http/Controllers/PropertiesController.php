<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PropertiesController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.properties');
    }
}
