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

        if (! $user->is_active || ($userRole === 'admin' && $user->admin && ! $user->admin->is_active)) {
            $isAdminRoute = $request->is('admin', 'admin/*');
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route($isAdminRoute ? 'admin.login' : 'guest.login')
                ->with('error', $userRole === 'admin' ? 'Akun Admin Anda telah dinonaktifkan.' : 'Akun Anda telah dinonaktifkan.');
        }

        // Map role aliases if necessary (e.g. 'applicant' corresponds to 'user' in DB)
        $allowedRoles = array_map(
            fn (string $role): string => match ($role) {
                'applicant' => 'user',
                default => $role,
            },
            $roles
        );

        // Jika rute mensyaratkan 'superadmin', periksa role pada tabel admin
        if (in_array('superadmin', $roles, true)) {
            if ($userRole !== 'admin' || $user->admin?->role !== 'superadmin') {
                abort(403, 'Akses terbatas untuk Super Admin.');
            }

            return $next($request);
        }

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
