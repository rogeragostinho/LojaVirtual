<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;


use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::controller(AdminDashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('index');    
    });

    Route::resources([
        'categories' => CategoryController::class,
        'products' => ProductController::class
    ]);
    Route::delete('products/images/{image}', [ProductController::class, 'destroyImage'])->name('products.images.destroy');

    Route::post('/admin/create-admin', [AdminManagementController::class, 'store'])
        ->middleware('role:super_admin'/*'can:super_admin'*/);

    Route::middleware(['can:access-super-admin'])->group(function () {
        Route::resource('team', AdminManagementController::class);
    });  

    Route::resource('customers', CustomerController::class)->only(['index', 'show', 'destroy']);
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
});
