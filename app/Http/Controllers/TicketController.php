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
            $ticketId = DB::table('tickets')->insertGetId([
                'usuario_id' => 1,
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

            return redirect('/?exito=1');
        } catch (\Exception $e) {
            return redirect('/?error=' . urlencode($e->getMessage()));
        }
    }


    public function index()
    {
        try {
            $tickets = DB::table('tickets')
                ->join('usuarios', 'tickets.usuario_id', '=', 'usuarios.id')
                ->select('tickets.*', 'usuarios.nombre as reportado_por', 'usuarios.distrito')
                ->orderBy('tickets.id', 'desc')
                ->get();

            return view('panel_tickets', compact('tickets'));
        } catch (\Exception $e) {
            return "Error al cargar el panel: " . $e->getMessage();
        }
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

            DB::table('tickets_historial')->insert([
                'ticket_id' => $id,
                'usuario_id' => 1,
                'estado_anterior' => $ticketActual->estado,
                'estado_nuevo' => $request->estado,
                'comentario' => 'Estado actualizado desde el Panel de Soporte Técnico.'
            ]);
            return redirect('/panel');
        } catch (\Exception $e) {
            return "Error al actualizar estado: " . $e->getMessage();
        }
    }
        public function show(int $id)
    {
        try {
            // 1. Datos principales del ticket
            $ticket = DB::table('tickets')
                ->join('usuarios', 'tickets.usuario_id', '=', 'usuarios.id')
                ->select('tickets.*', 'usuarios.nombre as reportado_por', 'usuarios.apellido', 'usuarios.distrito', 'usuarios.correo_institucional')
                ->where('tickets.id', $id)
                ->first();

            if (!$ticket) {
                return redirect('/panel');
            }

            // 2. Historial de cambios
            $historial = DB::table('tickets_historial')
                ->join('usuarios', 'tickets_historial.usuario_id', '=', 'usuarios.id')
                ->select('tickets_historial.*', 'usuarios.nombre as modificado_por')
                ->where('tickets_historial.ticket_id', $id)
                ->orderBy('tickets_historial.id', 'desc')
                ->get();

            // 3. Archivos adjuntos (¡Esto faltaba enviar!)
            $adjuntos = DB::table('tickets_adjuntos')
                ->where('ticket_id', $id)
                ->get();

            return view('detalle_ticket', compact('ticket', 'historial', 'adjuntos'));
        } catch (\Exception $e) {
            return "Error al cargar los detalles: " . $e->getMessage();
        }
    }
}

