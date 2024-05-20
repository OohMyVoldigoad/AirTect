<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\AQIController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', ([PageController::class,'welcomePage']))
->name('welcomePage');

Route::get('/home', ([PageController::class,'welcomePage']))
->name('homePage');

Route::middleware('guest')->group(function(){
    
    Route::get('/login', ([PageController::class,'showLoginPage']))
    ->name('loginPage');

    Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');

    Route::post('/fetch-aqi', [AQIController::class, 'fetchAndSaveAQI'])->name('fetchAqi');
    
    Route::get('/input', function () {
        return view('input');
    })->name('input');

    Route::get('/database', function () {
        return view('database');
    })->name('database');
});

Route::middleware('auth')->group(function(){
    Route::get('/logout', ([AuthController::class, 'logout']))
    ->name('logout');

    Route::get('/dashboardAdmin',([PageController::class,'dashboardAdmin']))
    ->name('dashboardAdmin');

    Route::post('/sarans/store', [CreateController::class, 'storeSaran'])->name('sarans.store');
});