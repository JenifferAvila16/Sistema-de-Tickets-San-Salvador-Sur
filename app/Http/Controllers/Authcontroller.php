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
        // 1. Muestra el formulario de auto-registro
    public function showRegister()
    {
        return view('register');
    }

    // 2. Guarda el nuevo empleado en PostgreSQL
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'apellido' => 'required|max:100',
            'cargo' => 'required|max:100',
            'departamento_unidad' => 'required|max:100',
            'distrito' => 'required',
            'telefono' => 'required|max:20',
            'correo_institucional' => 'required|email|unique:usuarios,correo_institucional',
            'password' => 'required|min:6'
        ]);

        DB::table('usuarios')->insert([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'cargo' => $request->cargo,
            'departamento_unidad' => $request->departamento_unidad,
            'distrito' => $request->distrito,
            'correo_institucional' => $request->correo_institucional,
            'telefono' => $request->telefono,
            'nombre_solicitante' => $request->nombre . ' ' . $request->apellido,
            'contrasena_hash' => $request->password,
            'rol' => 'solicitante',
            'estado' => 'activo',
            'fecha_creacion' => now(),
            'fecha_de_actualizacion' => now()
        ]);

        return redirect('/login')->with('exito', 'Cuenta creada con éxito. Ya puedes iniciar sesión.');
    }

    // 3. Lista todos los usuarios para el Administrador
    public function listarUsuarios()
    {
        if (!session('usuario_id')) return redirect('/login');

        $usuarios = DB::table('usuarios')->orderBy('id', 'asc')->get();
        return view('usuarios', compact('usuarios'));
    }

    // 4. Activa o suspende el acceso de un usuario
    public function cambiarEstadoUsuario(int $id)
    {
        $usuario = DB::table('usuarios')->where('id', $id)->first();
        $nuevoEstado = ($usuario->estado === 'activo') ? 'inactivo' : 'activo';

        DB::table('usuarios')->where('id', $id)->update([
            'estado' => $nuevoEstado,
            'fecha_de_actualizacion' => now()
        ]);

        return redirect('/usuarios');
    }

}


