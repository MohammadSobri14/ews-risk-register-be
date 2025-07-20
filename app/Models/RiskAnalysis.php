<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class RiskAnalysis extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'risk_id',
        'severity',
        'probability',
        'score',
        'grading',
        'created_by',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public static function calculateGrading($score): string
    {
        if ($score >= 1 && $score <= 4) {
            return 'sangat rendah';
        } elseif ($score >= 5 && $score <= 9) {
            return 'rendah';
        } elseif ($score >= 10 && $score <= 15) {
            return 'sedang';
        } elseif ($score >= 16 && $score <= 20) {
            return 'tinggi';
        } else {
            return 'sangat tinggi';
        }
    }


    public function risk(): BelongsTo
    {
        return $this->belongsTo(Risk::class);
    }


    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
