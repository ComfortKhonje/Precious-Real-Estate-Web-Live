<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TeamController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.team');
    }
}
