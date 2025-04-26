<?php

use App\Http\Controllers\TokenHandler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SensorDataHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function(){ return view('pages.log-in'); })->name('login');
Route::get('/sign-up', function(){ return view('pages.sign-up'); })->name('sign-up');
Route::post('/sign-up-user', [AuthController::class, 'signUpUser']);
Route::post('/login-user', [AuthController::class, 'loginUser']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/generate-session', [TokenHandler::class, 'generate_auth_session'])->name('generate-session');

Route::get('/home', function(){
    if(!Auth::user()){
        return redirect('/');
    }else{
        return view('pages.home');
    }
})->name('home');

Route::get('/get-sensor-current-data', [SensorDataHandler::class, 'getCurrentSensorData']);
Route::get('/get-ten-records/{type}', [SensorDataHandler::class, 'getTenRecord']);

Route::get('/seeder', [SensorDataHandler::class, 'seeder']);
