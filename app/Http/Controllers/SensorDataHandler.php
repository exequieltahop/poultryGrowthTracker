<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorReading;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SensorDataHandler extends Controller
{
    // save sensor readings
    public function saveSensorData(Request $request)
    {
        try {
            // validate request
            $request->validate([
                'temperature' => 'required',
                'humidity' => 'required',
                'amonia' => 'required'
            ]);

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

    // seeder data
    public function seeder()
    {
        try {
            $stoper = 1;

            $min = 30.00;
            $max = 36.99;

            $minl = 1;
            $maxl = 20;

            $minm = 20;
            $maxm = 30;

            $minh = 30;
            $maxh = 40;

            $march_data = Carbon::parse('2025-03-01');
            $april_data = Carbon::parse('2025-04-26');



            $march = 01;
            $april = 01;

            while ($stoper != 56) {

                if ($stoper <= 30) {
                    for ($i = 1; $i <= 16; $i++) {
                        $randomFloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);

                        if ($randomFloat < 33) {
                            $randomFloatHum = $min + mt_rand() / mt_getrandmax() * ($max - $min);
                        }
                        if ($randomFloat >= 33 && $randomFloat < 35) {
                            $randomFloatHum = $minm + mt_rand() / mt_getrandmax() * ($maxm - $minm);
                        }
                        if ($randomFloat >= 35) {
                            $randomFloatHum = $minh + mt_rand() / mt_getrandmax() * ($maxh - $minh);
                        }
                        $randomFloatAmonia = 0 + mt_rand() / mt_getrandmax() * (16 - 0);
                        SensorReading::insert([
                            'temperature' => $randomFloat,
                            'humidity' => $randomFloatHum,
                            'amonia' => $randomFloatAmonia,
                            'created_at' => "2025-03-" . str_pad($march, 2, '0', STR_PAD_LEFT),
                            'updated_at' => "2025-03-" . str_pad($march, 2, '0', STR_PAD_LEFT)
                        ]);
                    }
                    $march++;
                } else if ($stoper >= 30) {

                    for ($i = 1; $i <= 16; $i++) {
                        $randomFloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
                        if ($randomFloat < 33) {
                            $randomFloatHum = $min + mt_rand() / mt_getrandmax() * ($max - $min);
                        }
                        if ($randomFloat >= 33 && $randomFloat < 35) {
                            $randomFloatHum = $minm + mt_rand() / mt_getrandmax() * ($maxm - $minm);
                        }
                        if ($randomFloat >= 35) {
                            $randomFloatHum = $minh + mt_rand() / mt_getrandmax() * ($maxh - $minh);
                        }
                        $randomFloatAmonia = 0 + mt_rand() / mt_getrandmax() * (16 - 0);
                        SensorReading::insert([
                            'temperature' => $randomFloat,
                            'humidity' => $randomFloatHum,
                            'amonia' => $randomFloatAmonia,
                            'created_at' => "2025-04-" . str_pad($april, 2, '0', STR_PAD_LEFT),
                            'updated_at' => "2025-04-" . str_pad($april, 2, '0', STR_PAD_LEFT),
                        ]);
                    }
                    $april++;
                }
                $stoper++;
            };

            return response("Success", 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // get current sensor reading
    public function getCurrentSensorData()
    {
        try {
            $data = SensorReading::getCurrentData();
            return response()->json($data);
        } catch (\Throwable $th) {
            // log error
            // response 500
            Log::error($th->getMessage());
            return response(null, 500);
        }
    }

    // get last ten records
    public function getTenRecord($type)
    {
        try {
            $data = SensorReading::getLastTen($type)
                ->get()
                ->map(function ($query) {
                    $query->date = $query->created_at->format('F. j, Y');
                    return $query;
                });
            return response()->json($data);
        } catch (\Throwable $th) {
            /**
             * log errors
             * response 500
             */
            Log::error($th->getMessage());
            return response(null, 500);
        }
    }

    // filter record
    public function getFilteredRecords(Request $request) {
        try {
            // validate
            $request->validate([
                'type' => 'required',
                'date' => ['required', 'date']
            ]);
            // dd($request->date);
            $data = SensorReading::getFilteredRecord($request->date, $request->type)
                ->get()
                ->map(function ($query) {
                    $query->date = $query->created_at->format('F. j, Y');
                    return $query;
                }); // get readings
            return response()->json($data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(null, 500);
        }
    }
}
