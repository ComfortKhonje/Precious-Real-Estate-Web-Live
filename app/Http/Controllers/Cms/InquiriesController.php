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
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        $inquiries = $query->latest()->paginate(20);

        // Distinct real values, not a hardcoded guess — the previous fixed list
        // ('general'/'service'/'property'/'appointment') never matched any type
        // value the app actually writes (real values are service names like
        // "Property Valuation" or "Property Inquiry"), so the filter never
        // worked. Fixed 2026-09-02.
        $types = Inquiry::query()->whereNotNull('type')->distinct()->orderBy('type')->pluck('type');

        return view('cms.inquiries.index', compact('inquiries', 'types'));
    }

    public function show(Inquiry $inquiry)
    {
        return view('cms.inquiries.show', compact('inquiry'));
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('cms.inquiries.index')->with('status', 'Inquiry deleted.');
    }
}
