<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicantProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DivisiController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('guest.index'))->name('guest.index');
Route::group(['middleware' => 'guest', 'as' => 'guest.'], function () {
    Route::get('login', fn() => view('guest.login'))->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::get('register', fn() => view('guest.register'))->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('cabang', CabangController::class);
    Route::resource('admin', AdminController::class);
    Route::resource('divisi', DivisiController::class);

    Route::get('dashboard', fn() => view('auth.applicant.index'))->name('applicant.index');
    Route::resource('biodata', ApplicantProfileController::class)->parameters(['biodata' => 'applicantProfile']);
    
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});