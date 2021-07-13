<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
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

    Route::group(['middleware' => ['can:see dashboard']], function(){
        Route::get('/home', [HomeController::class, 'showDashboard'])->name('home.dashboard');

    });


    Route::group(['middleware' => ['can:manage user']], function(){

        /** User Routes */
        Route::get('/users', [UserController::class, 'showListPage'])->name('user.showList');
        Route::patch('/user', [UserController::class, 'statusUpdateById'])->name('user.statusUpdateById');
        Route::delete('/user', [UserController::class, 'deleteById'])->name('user.deleteById');
        Route::get('/user', [UserController::class, 'addNew'])->name('user.createPage');
        Route::post('/user', [UserController::class, 'addNew'])->name('user.addNew');
        Route::get('/user/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user', [UserController::class, 'updateById'])->name('user.updateById');
        /** /User Routes */
    });








    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});
