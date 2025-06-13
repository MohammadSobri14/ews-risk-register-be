<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RiskMitigation extends Model
{
    use HasUuids;

    protected $fillable = [
        'risk_id',
        'mitigation_type',
        'pic_id',
        'deadline',
        'created_by',
    ];

    public function descriptions() {
        return $this->hasMany(MitigationDescription::class, 'mitigation_id');
    }

    public function risk() {
        return $this->belongsTo(Risk::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pic() {
        return $this->belongsTo(User::class, 'pic_id');
    }
}