<?php

use App\Http\Controllers\DropdownDataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductCategoryController;
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

    Route::middleware(['can:see dashboard'])->group(function(){
        Route::get('/home', [HomeController::class, 'showDashboard'])->name('home.dashboard');

    });

    Route::get('/point-of-sale', function(){
        return "Here is point of sale page";
    })->name('sale.point');


    /** User Routes */
    Route::middleware(['can:manage user'])->name('user.')->group(function(){
        Route::get('/users', [UserController::class, 'showListPage'])->name('showList');
        Route::patch('/user', [UserController::class, 'statusUpdateById'])->name('statusUpdateById');
        Route::delete('/user', [UserController::class, 'deleteById'])->name('deleteById');
        Route::get('/user', [UserController::class, 'create'])->name('create');
        Route::post('/user', [UserController::class, 'addNew'])->name('addNew');
        Route::get('/user/{user}', [UserController::class, 'edit'])->name('edit');
        Route::put('/user', [UserController::class, 'updateById'])->name('updateById');
        Route::get('/username-unique-check', [UserController::class, 'usernameUniqueCheck'])->name('usernameUniqueCheck');
        Route::get('/check-current-password', [UserController::class, 'checkCurrentPassword'])->name('checkCurrentPassword');
    });
    /** /User Routes */

    /**  Manage Product Route */
    Route::middleware(['can:manage product'])->group(function(){

        /**Product CRUD */

        /** /Product CRUD */

        /**Product Category CRUD */
        Route::name('productCategory.')->group(function(){
            Route::get('/productCategories', [ProductCategoryController::class, 'showListPage'])->name('showList');
            Route::patch('/productCategory', [ProductCategoryController::class, 'statusUpdateById'])->name('statusUpdateById');
            Route::delete('/productCategory', [ProductCategoryController::class, 'deleteById'])->name('deleteById');
            Route::get('/productCategory', [ProductCategoryController::class, 'create'])->name('create');
            Route::get('/productCategory/get/', [ProductCategoryController::class, 'getDataRowById'])->name('getDataRowById');
            Route::post('/productCategory', [ProductCategoryController::class, 'addNew'])->name('addNew');
            Route::get('/productCategory/{productCategory}', [ProductCategoryController::class, 'edit'])->name('edit');
            Route::put('/productCategory', [ProductCategoryController::class, 'updateById'])->name('updateById');
        });


        /** /Product Category CRUD */


    });
    /** /Manage Product Route */






    Route::prefix('dropdown-data')->name('dropdownData.')->group(function(){
        Route::post('/all-roles', [DropdownDataController::class, 'getAllRoles'])->name('getAllRoles');
    });








    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});
