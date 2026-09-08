<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\InquiryFormSubmission;
use App\Models\Inquiry;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    /**
     * Store a new inquiry from public frontend form (no authentication required)
     * Handles multi-step inquiry form with service-specific fields
     */
    public function storePublic(Request $request)
    {
        // Honeypot — see resources/views/components/shared/honeypot.blade.php.
        // A human never fills this field; a bot that blindly fills every
        // field does. Return the normal success response without creating a
        // row or sending mail, so an adaptive bot can't tell which field
        // gave it away.
        if ($request->filled('website')) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your inquiry. Our team will get back to you within 24 hours.',
            ], 201);
        }

        $data = $request->validate([
            'service' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'contactMethod' => 'required|string|in:Phone,Email,WhatsApp',
            'location' => 'nullable|string|max:255',
            'property_id' => 'nullable|exists:properties,id',
            'additionalDetails' => 'nullable|string',
            // Service-specific fields (optional depending on service)
            'propertyType' => 'nullable|string',
            'purposeOfValuation' => 'nullable|string',
            'estimatedPropertySize' => 'nullable|string',
            'managementNeeds' => 'nullable|string',
            'numberOfProperties' => 'nullable|string',
            'inquiryType' => 'nullable|string',
            'budgetAskingPrice' => 'nullable|string',
            'projectType' => 'nullable|string',
            // Was missing — Property Development's "Service Needed" dropdown
            // (formData.serviceNeeded) got silently dropped by validate()
            // and never made it into the stored message or the email.
            // Fixed 2026-09-08, alongside the review-step display bug for
            // the same field.
            'serviceNeeded' => 'nullable|string',
            'projectStage' => 'nullable|string',
            'currentStatus' => 'nullable|string',
            'inquiryTopic' => 'nullable|string',
            'preferredService' => 'nullable|string',
        ]);

        // Store all data as JSON in message field for reference
        $data['type'] = $data['service'];
        $data['message'] = json_encode([
            'service' => $data['service'],
            'contactMethod' => $data['contactMethod'],
            'location' => $data['location'] ?? null,
            'additionalDetails' => $data['additionalDetails'] ?? null,
            'serviceFields' => [
                'propertyType' => $data['propertyType'] ?? null,
                'purposeOfValuation' => $data['purposeOfValuation'] ?? null,
                'estimatedPropertySize' => $data['estimatedPropertySize'] ?? null,
                'managementNeeds' => $data['managementNeeds'] ?? null,
                'numberOfProperties' => $data['numberOfProperties'] ?? null,
                'inquiryType' => $data['inquiryType'] ?? null,
                'budgetAskingPrice' => $data['budgetAskingPrice'] ?? null,
                'projectType' => $data['projectType'] ?? null,
                'serviceNeeded' => $data['serviceNeeded'] ?? null,
                'projectStage' => $data['projectStage'] ?? null,
                'currentStatus' => $data['currentStatus'] ?? null,
                'inquiryTopic' => $data['inquiryTopic'] ?? null,
                'preferredService' => $data['preferredService'] ?? null,
            ],
        ]);

        // Create inquiry
        $inquiry = Inquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'type' => $data['type'],
            'message' => $data['message'],
            'property_id' => $data['property_id'] ?? null,
        ]);

        // Email notification. CMS's own "Inquiry Notification Email"
        // setting (Settings tab) wins when set — it existed as a saveable
        // field long before anything actually read it back; falls back to
        // config('mail.to_address') (env MAIL_TO_ADDRESS, defaulting to
        // info@preciousrealestate.mw) when unset.
        $toEmail = Setting::where('key', 'inquiry_email_destination')->value('value')
            ?: config('mail.to_address');

        Mail::to($toEmail)->send(new InquiryFormSubmission($data, config('mail.signature', '')));

        return response()->json([
            'success' => true,
            'inquiry' => $inquiry,
            'message' => 'Thank you for your inquiry. Our team will get back to you within 24 hours.',
        ], 201);
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return response()->json(['deleted' => true]);
    }
}
