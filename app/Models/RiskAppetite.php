<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RiskAppetite extends Model
{
    use HasUuids;

    protected $table = 'risk_appetite';

    protected $fillable = [
        'risk_id',
        'controllability',
        'decision',
        'created_by',
    ];

    public function risk() {
        return $this->belongsTo(Risk::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}