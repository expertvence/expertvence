<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;
use Stevebauman\Location\Facades\Location;
use App\Mail\ContactConfirmation; // ✅ THIS WAS MISSING

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
        \Log::info('Contact form payload', $request->all());

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
        ]);

        $contact = Contact::create($validated);

        // Send mail to admin
        Mail::to(config('mail.from.address'))
            ->queue(new ContactNotification($contact));

        Mail::to($contact->email)
            ->queue(new ContactConfirmation($contact));


        return response()->json(['success' => true, 'message' => 'Message sent successfully!']);
    }
}
