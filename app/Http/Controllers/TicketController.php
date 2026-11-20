<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TicketController extends Controller
{
 public function store(Request $request)
    {
        $request->validate([
            'asunto' => 'required|max:255',
            'categoria' => 'required',
            'prioridad' => 'required',
            'descripcion' => 'required',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {
                        if (!session('usuario_id')) {
                return redirect('/login')->with('error', 'Tu sesión expiró. Inicia sesión de nuevo.');
            }

            $ticketId = DB::table('tickets')->insertGetId([
                'usuario_id' => session('usuario_id'),
                'categoria' => $request->categoria,
                'prioridad' => $request->prioridad,
                'asunto' => $request->asunto,
                'descripcion_detallada' => $request->descripcion,
                'ubicacion' => 'Distrito de ' . $request->distrito,
                'estado' => 'abierto',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
            ]);

            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $rutaGuardada = $archivo->store('adjuntos_tickets', 'public');

                DB::table('tickets_adjuntos')->insert([
                    'ticket_id' => $ticketId,
                    'nombre_archivo' => $archivo->getClientOriginalName(),
                    'ruta_almacenamiento' => $rutaGuardada,
                    'tipo_mime' => $archivo->getClientMimeType(),
                    'tamano_bytes' => $archivo->getSize(),
                ]);
            }

            return redirect('/')->with('exito', '¡Ticket creado exitosamente!');
        } catch (\Exception $e) {
            return redirect('/')->with('error', '❌ Error: ' . $e->getMessage());
        }
    }

        // FUNCIÓN 2: Listar tickets con filtros dinámicos
    public function index(Request $request)
    {
        if (!session('usuario_id')) {
            return redirect('/login');
        }

        $query = DB::table('tickets')
            ->join('usuarios', 'tickets.usuario_id', '=', 'usuarios.id')
            ->select('tickets.*', 'usuarios.nombre as reportado_por', 'usuarios.distrito');

        // Filtro por palabra clave en el asunto
        if ($request->filled('buscar')) {
            $query->where('tickets.asunto', 'ILIKE', '%' . $request->buscar . '%');
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('tickets.estado', $request->estado);
        }

        // Filtro por distrito
        if ($request->filled('distrito')) {
            $query->where('usuarios.distrito', $request->distrito);
        }

        $tickets = $query->orderBy('tickets.id', 'desc')->get();

        return view('panel_tickets', compact('tickets'));
    }


        public function actualizarEstado(Request $request, int $id)
    {
        try {
            $ticketActual = DB::table('tickets')->where('id', $id)->first();

            DB::table('tickets')
                ->where('id', $id)
                ->update([
                    'estado' => $request->estado,
                    'fecha_actualizacion' => now()
                ]);

            $comentarioFinal = $request->filled('comentario')
                ? $request->comentario
                : 'Estado actualizado desde el Panel de Soporte Técnico.';

            DB::table('tickets_historial')->insert([
                'ticket_id' => $id,
                'usuario_id' => session('usuario_id') ?? 1,
                'estado_anterior' => $ticketActual->estado,
                'estado_nuevo' => $request->estado,
                'comentario' => $comentarioFinal,
                'fecha_cambio' => now()
            ]);

            return redirect('/panel');
        } catch (\Exception $e) {
            return "Error al actualizar estado: " . $e->getMessage();
        }
    }
    public function show(int $id)
    {
        try {
            $ticket = DB::table('tickets')
                ->join('usuarios', 'tickets.usuario_id', '=', 'usuarios.id')
                ->select('tickets.*', 'usuarios.nombre as reportado_por', 'usuarios.apellido', 'usuarios.distrito', 'usuarios.correo_institucional')
                ->where('tickets.id', $id)
                ->first();

            if (!$ticket) {
                return redirect('/panel');
            }

                        // 2. Historial de cambios de estado
            $historial = DB::table('tickets_historial')
                ->join('usuarios', 'tickets_historial.usuario_id', '=', 'usuarios.id')
                ->select('tickets_historial.*', 'usuarios.nombre as modificado_por')
                ->where('tickets_historial.ticket_id', $id)
                ->orderBy('tickets_historial.id', 'desc')
                ->get();

            $adjuntos = DB::table('tickets_adjuntos')
                ->where('ticket_id', $id)
                ->get();

            return view('detalle_ticket', compact('ticket', 'historial', 'adjuntos'));
        } catch (\Exception $e) {
            return "Error al cargar los detalles: " . $e->getMessage();
        }
    }
    public function listarUsuarios()
    {
        if (!session('usuario_id')) {
            return redirect('/login');
        }

        if (session('usuario_rol') !== 'administrador' && session('usuario_rol') !== 'admin') {
            return redirect('/')->with('error', ' Acceso denegado. Solo los administradores pueden gestionar cuentas.');
        }

        $usuarios = DB::table('usuarios')->orderBy('id', 'asc')->get();
        return view('usuarios', compact('usuarios'));
    }

    public function cambiarEstadoUsuario(int $id)
    {
        if (session('usuario_rol') !== 'administrador' && session('usuario_rol') !== 'admin') {
            return redirect('/')->with('error', 'Acción no autorizada.');
        }

        // Evita que el administrador se bloquee a sí mismo por accidente
        if ($id === session('usuario_id')) {
            return redirect('/usuarios');
        }

        $usuario = DB::table('usuarios')->where('id', $id)->first();
        $nuevoEstado = ($usuario->estado === 'activo') ? 'inactivo' : 'activo';

        DB::table('usuarios')->where('id', $id)->update([
            'estado' => $nuevoEstado,
            'fecha_de_actualizacion' => now()
        ]);

        return redirect('/usuarios');
    }
        // FUNCIÓN 5: Dashboard estadístico para el Administrador
    public function dashboard()
    {
        if (!session('usuario_id')) {
            return redirect('/login');
        }

        try {
            $totalTickets = DB::table('tickets')->count();
            $abiertos = DB::table('tickets')->where('estado', 'abierto')->count();
            $pendientes = DB::table('tickets')->whereIn('estado', ['pendiente', 'asignado'])->count();
            $resueltos = DB::table('tickets')->whereIn('estado', ['resuelto', 'cerrado'])->count();

            $porDistrito = DB::table('tickets')
                ->join('usuarios', 'tickets.usuario_id', '=', 'usuarios.id')
                ->select('usuarios.distrito', DB::raw('count(tickets.id) as total'))
                ->groupBy('usuarios.distrito')
                ->orderBy('total', 'desc')
                ->get();

            $porCategoria = DB::table('tickets')
                ->select('categoria', DB::raw('count(id) as total'))
                ->groupBy('categoria')
                ->get();

            return view('dashboard', compact(
                'totalTickets', 'abiertos', 'pendientes', 'resueltos', 'porDistrito', 'porCategoria'
            ));
        } catch (\Exception $e) {
            return "Error al cargar estadísticas: " . $e->getMessage();
        }
    }

}

