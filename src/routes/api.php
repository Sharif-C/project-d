<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/transfer/product', [ApiController::class, 'moveProductParser']);
