<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;
use Stevebauman\Location\Facades\Location;

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:50',
            'dial_code' => 'required|string|max:10',
            'country_name' => 'required|string|max:255',
            'country_iso' => 'required|string|max:10',
            'interest' => 'required|string|max:255',
            'message' => 'required|string',
            'has_whatsapp' => 'boolean',
            'has_telegram' => 'boolean',
            'telegram_username' => 'nullable|string|max:255',
        ]);

        // Save to database
        $contact = Contact::create($validated);

        \Log::info('Contact saved', ['id' => $contact->id]);

        try {
            // Send email
            Mail::to(config('mail.from.address'))->send(new ContactNotification($contact));
            \Log::info('Contact mail sent', ['id' => $contact->id]);
        } catch (\Throwable $e) {
            \Log::error('Contact mail failed', ['error' => $e->getMessage()]);
        }

        return response()->json(['success' => true]);
    }
}
