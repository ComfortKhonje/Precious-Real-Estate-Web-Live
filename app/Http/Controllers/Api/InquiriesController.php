<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    public function index()
    {
        return response()->json(Inquiry::latest()->paginate(20));
    }

    public function show(Inquiry $inquiry)
    {
        return response()->json($inquiry);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'type' => 'nullable|string',
            'message' => 'nullable|string',
            'property_id' => 'nullable|exists:properties,id',
        ]);

        $inquiry = Inquiry::create($data);
        return response()->json($inquiry, 201);
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return response()->json(['deleted' => true]);
    }
}
