<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class NewsController extends Controller
{
    /**
     * Display a listing of the published news/announcements.
     */
    public function index()
    {
        $news = Announcement::published()
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $featured = Announcement::published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->first();

        return view('news.index', compact('news', 'featured'));
    }

    /**
     * Display the specified news/announcement.
     */
    public function show($id)
    {
        $article = Announcement::published()->findOrFail($id);

        $recentNews = Announcement::published()
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('news.show', compact('article', 'recentNews'));
    }
}
