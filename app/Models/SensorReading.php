<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class SensorReading extends Model
{
    use HasApiTokens, SoftDeletes;

    // fillables
    protected $fillable = [
        'temperature',
        'humidity',
        'amonia'
    ];
}
