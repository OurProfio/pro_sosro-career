<?php

namespace App\Providers;

use App\Mail\VerifyEmailMail;
use Illuminate\Auth\Notifications\VerifyEmail;
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
        VerifyEmail::toMailUsing(fn (object $notifiable, string $url) => (new VerifyEmailMail(
            name: $notifiable->applicant?->name ?? 'Kandidat',
            url: $url,
            expire: (int) config('auth.verification.expire'),
        ))->to($notifiable->email));
    }
}
