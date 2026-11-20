<!DOCTYPE html>
<html lang="es">
<head>
<link rel="preconnect" href="https://googleapis.com">
<link rel="preconnect" href="https://gstatic.com" crossorigin>
<link href="https://googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=2.0">
    <div style="text-align: center; margin-bottom: 15px;">
    <strong>Alcaldía Municipal de San Salvador Sur</strong>
</div>
<div style="text-align: center; margin-bottom: 15px;">
    <img src="{{ asset('img/logoSSS.jpeg') }}" alt="Logotipo oficial de la Alcaldía Municipal de San Salvador Sur." style="max-height: 80px; width: auto;">
    <title>Alcaldía Municipal de San Salvador Sur - Panel de Soporte Técnico</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: linear-gradient(135deg, #1933a7 0%, #0d3168 100%); min-height: 100vh; color: #334155; margin: 0; padding: 20px;}
        .container { max-width: 1100px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header-panel { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #CAFBFF; padding-bottom: 15px; margin-bottom: 25px; }
        h1 { color: #000060; margin: 0; }
        .btn-nuevo { background-color: #000060; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 14px; }
        .btn-nuevo:hover { background-color: #002244; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        th { background-color: #003366; color: white; }
        tr:hover { background-color: #f9fbfd; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .prioridad-alta, .prioridad-urgente { background-color: #f8d7da; color: #721c24; }
        .prioridad-media { background-color: #fff3cd; color: #856404; }
        .prioridad-baja { background-color: #d1ecf1; color: #0c5460; }
        .estado-abierto { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .estado-pendiente, .estado-asignado { background-color: #fff3cd; color: #856404; }
        .estado-resuelto, .estado-cerrado { background-color: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; background: #e9ecef; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px; font-size: 14px;">
    <span> Conectado como: <strong>{{ session('usuario_nombre') }}</strong> ({{ session('usuario_rol') }})</span>
    <a href="{{ route('logout') }}" style="background: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 12px;">Cerrar Sesión</a>
</div>

        <div class="header-panel">
        <h1>Panel de Soporte Técnico (TI)</h1>
        <div style="display: flex; gap: 10px;">
            @if(session('usuario_rol') === 'administrador' || session('usuario_rol') === 'admin')
                <a href="/usuarios" class="btn-nuevo" style="background-color: #475569;"> Gestionar Usuarios</a>
            @endif
            <a href="/" class="btn-nuevo">➕ Crear Nuevo Ticket</a>
        </div>
    </div>


    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Asunto</th>
                <th>Reportado Por</th>
                <th>Distrito</th>
                <th>Prioridad</th>
                <th>Estado Actual</th>
                <th>Cambiar Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td><strong>#{{ $ticket->id }}</strong></td>
                <td>
    <strong>{{ $ticket->asunto }}</strong><br>
    <small style="color: #666;">{{ $ticket->categoria }}</small> |
    <a href="{{ route('tickets.show', $ticket->id) }}" style="color: #003366; font-weight: bold; text-decoration: none; font-size: 13px;"> Ver detalles e historial</a>
</td>

                <td>{{ $ticket->reportado_por }}</td>
                <td>{{ $ticket->distrito }}</td>
                <td><span class="badge prioridad-{{ $ticket->prioridad }}">{{ $ticket->prioridad }}</span></td>
                <td><span class="badge estado-{{ $ticket->estado }}">{{ $ticket->estado }}</span></td>
                <td>
                    <form><form action="{{ route('tickets.estado', $ticket->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 6px;">
    @csrf
    <div style="display: flex; gap: 5px;">
        <select name="estado" style="padding: 5px; border-radius: 4px; border: 1px solid #ccc; flex: 1;">
            <option value="abierto" {{ $ticket->estado == 'abierto' ? 'selected' : '' }}>Abierto</option>
            <option value="pendiente" {{ $ticket->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="asignado" {{ $ticket->estado == 'asignado' ? 'selected' : '' }}>Asignado</option>
            <option value="resuelto" {{ $ticket->estado == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
            <option value="cerrado" {{ $ticket->estado == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
        </select>
        <button type="submit" style="background: #003366; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-weight: bold;">Guardar</button>
    </div>
    <input type="text" name="comentario" placeholder="Comentario opcional (ej. Se revisó equipo)..." style="padding: 5px 8px; border-radius: 4px; border: 1px solid #cbd5e1; font-size: 12px; width: 100%; box-sizing: border-box;">
</form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form action="/panel" method="GET" style="display: flex; gap: 10px; background: #f8fafc; padding: 15px; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 20px; flex-wrap: wrap;">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="🔍 Buscar por asunto..." style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px; flex: 1; min-width: 200px;">
        <select name="estado" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;">
            <option value="">Todos los estados</option>
            <option value="abierto" {{ request('estado') == 'abierto' ? 'selected' : '' }}>Abierto</option>
            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="asignado" {{ request('estado') == 'asignado' ? 'selected' : '' }}>Asignado</option>
            <option value="resuelto" {{ request('estado') == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
            <option value="cerrado" {{ request('estado') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
        </select>

        <select name="distrito" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px;">
            <option value="">Todos los distritos</option>
            <option value="San Marcos" {{ request('distrito') == 'San Marcos' ? 'selected' : '' }}>San Marcos</option>
            <option value="Santo Tomas" {{ request('distrito') == 'Santo Tomas' ? 'selected' : '' }}>Santo Tomás</option>
            <option value="Panchimalco" {{ request('distrito') == 'Panchimalco' ? 'selected' : '' }}>Panchimalco</option>
            <option value="Santiago Texacuangos" {{ request('distrito') == 'Santiago Texacuangos' ? 'selected' : '' }}>Santiago Texacuangos</option>
            <option value="Rosario de Mora" {{ request('distrito') == 'Rosario de Mora' ? 'selected' : '' }}>Rosario de Mora</option>
        </select>

        <button type="submit" style="background: #041E42; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-weight: 600;">Filtrar</button>
        <a href="/panel" style="background: #e2e8f0; color: #041E42; text-decoration: none; padding: 8px 14px; border-radius: 4px; font-weight: 600; display: flex; align-items: center;">Limpiar</a>
    </form>

</div>

</body>
</html>

