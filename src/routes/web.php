<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VanController;
use App\Http\Controllers\WarehouseController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/manage-product', [ProductController::class, 'addProductView'])->name('manage.products');

Route::get('/product/add-serial-number', [ProductController::class, 'addSerialNumberView'])->name('manage.serial-numbers');
Route::post('/product/store-serial-number', [ProductController::class, 'storeSerialNumber'])->name('product.store-serial-number');


Route::post('/store-product', [ProductController::class, 'store'])->name('product.store');
Route::post('/product/delete', [ProductController::class, 'deleteProduct'])->name('product.delete');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/manage-warehouse', [WarehouseController::class, 'manageWarehouseView'])->name('manage.warehouses');

Route::post('/warehouse/store', [WarehouseController::class, 'storeWarehouse'])->name('warehouse.store');

Route::post('/warehouse/delete', [WarehouseController::class, 'deleteWareHouse'])->name('warehouse.delete');

Route::get('/test', [\App\Http\Controllers\GenerateController::class, 'createWarehouses']);


Route::get('/manage-van', [VanController::class, 'manageVanView'])->name('manage.vans');

Route::post('/van/store', [VanController::class, 'storeVan'])->name('van.store');

Route::post('/van/delete', [VanController::class, 'deleteVan'])->name('van.delete');



