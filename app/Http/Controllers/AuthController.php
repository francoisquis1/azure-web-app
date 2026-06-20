<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Credenciales fijas (usuario => contraseña)
    private const USUARIOS = [
        'admin123'   => ['password' => 'admin123', 'rol' => 'admin'],
        'usuario123' => ['password' => 'usuario123', 'rol' => 'usuario'],
    ];

    // Muestra el formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesa el login
    public function login(Request $request)
    {
        $datos = $request->validate([
            'usuario'  => 'required|string',
            'password' => 'required|string',
        ]);

        $u = $datos['usuario'];
        $p = $datos['password'];

        if (isset(self::USUARIOS[$u]) && self::USUARIOS[$u]['password'] === $p) {
            session([
                'auth_usuario' => $u,
                'auth_rol'     => self::USUARIOS[$u]['rol'],
            ]);
            return redirect()->route('canchas.index')
                ->with('exito', "¡Bienvenido, {$u}!");
        }

        return back()->withErrors([
            'login' => 'Usuario o contraseña incorrectos.',
        ]);
    }

    // Cierra sesión
    public function logout()
    {
        session()->forget(['auth_usuario', 'auth_rol']);
        return redirect()->route('canchas.index')
            ->with('exito', 'Sesión cerrada.');
    }
}