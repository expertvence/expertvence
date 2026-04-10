<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone_number',
        'country_name', 'country_iso',
        'interest', 'message',
        'has_whatsapp', 'has_telegram',
        'telegram_username',
        'agreed_terms', // ✅ ADD THIS
    ];
}
