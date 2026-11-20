<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Usuarios - Alcaldía San Salvador Sur</title>
    <div style="text-align: center; margin-bottom: 15px;">
    <img src="{{ asset('img/logoSSS2.jpeg') }}" alt="Logotipo oficial de la Alcaldía Municipal de San Salvador Sur, con la identificación institucional de la municipalidad sobre un fondo blanco." style="max-height: 80px; width: auto;">
</div>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: linear-gradient(135deg, #1933a7 0%, #0d3168 100%); min-height: 100vh; color: #334155; margin: 0; padding: 20px;}
        .container { max-width: 1100px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header-panel { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #CAFBFF; padding-bottom: 15px; margin-bottom: 25px; }
        h1 { color: #041E42; margin: 0; font-weight: 700; }
        .btn-volver { background-color: #041E42; color: white; padding: 10px 15px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #041E42; color: white; font-size: 14px; }
        tr:hover { background-color: #f8fafc; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; }
        .estado-activo { background-color: #dcfce7; color: #166534; }
        .estado-inactivo { background-color: #fee2e2; color: #991b1b; }
        .btn-accion { border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 13px; color: white; }
        .btn-suspender { background-color: #dc2626; }
        .btn-activar { background-color: #16a34a; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-panel">
        <h1>Gestión de Personal y Accesos</h1>
        <a href="/panel" class="btn-volver">⬅ Volver al Panel de TI</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Empleado</th>
                <th>Cargo / Unidad</th>
                <th>Distrito</th>
                <th>Correo Institucional</th>
                <th>Estado</th>
                <th>Control de Acceso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $user)
            <tr>
                <td><strong>#{{ $user->id }}</strong></td>
                <td>{{ $user->nombre }} {{ $user->apellido }}<br><small style="color: #64748b;">Rol: {{ $user->rol }}</small></td>
                <td>{{ $user->cargo }}<br><small style="color: #64748b;">{{ $user->departamento_unidad }}</small></td>
                <td>{{ $user->distrito }}</td>
                <td>{{ $user->correo_institucional }}</td>
                <td>
                    <span class="badge estado-{{ $user->estado }}">{{ $user->estado }}</span>
                </td>
                <td>
                    <form action="{{ route('usuarios.estado', $user->id) }}" method="POST">
                        @csrf
                        @if($user->estado === 'activo')
                            <button type="submit" class="btn-accion btn-suspender">🚫 Suspender</button>
                        @else
                            <button type="submit" class="btn-accion btn-activar">✅ Activar</button>
                        @endif
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
