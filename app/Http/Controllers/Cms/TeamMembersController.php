<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Services\MediaService;
use Illuminate\Http\Request;

class TeamMembersController extends Controller
{
    /**
     * Display a listing of team members
     */
    public function index(Request $request)
    {
        $query = TeamMember::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%");
        }

        $teamMembers = $query->ordered()->paginate(20);

        return view('cms.team-members.index', compact('teamMembers'));
    }

    /**
     * Show the form for creating a new team member
     */
    public function create()
    {
        return view('cms.team-members.create');
    }

    /**
     * Store a newly created team member in storage
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'qualifications' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0|max:100',
            'bio' => 'nullable|string|max:1000',
            'photo_url' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'order' => 'nullable|integer|min:0',
            'visible' => 'nullable|boolean',
        ]);

        $data['visible'] = $request->boolean('visible');
        $data['order'] = $data['order'] ?? TeamMember::max('order') + 1;

        if ($request->hasFile('photo_url')) {
            $data['photo_url'] = app(MediaService::class)->upload($request->file('photo_url'), 'team/profiles');
        } else {
            unset($data['photo_url']);
        }

        TeamMember::create($data);

        return redirect()->route('cms.team-members.index')
            ->with('status', 'Team member created successfully!');
    }

    /**
     * Show the form for editing the specified team member
     */
    public function edit(TeamMember $teamMember)
    {
        return view('cms.team-members.edit', compact('teamMember'));
    }

    /**
     * Update the specified team member in storage
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'qualifications' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0|max:100',
            'bio' => 'nullable|string|max:1000',
            'photo_url' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'order' => 'nullable|integer|min:0',
            'visible' => 'nullable|boolean',
        ]);

        $data['visible'] = $request->boolean('visible');

        if ($request->hasFile('photo_url')) {
            $data['photo_url'] = app(MediaService::class)->replace(
                $request->file('photo_url'),
                'team/profiles',
                $teamMember->photo_url
            );
        } else {
            unset($data['photo_url']);
        }

        $teamMember->update($data);

        return redirect()->route('cms.team-members.index')
            ->with('status', 'Team member updated successfully!');
    }

    /**
     * Remove the specified team member from storage
     */
    public function destroy(TeamMember $teamMember)
    {
        $name = $teamMember->name;
        $teamMember->delete();

        return redirect()->route('cms.team-members.index')
            ->with('status', "Team member '{$name}' deleted successfully!");
    }
}
