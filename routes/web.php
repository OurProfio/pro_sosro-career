<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CabangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('cabang', CabangController::class);
Route::resource('admin', AdminController::class);
