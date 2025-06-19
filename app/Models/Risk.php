<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Risk extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'cluster',
        'unit',
        'name',
        'category',
        'description',
        'impact',
        'uc_c',
        'status',
        'created_by',
    ];

    public function causes()
    {
        return $this->hasMany(Cause::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function validations()
    {
        return $this->hasMany(RiskValidation::class);
    }

    public function analysis()
    {
        return $this->hasOne(RiskAnalysis::class, 'risk_id');
    }

    public function riskAppetite()
    {
        return $this->hasOne(RiskAppetite::class)->latestOfMany();
    }

    public function mitigations()
    {
        return $this->hasMany(RiskMitigation::class);
    }

    public function handlings()
    {
        return $this->hasMany(RiskHandling::class);
    }


}