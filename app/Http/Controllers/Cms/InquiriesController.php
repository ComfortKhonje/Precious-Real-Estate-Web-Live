<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            // Grouped: without the closure the trailing orWhere('type', ...)
            // below escaped this whole clause — a search combined with the
            // type filter matched any name/email/phone regardless of type,
            // since SQL AND binds tighter than OR. Same bug shape already
            // fixed on Properties' index.
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        $inquiries = $query->latest()->paginate(20)->withQueryString();

        // Distinct real values, not a hardcoded guess — the previous fixed list
        // ('general'/'service'/'property'/'appointment') never matched any type
        // value the app actually writes (real values are service names like
        // "Property Valuation" or "Property Inquiry"), so the filter never
        // worked. Fixed 2026-09-02.
        $types = Inquiry::query()->whereNotNull('type')->distinct()->orderBy('type')->pluck('type');

        $newCount = Inquiry::whereNull('viewed_at')->count();

        return view('cms.inquiries.index', compact('inquiries', 'types', 'newCount'));
    }

    public function show(Inquiry $inquiry)
    {
        if ($inquiry->viewed_at === null) {
            $inquiry->update(['viewed_at' => now()]);
        }

        return view('cms.inquiries.show', compact('inquiry'));
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('cms.inquiries.index')->with('status', 'Inquiry deleted.');
    }
}
