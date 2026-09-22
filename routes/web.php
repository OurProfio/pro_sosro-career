<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\OfficeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::group(['middleware' => 'guest', 'as' => 'guest.'], function () {
    Route::get('login', fn() => view('guest.login'))->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::get('register', fn() => view('guest.register'))->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['admin']], function () {
        Route::get('/admin/dashboard', fn() => view('auth.admin.index'))->name('admin.dashboard');
        Route::resource('office', OfficeController::class);
        Route::resource('admin', AdminController::class);
        Route::resource('division', DivisionController::class);
        Route::resource('job', JobController::class);
    });

    Route::group(['middleware' => ['applicant']], function () {
        Route::get('dashboard', fn() => view('auth.applicant.index'))->name('applicant.index');
        Route::resource('biodata', ApplicantController::class)->parameters(['biodata' => 'applicantProfile']);
    });

    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});
