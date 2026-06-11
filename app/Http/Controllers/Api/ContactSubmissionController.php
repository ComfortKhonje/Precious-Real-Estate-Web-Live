<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    /**
     * Store a new contact form submission from public frontend
     * No authentication required
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'serviceNeeded' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Create inquiry from contact form
        $inquiry = Inquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'type' => $data['serviceNeeded'],
            'message' => $data['message'],
            'property_id' => null,
        ]);

        return response()->json([
            'success' => true,
            'inquiry' => $inquiry,
            'message' => 'Thank you for contacting us. We will get back to you shortly.',
        ], 201);
    }
}
