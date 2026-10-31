<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Setting extends Model
{
    protected $table = 'settings';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'key',
        'value',
        'group',
        'type',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Get a setting by key.
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, $value, string $group = 'general', string $type = 'text', ?string $description = null)
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
                'description' => $description,
            ]
        );
    }

    /**
     * Get all public settings as key-value pairs.
     */
    public static function getAllPublic(): array
    {
        $keys = [
            'site_name',
            'site_tagline',
            'site_logo',
            'site_email',
            'site_phone',
            'site_address',
            'facebook_url',
            'linkedin_url',
            'twitter_url',
            'whatsapp_number',
            'whatsapp_consultant_number',
            'footer_description',
        ];

        $settings = static::whereIn('key', $keys)->pluck('value', 'key')->toArray();

        // Defaults
        return array_merge([
            'site_name' => 'Expertvence',
            'site_tagline' => 'Software',
            'site_logo' => '',
            'site_email' => 'info@expertvence.com',
            'site_phone' => '+880 1797488350',
            'site_address' => 'Dhaka, Bangladesh',
            'facebook_url' => 'https://www.facebook.com/profile.php?id=100079079156709',
            'linkedin_url' => '',
            'twitter_url' => '',
            'whatsapp_number' => '+8801797488350',
            'whatsapp_consultant_number' => '+8801797488350',
            'footer_description' => 'Web applications, digital marketing, professional page management, and ready-made software for your business.',
        ], $settings);
    }
}
