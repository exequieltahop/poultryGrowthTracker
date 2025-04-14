<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorReading;
use Illuminate\Support\Facades\Log;

class SensorDataHandler extends Controller
{
    public function saveSensorData(Request $request) {
        try {
            // validate request
            // $request->validate([
            //     'temperature' => 'required',
            //     'humidity' => 'required',
            //     'amonia' => 'required'
            // ]);

            // save database
            SensorReading::create([
                'temperature' => $request->temperature,
                'humidity' => $request->humidity,
                'amonia' => $request->amonia,
            ]);

            return response(null, 200);
            // return response(null, 200); // response 200
        } catch (\Throwable $th) {
            Log::error($th->getMessage()); // log error
            return response(null, 500);
        }
    }
}
