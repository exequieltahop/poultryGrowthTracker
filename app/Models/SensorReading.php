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

    // get current data
    public static function getCurrentData() {
        try {
            return self::select('*')->orderBy('created_at', 'desc')->first();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // scope get ten last records
    public function scopeGetLastTen($query, string $type) {
        try {
            return $query->select($type, 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(10);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // filtered records
    public function scopeGetFilteredRecord($query, $date, $type) {
        try {
            return $query->select($type, 'created_at')
                ->whereDate('created_at', $date)
                ->orderBy('created_at', 'desc');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
