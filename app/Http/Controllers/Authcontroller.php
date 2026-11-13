<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = DB::table('usuarios')
            ->where('correo_institucional', $request->correo)
            ->first();

        if ($usuario && $request->password === $usuario->contrasena_hash) {
            session([
                'usuario_id' => $usuario->id,
                'usuario_nombre' => $usuario->nombre . ' ' . $usuario->apellido,
                'usuario_rol' => $usuario->rol
            ]);

            return redirect('/');
        }

        return back()->with('error', 'Correo institucional o contraseña incorrectos.');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}


