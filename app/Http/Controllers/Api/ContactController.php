<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;
use Stevebauman\Location\Facades\Location;
use App\Mail\ContactConfirmation; // ✅ THIS WAS MISSING
use Illuminate\Support\Facades\Http;


class ContactController extends Controller
{
    /**
     * Detect user country by IP
     */
    public function detectCountry(Request $request)
    {
        try {
            $ip = $request->ip();

            // Localhost fallback
            if ($ip === '127.0.0.1' || $ip === '::1') {
                return response()->json([
                    'iso' => 'BD',
                    'country' => 'Bangladesh',
                    'source' => 'local-fallback'
                ]);
            }

            $location = Location::get($ip);

            return response()->json([
                'iso' => $location->countryCode ?? 'US',
                'country' => $location->countryName ?? 'United States',
                'source' => 'geoip'
            ]);
        } catch (\Throwable $e) {
            \Log::error('Country detect failed', ['error' => $e->getMessage()]);

            return response()->json([
                'iso' => 'US',
                'country' => 'United States',
                'source' => 'error-fallback'
            ], 200);
        }
    }

    /**
     * Store contact form submission
     */
   public function store(Request $request)
{
    // Validate required fields first
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone_number' => 'required',
        'dial_code' => 'required',
        'country_name' => 'required',
        'country_iso' => 'required',
        'interest' => 'required',
        'message' => 'required',
        'has_whatsapp' => 'boolean',
        'has_telegram' => 'boolean',
        'telegram_username' => 'nullable|string',
        'agreed_terms' => 'required|boolean|accepted', // ✅ NEW
        'recaptcha_token' => 'required|string',
    ]);

    // Verify reCAPTCHA v3
    $recaptcha_secret = env('RECAPTCHA_SECRET_KEY');
    $recaptcha_response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => $recaptcha_secret,
        'response' => $validated['recaptcha_token']
    ])->json();

    \Log::info('reCAPTCHA response', $recaptcha_response); // debug

    if (!($recaptcha_response['success'] ?? false) || ($recaptcha_response['score'] ?? 0) < 0.5) {
        return response()->json([
            'message' => 'reCAPTCHA validation failed. Please try again.'
        ], 422);
    }

    // Store contact
    $contact = Contact::create($validated);

    // Send emails
    Mail::to(config('mail.from.address'))->queue(new ContactNotification($contact));
    Mail::to($contact->email)->queue(new ContactConfirmation($contact));

    return response()->json(['success' => true, 'message' => 'Message sent successfully!']);
}

}
