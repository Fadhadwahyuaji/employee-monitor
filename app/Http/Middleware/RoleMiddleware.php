<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Pastikan pengguna sudah login
        if (!auth()->check()) {
            return redirect('login'); // Redirect ke halaman login jika belum login
        }

        // Ambil pengguna yang sedang login
        $user = $request->user();

        // Cek apakah pengguna memiliki role yang sesuai
        if (is_array($role)) {
            // Jika $role adalah array, cek apakah pengguna memiliki salah satu dari role tersebut
            $hasRole = $user->roles()->whereIn('name', $role)->exists();
            if (!$hasRole) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // Jika $role adalah string, cek apakah pengguna memiliki role tersebut
            $hasRole = $user->roles()->where('name', $role)->exists();
            if (!$hasRole) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Lanjutkan request jika role cocok
        return $next($request);
    }
}
