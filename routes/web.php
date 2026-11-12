<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ApplicantController as AdminApplicantController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\PsikotesLinkController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Applicant\ApplicantController;
use App\Http\Controllers\Applicant\ApplicantEducationController;
use App\Http\Controllers\Applicant\ApplicantFamilyController;
use App\Http\Controllers\Applicant\ApplicantWorkExprienceController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\Guest\UserConfirmationController;
use App\Http\Controllers\Mail\MailController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::get('/lowongan', [GuestController::class, 'lowongan'])->name('guest.lowongan');
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
    Route::get('email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('email/verification-notification', [VerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('applicant/{applicant}/cetak', [AdminApplicantController::class, 'print'])->name('applicant.print');
            Route::resource('applicant', AdminApplicantController::class);
            Route::resource('job', JobController::class);

            Route::patch('/application/{application}/stage', [ApplicationController::class, 'updateStage'])->name('application.updateStage');
            Route::patch('/application/{application}/status', [ApplicationController::class, 'updateStatus'])->name('application.updateStatus');
            Route::post('/job/{job}/psikotes-links', [PsikotesLinkController::class, 'import'])->name('job.psikotesLinks.import');

            // Khusus Super Admin
            Route::group(['middleware' => ['role:superadmin']], function () {
                Route::patch('/job/{job}/approve', [JobController::class, 'approve'])->name('job.approve');
                Route::patch('/admin/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
                Route::patch('/user/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');
                Route::resource('office', OfficeController::class);
                Route::resource('division', DivisionController::class);
                Route::resource('admin', AdminController::class);
                Route::resource('user', UserController::class);
            });
        });
    });

    Route::group(['middleware' => ['role:applicant', 'verified']], function () {
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

Route::middleware('throttle:10,1')->group(function () {
    Route::get('konfirmasi-user/{token}', [UserConfirmationController::class, 'show'])->name('user-confirmation.show');
    Route::get('konfirmasi-user/{token}/detail', [UserConfirmationController::class, 'detail'])->name('user-confirmation.detail');
    Route::get('konfirmasi-user/{token}/cetak', [UserConfirmationController::class, 'print'])->name('user-confirmation.print');
    Route::put('konfirmasi-user/{token}', [UserConfirmationController::class, 'update'])->name('user-confirmation.update');
});

// Fitur Sementara: Feedback (Kritik & Saran)
Route::get('/feedback', [Controller::class, 'feedback'])->name('feedback.index');
Route::post('/feedback', [Controller::class, 'storeFeedback'])->name('feedback.store');

// Route::get('/email', [MailController::class, 'index'])->name('email.index');
// Route::post('/email', [MailController::class, 'sendEmail'])->name('email.send');
