<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    // fillables
    protected $fillable = [
        'temperature',
        'humidity',
        'amonia'
    ];
}
