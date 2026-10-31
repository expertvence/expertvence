<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Project extends Model
{
    use HasUuids;

    protected $table = 'projects';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'client_name',
        'client_address',
        'client_phone',
        'project_url',
        'budget',
        'status',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
    ];

    public function transactions()
    {
        return $this->hasMany(ProjectTransaction::class, 'project_id');
    }

    public function getIncomeTotalAttribute()
    {
        return $this->transactions()->where('type', 'income')->sum('amount');
    }

    public function getExpenseTotalAttribute()
    {
        return $this->transactions()->where('type', 'expense')->sum('amount');
    }
}
