<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * 2026-09-04: was a static `__invoke()` returning a view with three
 * hardcoded "Coming soon" entries and no real data at all — the nicer of
 * two competing nav tabs ('Updates' vs 'News') but the non-functional one.
 * 'News' (the old NewsController, now removed) was the functional half —
 * this controller absorbs that logic so /updates is both the good layout
 * and the real data. Old /news URLs 301-redirect here (see routes/web.php).
 *
 * 2026-09-05: added category filtering — the sidebar previously carried
 * static "what our announcements entail" marketing copy with no real
 * function; it's now a real filter into Announcement::CATEGORIES.
 */
class UpdatesController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->get('category');
        if (! in_array($category, Announcement::CATEGORIES, true)) {
            $category = null;
        }

        $query = Announcement::published()->orderBy('published_at', 'desc');

        if ($category) {
            $query->where('category', $category);
        }

        $news = $query->paginate(9)->withQueryString();

        // The featured pick is a global "pinned" article — only shown on
        // the unfiltered view, since surfacing it while someone's filtered
        // to one category would be confusing if it doesn't match.
        $featured = $category
            ? null
            : Announcement::published()->featured()->orderBy('published_at', 'desc')->first();

        $categoryCounts = Announcement::published()
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('pages.updates', [
            'news' => $news,
            'featured' => $featured,
            'activeCategory' => $category,
            'categoryCounts' => $categoryCounts,
        ]);
    }

    public function show($id): View
    {
        $article = Announcement::published()->findOrFail($id);

        $recentUpdates = Announcement::published()
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('pages.updates-show', compact('article', 'recentUpdates'));
    }
}
