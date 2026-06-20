<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SoloAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Si no hay sesión de admin, redirige al login
        if (session('auth_rol') !== 'admin') {
            return redirect()->route('login')
                ->withErrors(['login' => 'Debes iniciar sesión como administrador para acceder a esa sección.']);
        }
        return $next($request);
    }
}