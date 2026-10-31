<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemoView extends Model
{
    protected $fillable = [
        'ready_software_demo_id', 'user_id', 'visitor_ip', 'user_agent',
    ];

    public function demo()
    {
        return $this->belongsTo(ReadySoftwareDemo::class, 'ready_software_demo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
