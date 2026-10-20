<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ApplicantController as AdminApplicantController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Applicant\ApplicantController;
use App\Http\Controllers\Applicant\ApplicantEducationController;
use App\Http\Controllers\Applicant\ApplicantFamilyController;
use App\Http\Controllers\Applicant\ApplicantWorkExprienceController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\Mail\MailController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::group(['middleware' => 'guest', 'as' => 'guest.'], function () {
    Route::get('login', fn () => view('guest.login'))->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');

    Route::get('register', fn () => view('guest.register'))->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('admin/login', fn () => view('auth.admin.auth.login'))->name('admin.login');
    Route::post('admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
            Route::resource('admin', AdminController::class);
            Route::resource('office', OfficeController::class);
            Route::resource('division', DivisionController::class);
            Route::get('applicant/{applicant}/cetak', [AdminApplicantController::class, 'print'])->name('applicant.print');
            Route::resource('applicant', AdminApplicantController::class);
            Route::resource('user', UserController::class);
            Route::patch('job/{job}/approve', [JobController::class, 'approve'])->name('job.approve');
            Route::patch('job/{job}/reject', [JobController::class, 'reject'])->name('job.reject');
            Route::resource('job', JobController::class);

            Route::patch('/application/{application}/stage', [ApplicationController::class, 'updateStage'])->name('application.updateStage');
            Route::patch('/application/{application}/status', [ApplicationController::class, 'updateStatus'])->name('application.updateStatus');

            Route::get('/view', [MailController::class, 'index'])->name('email.index');

        });
    });

    Route::group(['middleware' => ['role:applicant']], function () {
        Route::get('/dashboard', fn () => view('auth.applicant.index'))->name('applicant.dashboard');
        Route::get('/biodata/keluarga', [ApplicantFamilyController::class, 'create'])->name('biodata.family.create');
        Route::post('/biodata/keluarga', [ApplicantFamilyController::class, 'store'])->name('biodata.family.store');
        Route::get('/biodata/pendidikan', [ApplicantEducationController::class, 'create'])->name('biodata.education.create');
        Route::post('/biodata/pendidikan', [ApplicantEducationController::class, 'store'])->name('biodata.education.store');
        Route::get('/biodata/pengalaman-kerja', [ApplicantWorkExprienceController::class, 'create'])->name('biodata.workExperience.create');
        Route::post('/biodata/pengalaman-kerja', [ApplicantWorkExprienceController::class, 'store'])->name('biodata.workExperience.store');
        Route::get('/biodata/cetak', [ApplicantController::class, 'print'])->name('biodata.print');
        Route::resource('biodata', ApplicantController::class)->parameters(['biodata' => 'applicant']);

        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::post('/apply', [ApplicationController::class, 'store'])->name('applications.store');
        Route::patch('/applications/{application}/cancel', [ApplicationController::class, 'cancel'])->name('applications.cancel');
    });

    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Fitur Sementara: Feedback (Kritik & Saran)
Route::get('/feedback', [Controller::class, 'feedback'])->name('feedback.index');
Route::post('/feedback', [Controller::class, 'storeFeedback'])->name('feedback.store');
