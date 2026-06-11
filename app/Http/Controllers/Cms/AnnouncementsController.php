<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\MediaService;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->get('search').'%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $announcements = $query->orderBy('published_at', 'desc')->paginate(20);

        return view('cms.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('cms.announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'status' => 'required|string|in:draft,published,archived',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['published_at'] = $data['published_at'] ?: now();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = app(MediaService::class)->upload($request->file('cover_image'), 'announcements/featured');
        } else {
            unset($data['cover_image']);
        }

        Announcement::create($data);

        return redirect()->route('cms.announcements.index')->with('status', 'Announcement created.');
    }

    public function edit(Announcement $announcement)
    {
        return view('cms.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'status' => 'required|string|in:draft,published,archived',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = app(MediaService::class)->replace(
                $request->file('cover_image'),
                'announcements/featured',
                $announcement->cover_image
            );
        } else {
            unset($data['cover_image']);
        }

        $announcement->update($data);

        return redirect()->route('cms.announcements.index')->with('status', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('cms.announcements.index')->with('status', 'Announcement deleted.');
    }
}
