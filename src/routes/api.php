<?php

use App\Http\Controllers\VanController;
use Illuminate\Support\Facades\Route;

Route::post('/van/product/move', [VanController::class, 'moveProductToVan']);
