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
            $model->score = $model->severity * $model->probability;
            $model->grading = self::calculateGrading($model->score);
        });
    }

    public static function calculateGrading($score): string
    {
        return match (true) {
            $score >= 15 => 'Merah',
            $score >= 9 => 'Kuning',
            $score >= 4 => 'Hijau',
            default => 'Biru',
        };
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