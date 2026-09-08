<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementImage;
use App\Models\TeamMember;
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
        $teamMembers = TeamMember::ordered()->get();

        return view('cms.announcements.create', compact('teamMembers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|in:'.implode(',', Announcement::CATEGORIES),
            'team_member_id' => 'nullable|exists:team_members,id',
            'summary' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            // Every post always has at least one image — was nullable, so a
            // published announcement could carry no cover at all.
            'cover_image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'status' => 'required|string|in:draft,published,archived',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        unset($data['gallery']);
        $data['is_featured'] = $request->boolean('is_featured');
        // ?? not ?: — an omitted (not just empty) published_at threw
        // "Undefined array key" and 500'd the whole create form.
        $data['published_at'] = $data['published_at'] ?? null ?: now();
        $data['content'] = Announcement::sanitizeContent($data['content'] ?? null);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = app(MediaService::class)->upload($request->file('cover_image'), 'announcements/featured');
        } else {
            unset($data['cover_image']);
        }

        $announcement = Announcement::create($data);

        $media = app(MediaService::class);
        foreach ($request->file('gallery', []) as $i => $file) {
            $path = $media->upload($file, 'announcements/gallery');
            AnnouncementImage::create([
                'announcement_id' => $announcement->id,
                'image_path' => $path,
                'sort_order' => $i,
            ]);
        }

        return redirect()->route('cms.announcements.index')->with('status', 'Announcement created.');
    }

    public function edit(Announcement $announcement)
    {
        $teamMembers = TeamMember::ordered()->get();

        return view('cms.announcements.edit', compact('announcement', 'teamMembers'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|in:'.implode(',', Announcement::CATEGORIES),
            'team_member_id' => 'nullable|exists:team_members,id',
            'summary' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            // Required only if this record has no cover image yet (old rows
            // predating the "always has an image" rule shouldn't get forced
            // to re-upload just to save an unrelated field).
            'cover_image' => ($announcement->cover_image ? 'nullable' : 'required').'|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'status' => 'required|string|in:draft,published,archived',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
        ]);

        unset($data['gallery']);
        $toRemove = collect($data['remove_images'] ?? []);
        unset($data['remove_images']);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['content'] = Announcement::sanitizeContent($data['content'] ?? null);

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

        if ($toRemove->isNotEmpty()) {
            $announcement->images()->whereIn('id', $toRemove)->get()->each->delete();
        }

        $media = app(MediaService::class);
        $nextSort = (int) $announcement->images()->max('sort_order') + 1;
        foreach ($request->file('gallery', []) as $i => $file) {
            $path = $media->upload($file, 'announcements/gallery');
            AnnouncementImage::create([
                'announcement_id' => $announcement->id,
                'image_path' => $path,
                'sort_order' => $nextSort + $i,
            ]);
        }

        return redirect()->route('cms.announcements.index')->with('status', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('cms.announcements.index')->with('status', 'Announcement deleted.');
    }
}
