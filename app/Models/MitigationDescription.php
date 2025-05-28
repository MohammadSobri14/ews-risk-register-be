<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MitigationDescription extends Model
{
    use HasUuids;

    protected $fillable = [
        'mitigation_id',
        'description',
    ];

    public function mitigation() {
        return $this->belongsTo(RiskMitigation::class);
    }
}