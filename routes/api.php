<?php

use App\Http\Controllers\Products\IndexProductController;
use Illuminate\Support\Facades\Route;

Route::get('products',IndexProductController::class)->name('products.index');
