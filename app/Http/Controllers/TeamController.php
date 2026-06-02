<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function __invoke(): View
    {
        $teamMembers = TeamMember::query()
            ->where('visible', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view('pages.team', compact('teamMembers'));
    }
}
