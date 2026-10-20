<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route($request->is('admin', 'admin/*') ? 'admin.login' : 'guest.login');
        }

        $user = auth()->user();
        $userRole = $user->role;

        // Map role aliases if necessary (e.g. 'applicant' corresponds to 'user' in DB)
        $allowedRoles = array_map(
            fn (string $role): string => match ($role) {
                'applicant' => 'user',
                default => $role,
            },
            $roles
        );

        if (! in_array($userRole, $allowedRoles, true)) {
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($userRole === 'user') {
                return redirect()->route('applicant.dashboard');
            }

            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}
