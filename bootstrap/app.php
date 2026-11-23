<?php

use App\Http\Middleware\EnsureUserRole;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn (Request $request) => $request->is('admin', 'admin/*')
            ? route('admin.login')
            : route('guest.login')
        );
        $middleware->redirectUsersTo(fn () => auth()->user()?->role === 'admin'
            ? route('admin.dashboard')
            : route('applicant.dashboard')
        );
        $middleware->alias([
            'role' => EnsureUserRole::class,
            'verified' => EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (InvalidSignatureException $exception, Request $request) {
            if ($request->routeIs('verification.verify') || $request->is('email/verify/*')) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Link verifikasi email tidak valid atau sudah kedaluwarsa.',
                    ], 403);
                }

                $expires = $request->query('expires');
                $isExpired = is_numeric($expires) && (int) $expires < now()->timestamp;

                return response()->view('guest.verify-email-invalid', [
                    'isExpired' => $isExpired,
                ], 403);
            }

            return null;
        });
    })->create();
