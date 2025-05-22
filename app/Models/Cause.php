<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cause extends Model
{
    use HasFactory;

    protected $fillable = ['risk_id', 'main_cause'];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }

    public function subCauses()
    {
        return $this->hasMany(SubCause::class);
    }
}