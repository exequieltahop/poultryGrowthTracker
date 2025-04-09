<?php

use App\Http\Controllers\TokenHandler;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){ return view('pages.log-in'); })->name('login');
Route::post('/generate-session', [TokenHandler::class, 'generate_auth_session'])->name('generate-session');

Route::get('/home', function(){ return view('pages.home'); })->name('home');