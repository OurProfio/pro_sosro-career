<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(fn (object $notifiable, string $url) => (new MailMessage)
            ->subject('Verifikasi Email Akun Karir PT Sinar Sosro Gunung Slamat')
            ->view('mail.verify-email', [
                'name' => $notifiable->applicant?->name ?? 'Kandidat',
                'url' => $url,
                'expire' => config('auth.verification.expire'),
            ]));
    }
}
