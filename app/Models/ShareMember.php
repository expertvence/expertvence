<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ShareMember extends Model
{
    use HasUuids;

    protected $table = 'share_members';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'designation',
        'image',
        'phone',
        'email',
    ];

    public function profitDistributions()
    {
        return $this->hasMany(ProfitDistribution::class, 'member_id');
    }

    public function getTotalProfitReceivedAttribute()
    {
        return $this->profitDistributions()->sum('amount');
    }
}
