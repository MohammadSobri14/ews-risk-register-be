<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RiskValidation extends Model
{
    use HasUuids;

    protected $fillable = [
        'risk_id',
        'validated_by',
        'is_approved',
        'notes',
    ];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}