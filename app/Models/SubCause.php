<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCause extends Model
{
    use HasFactory;

    protected $fillable = ['cause_id', 'sub_cause'];

    public function cause()
    {
        return $this->belongsTo(Cause::class);
    }
}