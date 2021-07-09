<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'showLoginPage'])->name('login.show');
Route::post('/', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::middleware(['auth'])->group(function(){

    Route::get('/home', [HomeController::class, 'showDashboard'])->name('home.dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});
