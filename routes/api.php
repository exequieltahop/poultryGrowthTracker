<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorDataHandler;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/sensor-data', [SensorDataHandler::class, 'saveSensorData']);
Route::get('/hello', function () {
    return 'hello';
});
