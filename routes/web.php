<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;

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

Route::middleware('guest')->group(function(){
    Route::get('/', ([PageController::class,'welcomePage']))
    ->name('welcomePage');

    Route::get('/home', ([PageController::class,'welcomePage']))
    ->name('homePage');
    
    Route::get('/login', ([PageController::class,'showLoginPage']))
    ->name('loginPage');

    Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
});

Route::middleware('auth')->group(function(){
    Route::get('/logout', ([AuthController::class, 'logout']))
    ->name('logout');

    Route::get('/dashboardAdmin',([PageController::class,'dashboardAdmin']))
    ->name('dashboardAdmin');
});