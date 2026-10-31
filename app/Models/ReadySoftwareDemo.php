<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ReadySoftwareDemo extends Model
{
    use HasUuids;

    protected $table = 'ready_software_demos';

    protected $fillable = [
        'icon', 'tag', 'title', 'description', 'features', 'demo_url', 'admin_demo_url',
        'admin_demo_email', 'admin_demo_password', 'user_demo_url', 'user_demo_email',
        'user_demo_password', 'website_url', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
