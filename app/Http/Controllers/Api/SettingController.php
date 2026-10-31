<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * Get public site settings
     */
    public function getPublicSettings()
    {
        $settings = Setting::getAllPublic();
        return response()->json([
            'status' => 'success',
            'data' => $settings,
        ]);
    }

    /**
     * Get settings for Admin panel
     */
    public function getAdminSettings()
    {
        $settings = Setting::getAllPublic();
        return response()->json([
            'status' => 'success',
            'data' => $settings,
        ]);
    }

    /**
     * Update settings from Admin panel
     */
    public function updateAdminSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:100',
            'site_tagline' => 'nullable|string|max:100',
            'site_email' => 'nullable|email|max:100',
            'site_phone' => 'nullable|string|max:50',
            'site_address' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:50',
            'whatsapp_consultant_number' => 'nullable|string|max:50',
            'footer_description' => 'nullable|string|max:500',
            'site_logo_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        // Handle logo file upload
        if ($request->hasFile('site_logo_file')) {
            $file = $request->file('site_logo_file');
            $uploadDir = public_path('uploads/settings');

            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $filename = 'logo_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);

            $logoUrl = '/uploads/settings/' . $filename;
            Setting::set('site_logo', $logoUrl, 'general', 'image', 'Website Logo');
        } elseif ($request->has('site_logo') && $request->site_logo === '') {
            // Admin explicitly cleared the custom logo to revert to default SVG
            Setting::set('site_logo', '', 'general', 'image', 'Website Logo');
        }

        // Update text settings
        $fields = [
            'site_name' => 'Site Name',
            'site_tagline' => 'Site Tagline',
            'site_email' => 'Site Email',
            'site_phone' => 'Site Phone',
            'site_address' => 'Site Address',
            'facebook_url' => 'Facebook URL',
            'linkedin_url' => 'LinkedIn URL',
            'twitter_url' => 'Twitter URL',
            'whatsapp_number' => 'Expertvence WhatsApp Number',
            'whatsapp_consultant_number' => 'Consultant WhatsApp Number',
            'footer_description' => 'Footer Description',
        ];

        foreach ($fields as $field => $desc) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field, ''), 'general', 'text', $desc);
            }
        }

        $updated = Setting::getAllPublic();

        return response()->json([
            'status' => 'success',
            'message' => 'Settings saved successfully!',
            'data' => $updated,
        ]);
    }
}
