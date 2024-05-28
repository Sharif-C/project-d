<?php

use App\Http\Controllers\VanController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::post('/van/product/move', [VanController::class, 'moveProductToVan']);
