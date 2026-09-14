<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormSubmission;
use App\Models\Inquiry;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactSubmissionController extends Controller
{
    /**
     * Store a new contact form submission from public frontend
     * No authentication required
     */
    public function store(Request $request)
    {
        // Honeypot — see resources/views/components/shared/honeypot.blade.php.
        // A human never fills this field; a bot that blindly fills every
        // field does. Return the normal success response without creating a
        // row or sending mail, so an adaptive bot can't tell which field
        // gave it away.
        if ($request->filled('website')) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for contacting us. We will get back to you shortly.',
            ], 201);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'serviceNeeded' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Create inquiry from contact form
        Inquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'type' => $data['serviceNeeded'],
            'message' => $data['message'],
            'property_id' => null,
        ]);

        // Same destination lookup as the inquiry flow — CMS setting first,
        // env/config fallback second.
        $toEmail = Setting::where('key', 'inquiry_email_destination')->value('value')
            ?: config('mail.to_address');

        // Saved already — a mail failure must not show the visitor an error
        // (see the same note in InquiriesController::storePublic()).
        try {
            Mail::to($toEmail)->send(new ContactFormSubmission($data, config('mail.signature', '')));
        } catch (\Throwable $e) {
            report($e);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you for contacting us. We will get back to you shortly.',
        ], 201);
    }
}
