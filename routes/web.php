<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Applicant\ApplicantController;
use App\Http\Controllers\Admin\ApplicantController as AdminApplicantController;
use App\Http\Controllers\Applicant\ApplicantEducationController;
use App\Http\Controllers\Applicant\ApplicantFamilyController;
use App\Http\Controllers\Applicant\ApplicantWorkExprienceController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Guest\GuestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mail\MailController;

Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::group(['middleware' => 'guest', 'as' => 'guest.'], function () {
    Route::get('login', fn() => view('guest.login'))->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::get('register', fn() => view('guest.register'))->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['admin']], function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
            Route::resource('admin', AdminController::class);
            Route::resource('office', OfficeController::class);
            Route::resource('division', DivisionController::class);
            Route::resource('applicant', AdminApplicantController::class);
            Route::resource('user', UserController::class);
            Route::resource('job', JobController::class);
        });
    });

    Route::group(['middleware' => ['applicant']], function () {
        Route::get('/dashboard', fn() => view('auth.applicant.index'))->name('applicant.dashboard');
        Route::get('/biodata/keluarga', [ApplicantFamilyController::class, 'create'])->name('biodata.family.create');
        Route::post('/biodata/keluarga', [ApplicantFamilyController::class, 'store'])->name('biodata.family.store');
        Route::get('/biodata/pendidikan', [ApplicantEducationController::class, 'create'])->name('biodata.education.create');
        Route::post('/biodata/pendidikan', [ApplicantEducationController::class, 'store'])->name('biodata.education.store');
        Route::get('/biodata/pengalaman-kerja', [ApplicantWorkExprienceController::class, 'create'])->name('biodata.workExperience.create');
        Route::post('/biodata/pengalaman-kerja', [ApplicantWorkExprienceController::class, 'store'])->name('biodata.workExperience.store');
        Route::resource('biodata', ApplicantController::class)->parameters(['biodata' => 'applicant']);

        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::post('/apply', [ApplicationController::class, 'store'])->name('applications.store');
    });

    
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
    Route::get('/view', [MailController::class, 'index'])->name('email.index');
    Route::post('/send-email', [MailController::class, 'sendEmail'])->name('sendEmail');

