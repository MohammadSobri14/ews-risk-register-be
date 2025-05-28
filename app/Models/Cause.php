<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// app/Models/Cause.php

class Cause extends Model
{
    use HasFactory;

    protected $fillable = ['risk_id', 'category', 'main_cause'];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }

    public function subCauses()
    {
        return $this->hasMany(SubCause::class);
    }

}