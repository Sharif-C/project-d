<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VanController;
use App\Http\Controllers\WarehouseController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::post('/product/{product}/comments', [ProductController::class, 'addComment'])->name('product.comments.add');
Route::post('/product/comment/delete', [ProductController::class, 'deleteComment'])->name('product.comment.delete');
// PRODUCT MANAGEMENT FLOW
Route::get('/manage-product', [ProductController::class, 'addProductView'])->name('manage.products');
Route::post('/store-product', [ProductController::class, 'store'])->name('product.store');

Route::get('/product/edit/{product}', [ProductController::class, 'editProductView'])
    ->name('product.edit')
    ->missing(function (){return to_route('manage.products');});

Route::put('/product/{product}', [ProductController::class, 'editProduct'])->name('product.update');
Route::post('/product/delete', [ProductController::class, 'deleteProduct'])->name('product.delete');

// PRODUCT SERIAL NUMBER MANAGEMENT FLOW
Route::get('/product/serial-number/manage', [ProductController::class, 'addSerialNumberView'])->name('manage.serial-numbers');
Route::get('/product/{product_id}/serial-number/{serial_number}/view', [ProductController::class, 'updateSerialNumberView'])->name('view.serial-number');

Route::post('/product/store-serial-number', [ProductController::class, 'storeSerialNumber'])->name('product.store-serial-number');
Route::post('/product/serial_number/update', [ProductController::class, 'updateSerialNumberAction'])->name('update.serial-number');
Route::post('/product/serial_number/delete', [ProductController::class, 'deleteSerialNumber'])->name('product.delete-serial-number');

// WAREHOUSE MANAGEMENT FLOW
Route::get('/manage-warehouse', [WarehouseController::class, 'manageWarehouseView'])->name('manage.warehouses');
Route::post('/warehouse/store', [WarehouseController::class, 'storeWarehouse'])->name('warehouse.store');
Route::post('/warehouse/delete', [WarehouseController::class, 'deleteWareHouse'])->name('warehouse.delete');
Route::get('/warehouse/edit/{warehouse}', [WarehouseController::class, 'updateWarehouseView'])
    ->name('warehouse.edit.view')
    ->missing(function (){return redirect()->route('manage.warehouses');});
Route::post("warehouse/update", [WarehouseController::class, "updateWarehouseAction"])
    ->name("warehouse.update.action");

Route::post("van/allocate/products/{van}", [VanController::class, "allocateProductsToVan"])
    ->name("van.allocate.products")
    ->missing(function (){return redirect()->back();});


// GENERATED ROUTES
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
// VAN VIEW
Route::get('/manage-van', [VanController::class, 'manageVanView'])->name('manage.vans');
Route::post('/van/store', [VanController::class, 'storeVan'])->name('van.store');
Route::post('/van/delete', [VanController::class, 'deleteVan'])->name('van.delete');
Route::get('/van/edit/{van}', [VanController::class, 'updateVanView'])
    ->name('van.edit.view')
    ->missing(function (){return to_route('manage.vans');});
Route::post ("van/update", [VanController::class, "updateVanAction"])->name("van.update.action");
Route::post ("van/move/product/warehouse", [VanController::class, "moveProductToWarehouse"])->name("van.move.product.warehouse");


Route::post("product/install/{product}", [ProductController::class, "installProduct"])
    ->name("install.product.serial-number")
    ->missing(function (){return redirect()->back();});
