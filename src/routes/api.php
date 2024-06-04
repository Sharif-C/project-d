<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/transfer/product', [ApiController::class, 'moveProductParser']);
Route::post('/update/product/status/installed', [ProductController::class, 'installProductAPI']);
