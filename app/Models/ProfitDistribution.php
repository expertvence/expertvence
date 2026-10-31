<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProfitDistribution extends Model
{
    use HasUuids;

    protected $table = 'profit_distributions';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'member_id',
        'amount',
        'distribution_date',
        'comment',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'distribution_date' => 'date:Y-m-d',
    ];

    public function member()
    {
        return $this->belongsTo(ShareMember::class, 'member_id');
    }
}
