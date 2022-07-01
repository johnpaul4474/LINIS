<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//materials
Route::get('/home', [App\Http\Controllers\Linen\LinenInventoryController::class, 'index'])->name('home');
Route::any('/material', [App\Http\Controllers\Linen\LinenInventoryController::class, 'create'])->name('material');
Route::post('/material/add', [App\Http\Controllers\Linen\LinenInventoryController::class, 'store'])->name('material/add');
Route::post('/material/delete', [App\Http\Controllers\Linen\LinenInventoryController::class, 'destroy'])->name('material/delete');
Route::post('/material/update', [App\Http\Controllers\Linen\LinenInventoryController::class, 'update'])->name('material/update');

//stockroom
Route::any('/stockroom', [App\Http\Controllers\Stockroom\StockRoomController::class, 'index'])->name('stockroom');
Route::post('/stockroom/add', [App\Http\Controllers\Stockroom\StockRoomController::class, 'store'])->name('stockroom/add');
Route::post('/stockroom/delete', [App\Http\Controllers\Stockroom\StockRoomController::class, 'destroy'])->name('stockroom/delete');
Route::post('/stockroom/update', [App\Http\Controllers\Stockroom\StockRoomController::class, 'update'])->name('stockroom/update');

//storage
Route::post('/stockroom/storage/add', [App\Http\Controllers\Stockroom\StorageController::class, 'addStorage'])->name('stockroom/storage/add');
Route::post('/stockroom/storage/update', [App\Http\Controllers\Stockroom\StorageController::class, 'updateStorage'])->name('stockroom/storage/update');
Route::post('/stockroom/storage/delete', [App\Http\Controllers\Stockroom\StorageController::class, 'destroy'])->name('stockroom/storage/delete');

//products
Route::any('/products', [App\Http\Controllers\Linen\ProductsController::class, 'index'])->name('products');
Route::post('/products/add', [App\Http\Controllers\linen\ProductsController::class, 'addProduct'])->name('products/add');
Route::post('/products/delete', [App\Http\Controllers\linen\ProductsController::class, 'destroy'])->name('products/delete');
Route::post('/products/update', [App\Http\Controllers\linen\ProductsController::class, 'update'])->name('products/update');


//services 
Route::any('/services', [App\Http\Controllers\Request\ServiceController::class, 'index'])->name('services');





//issuance
Route::any('/issuance', [App\Http\Controllers\Issuance\IssuanceController::class, 'index'])->name('issuance');
Route::post('/issueProduct', [App\Http\Controllers\Issuance\IssuanceController::class, 'issueProduct'])->name('/issueProduct');
Route::post('/condemned/delete', [App\Http\Controllers\Issuance\IssuanceController::class, 'destroy'])->name('/condemned/delete');

//re-issue
Route::any('/returnedProducts', [App\Http\Controllers\Issuance\ReturnedProductsController::class, 'index'])->name('returnedProducts');
Route::post('/returningProducts', [App\Http\Controllers\Issuance\ReturnedProductsController::class, 'returningProducts'])->name('/returningProducts');
Route::post('/condemned/delete', [App\Http\Controllers\Issuance\ReturnedProductsController::class, 'destroy'])->name('/condemned/delete');
Route::any('/condemned', [App\Http\Controllers\Issuance\ReturnedProductsController::class, 'condemned'])->name('/condemned');
Route::any('/losses', [App\Http\Controllers\Issuance\ReturnedProductsController::class, 'losses'])->name('/losses');
//notification test


//requests
Route::any('/request', [App\Http\Controllers\Request\RequestController::class, 'index'])->name('request');
Route::post('/newRequest', [App\Http\Controllers\Request\RequestController::class, 'newRequest'])->name('newRequest');
Route::post('/processRequest', [App\Http\Controllers\Request\RequestController::class, 'processRequest'])->name('processRequest');
Route::post('/pickUpProductRequest', [App\Http\Controllers\Request\RequestController::class, 'pickUpProductRequest'])->name('pickUpProductRequest');
Route::get('/issueProductRequest', [App\Http\Controllers\Request\RequestController::class, 'issueProductRequest'])->name('issueProductRequest');
Route::get('/retrieveItemsList', [App\Http\Controllers\Request\RequestController::class, 'retrieveItemsList'])->name('retrieveItemsList');
Route::post('/issueFinalRequest', [App\Http\Controllers\Request\RequestController::class, 'issueFinalRequest'])->name('issueFinalRequest');

//reports
Route::any('/reports', [App\Http\Controllers\Reports\ReportsController::class, 'index'])->name('reports');
Route::post('/generateInventoryReport', [App\Http\Controllers\Reports\ReportsController::class, 'linenInventory'])->name('generateInventoryReport');

//role
Route::any('/roleManagement', [App\Http\Controllers\Role\RoleController::class, 'index'])->name('roleManagement');
Route::any('/listusers', [App\Http\Controllers\Role\RoleController::class, 'listusers'])->name('listusers');
Route::any('/roleManagement/assignAdmin', [App\Http\Controllers\Role\RoleController::class, 'assignAdmin'])->name('/roleManagement/assignAdmin');

Route::get('test', function () {
    event(new App\Events\LinisNotification('This is  a test'));
    return "Event has been sent!";
});