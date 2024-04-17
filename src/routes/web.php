<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarehouseController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/add-product', function () {
    $products = Product::select('_id', 'name', 'description', 'created_at', 'updated_at')->get();
    return view('product.add', compact('products'));
});

Route::get('/product/add-serial-number', [ProductController::class, 'addSerialNumberView']);
Route::post('/product/store-serial-number', [ProductController::class, 'storeSerialNumber'])->name('product.store-serial-number');


Route::post('/store-product', [ProductController::class, 'store'])->name('product.store');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php'; 


Route::get('/manage-warehouse', [WarehouseController::class, 'manageWarehouseView']);

Route::post('/warehouse/store', [WarehouseController::class, 'storeWarehouse'])->name('warehouse.store');

Route::post('/warehouse/delete', [WarehouseController::class, 'deleteWareHouse'])->name('warehouse.delete');


