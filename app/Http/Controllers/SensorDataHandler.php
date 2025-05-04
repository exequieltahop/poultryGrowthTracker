<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorReading;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
            SensorReading::insert([
                'temperature' => $request->temperature,
                'humidity' => $request->humidity,
                'amonia' => $request->amonia,
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila'),
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
            $data->created_at_formatted = Carbon::parse($data->created_at)
                ->timezone('Asia/Manila');
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
    public function getFilteredRecords(Request $request)
    {
        try {
            // validate
            $request->validate([
                'type' => 'required',
                'date' => ['required', 'date']
            ]);
            // dd($request->date);
            $data = SensorReading::getFilteredRecord($request->date, $request->type)
                ->limit(50)
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

    // get data table data logs
    public static function getDataTableLogsData()
    {
        try {
            //get all data in desc order
            $data = SensorReading::select('*')
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            return $data; // return json response
        } catch (\Throwable $th) {
            /**
             * log error
             * response 500
             */
            Log::error($th->getMessage());
            return response(null, 500);
        }
    }

    public function updateTime($date)
    {
        try {
            // Get the count of records for the given date
            $getCount = SensorReading::whereDate('created_at', $date)->count();

            // Initialize the time as 6:00:00
            $time = Carbon::createFromFormat('H:i:s', '06:00:00');

            // Loop through the records
            for ($i = 1; $i <= $getCount; $i++) {
                // Update the created_at field with the incremented time
                SensorReading::where('id', $i)
                    ->update([
                        'created_at' => $date . ' ' . $time->format('H:i:s'), // Format the time to 'Y-m-d H:i:s'
                    ]);

                // Increment the time by 5 seconds
                $time->addMinutes(5);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // fuzy logic
    public static function controlDevices($temperature, $humidity, $ammonia)
    {
        $fanOn = false;
        $bulbOn = false;

        // Very hot — turn on fan
        if ($temperature > 35.0) {
            $fanOn = true;

            if ($humidity < 50.0) {
                // Dry & hot — just fan
                $bulbOn = false;
            } else {
                // Hot & humid — fan only, no bulb
                $bulbOn = false;
            }
        }
        // Temperature between 33 and 35 degrees
        else if ($temperature >= 33.0 && $temperature < 35.0) {
            if ($humidity >= 45.0 && $humidity <= 65.0 && $ammonia >= 5.0 && $ammonia <= 15.0) {
                // Comfortable zone — no fan, no bulb
                $fanOn = false;
                $bulbOn = false;
            } else if ($ammonia > 15.0) {
                // Dangerous ammonia, even if temp/humidity are okay
                $fanOn = true;
                $bulbOn = false;
            } else {
                // Slight adjustments
                $fanOn = false;
                $bulbOn = false;
            }
        }
        // Cold environment
        else if ($temperature < 33.0) {
            if ($humidity < 45.0 && $ammonia < 5.0) {
                // Cold & dry — turn on bulb for heat
                $fanOn = false;
                $bulbOn = true;
            } else if ($humidity > 65.0 || $ammonia > 15.0) {
                // Cold but bad air quality — fan & bulb both
                $fanOn = true;
                $bulbOn = true;
            } else {
                // Cold but tolerable
                $fanOn = false;
                $bulbOn = false;
            }
        }

        return ['fanOn' => $fanOn, 'bulbOn' => $bulbOn];
    }
}
