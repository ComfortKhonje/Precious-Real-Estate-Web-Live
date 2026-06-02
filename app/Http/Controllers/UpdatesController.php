<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UpdatesController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.updates');
    }
}

