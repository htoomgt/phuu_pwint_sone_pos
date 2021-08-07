<?php

use App\Http\Controllers\DropdownDataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductMeasureUnitController;
use App\Models\ProductMeasureUnit;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;

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

    /** Point of Sale Routes */
        Route::get('/point-of-sale', [SaleController::class, 'showMainSalePage'])->name('sale.main');
        Route::post('/pos-make-payment', [SaleController::class, 'makePayment'])->name('sale.payment');
        Route::post('/pos-print-slip', [SaleController::class, 'printSlip'])->name('sale.printSlip');
        Route::delete('/delete-sale-voucher', [SaleController::class, 'deleteSaleVoucher'])->name('sale.delete');

    /** /Point of Sale Routes */


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

    /**  Manage Product Routes */
    Route::middleware(['can:manage product'])->group(function(){

        /**Product Routes */
        Route::name('product.')->group(function(){
            Route::get('/products', [ProductController::class, 'showListPage'])->name('showList');
            Route::patch('/product', [ProductController::class, 'statusUpdateById'])->name('statusUpdateById');
            Route::delete('/product', [ProductController::class, 'deleteById'])->name('deleteById');
            Route::get('/product', [ProductController::class, 'create'])->name('create');
            Route::get('/product/get/', [ProductController::class, 'getDataRowById'])->name('getDataRowById');
            Route::post('/product', [ProductController::class, 'addNew'])->name('addNew');
            Route::get('/product/{product}', [ProductController::class, 'edit'])->name('edit');
            Route::put('/product', [ProductController::class, 'updateById'])->name('updateById');
        });

        /** /Product Routes */

        /** Product Purchase */
        Route::name('productPurchase.')->group(function(){
            Route::get('/productPurchases', [PurchaseController::class, 'showListPage'])->name('showList');
            Route::patch('/productPurchase', [PurchaseController::class, 'statusUpdateById'])->name('statusUpdateById');
            Route::delete('/productPurchase', [PurchaseController::class, 'deleteById'])->name('deleteById');
            Route::get('/productPurchase', [PurchaseController::class, 'create'])->name('create');
            Route::get('/productPurchase/get/', [PurchaseController::class, 'getDataRowById'])->name('getDataRowById');
            Route::post('/productPurchase', [PurchaseController::class, 'addNew'])->name('addNew');
            Route::get('/productPurchase/{id}', [PurchaseController::class, 'edit'])->name('edit');
            Route::put('/productPurchase', [PurchaseController::class, 'updateById'])->name('updateById');
        });

        /** /Product Purchase */

        /**Product Category Routes */
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
        /** /Product Category Routes */


        /** Product Measure Unit */
        Route::name('productMeasureUnit.')->group(function(){
            Route::get('/productMeasureUnits', [ProductMeasureUnitController::class, 'showListPage'])->name('showList');
            Route::patch('/productMeasureUnit', [ProductMeasureUnitController::class, 'statusUpdateById'])->name('statusUpdateById');
            Route::delete('/productMeasureUnit', [ProductMeasureUnitController::class, 'deleteById'])->name('deleteById');
            Route::get('/productMeasureUnit/get/', [ProductMeasureUnitController::class, 'getDataRowById'])->name('getDataRowById');
            Route::post('/productMeasureUnit', [ProductMeasureUnitController::class, 'addNew'])->name('addNew');
            Route::put('/productMeasureUnit', [ProductMeasureUnitController::class, 'updateById'])->name('updateById');
        });


    });
    /** /Manage Product Route */






    Route::prefix('dropdown-data')->name('dropdownData.')->group(function(){
        Route::post('/all-roles', [DropdownDataController::class, 'getAllRoles'])->name('getAllRoles');
        Route::post('/all-product-categories', [DropdownDataController::class, 'getAllProductCategories'])->name('getAllProductCategories');
        Route::post('/all-product-measure-units', [DropdownDataController::class, 'getProductMeasureUnits'])->name('getProductMeasureUnits');
        Route::post('/all-products', [DropdownDataController::class, 'getAllProducts'])->name('getAllProducts');

        Route::post('/all-products-filter-by-names', [DropdownDataController::class, 'getProductByNames'])->name('getProductAllByNames');
        Route::post('/all-products-filter-by-code', [DropdownDataController::class, 'getProductByNames'])->name('getProductAllByCode');
    });








    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});
