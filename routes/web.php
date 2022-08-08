<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Linen\LinenInventoryController;
use App\Http\Controllers\Stockroom\StockRoomController;
use App\Http\Controllers\Stockroom\StorageController;
use App\Http\Controllers\Linen\ProductsController;
use App\Http\Controllers\Request\ServiceController;
use App\Http\Controllers\Issuance\IssuanceController;
use App\Http\Controllers\Issuance\ReturnedProductsController;
use App\Http\Controllers\Request\RequestController;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Department\DepartmentController;

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

Route::get('/', function (Request $request) {
    if($request->user()) {
        return redirect()->route('home');
    } else {
        return view('welcome');
    }
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [LinenInventoryController::class, 'index'])->name('home');
    Route::get('/logout', function () {
        \Session::flush();
        \Auth::logout();
        return redirect('login');
    });

    //materials
    Route::prefix('material')->group(function () {
        Route::any('/', [LinenInventoryController::class, 'create'])->name('material');
        Route::post('/add', [LinenInventoryController::class, 'store'])->name('material/add');
        Route::post('/delete', [LinenInventoryController::class, 'destroy'])->name('material/delete');
        Route::post('/update', [LinenInventoryController::class, 'update'])->name('material/update');
    });


    //stockroom
    Route::prefix('stockroom')->group(function () {
        Route::any('/', [StockRoomController::class, 'index'])->name('stockroom');
        Route::post('/add', [StockRoomController::class, 'store'])->name('stockroom/add');
        Route::post('/delete', [StockRoomController::class, 'destroy'])->name('stockroom/delete');
        Route::post('/update', [StockRoomController::class, 'update'])->name('stockroom/update');

        //storage
        Route::prefix('storage')->group(function () {
            Route::post('/add', [StorageController::class, 'addStorage'])->name('stockroom/storage/add');
            Route::post('/update', [StorageController::class, 'updateStorage'])->name('stockroom/storage/update');
            Route::post('/delete', [StorageController::class, 'destroy'])->name('stockroom/storage/delete');
        });
    });

    //products
    Route::prefix('products')->group(function () {
        Route::any('/', [ProductsController::class, 'index'])->name('products');
        Route::post('/add', [ProductsController::class, 'addProduct'])->name('products/add');
        Route::post('/delete', [ProductsController::class, 'destroy'])->name('products/delete');
        Route::post('/update', [ProductsController::class, 'update'])->name('products/update');
    });

    //services
    Route::prefix('services')->group(function () {
        Route::any('/', [ServiceController::class, 'index'])->name('services');
        Route::POST('/comments/{id}', [ServiceController::class, 'updateComment'])->name('services/update');
    });

    //issuance
    Route::any('/issuance', [IssuanceController::class, 'index'])->name('issuance');
    Route::post('/issueProduct', [IssuanceController::class, 'issueProduct'])->name('/issueProduct');
    Route::post('/condemned/delete', [IssuanceController::class, 'destroy'])->name('/condemned/delete');

    //re-issue
    Route::any('/returnedProducts', [ReturnedProductsController::class, 'index'])->name('returnedProducts');
    Route::post('/returningProducts', [ReturnedProductsController::class, 'returningProducts'])->name('/returningProducts');
    Route::post('/condemned/delete', [ReturnedProductsController::class, 'destroy'])->name('/condemned/delete');
    Route::any('/condemned', [ReturnedProductsController::class, 'condemned'])->name('/condemned');
    Route::any('/losses', [ReturnedProductsController::class, 'losses'])->name('/losses');

    //requests
    Route::any('/request', [RequestController::class, 'index'])->name('request');
    Route::post('/newRequest', [RequestController::class, 'newRequest'])->name('newRequest');
    Route::post('/processRequest', [RequestController::class, 'processRequest'])->name('processRequest');
    Route::post('/pickUpProductRequest', [RequestController::class, 'pickUpProductRequest'])->name('pickUpProductRequest');
    Route::get('/issueProductRequest', [RequestController::class, 'issueProductRequest'])->name('issueProductRequest');
    Route::get('/retrieveItemsList', [RequestController::class, 'retrieveItemsList'])->name('retrieveItemsList');
    Route::post('/issueFinalRequest', [RequestController::class, 'issueFinalRequest'])->name('issueFinalRequest');

    //reports
    Route::any('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::post('/generateInventoryReport', [ReportsController::class, 'linenInventory'])->name('generateInventoryReport');

    //users
    Route::prefix('users')->group(function () {
        Route::any('listusers', [RoleController::class, 'listusers'])->name('listusers');
        Route::any('roleManagement', [RoleController::class, 'index'])->name('roleManagement');
        Route::any('assignAdmin', [RoleController::class, 'assignAdmin'])->name('assignAdmin');
        Route::post('reset/{id}', [RoleController::class, 'resetPassword'])->name('resetPassword');
    });

    //password
    Route::prefix('password')->group(function () {
        Route::get('/', [PasswordController::class, 'index'])->name('password');
        Route::post('/', [PasswordController::class, 'update'])->name('password/update');
    });

    //departments
    Route::prefix('departments')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('department');
        Route::get('ward/{ward_id}', [DepartmentController::class, 'wardIssuedProducts'])->name('department/ward');
        Route::get('office/{office_id}', [DepartmentController::class, 'officeIssuedProducts'])->name('department/office');
    });

    // Vue components
    Route::prefix('v')->group(function () {
        Route::get('/', function () {
            return view('vue.index');
        });
    });

    Route::get('test', function () {
        event(new App\Events\LinisNotification('This is  a test'));
        return "Event has been sent!";
    });
});