<!DOCTYPE html>
<html lang="es">
<head>
<link rel="preconnect" href="https://googleapis.com">
<link rel="preconnect" href="https://gstatic.com" crossorigin>
<link href="https://googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Ticket #{{ $ticket->id }} - Alcaldía San Salvador Sur</title>
    <style>
    body {font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fa; color: #4a5568; margin: 0; padding: 20px;}
    h1, h2, h3 { color: #041E42;font-weight: 700;}
    .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header-panel { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #ffcc00; padding-bottom: 15px; margin-bottom: 20px; }
        h1, h2 { color: #041E42; margin: 0; }
        .btn-volver { background-color: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 14px; }
        .btn-volver:hover { background-color: #5a6268; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; background: #f8f9fa; padding: 20px; border-radius: 6px; border-left: 4px solid #041E42; margin-bottom: 20px; }
        .descripcion-box { background: #fff; border: 1px solid #e0e0e0; padding: 15px; border-radius: 6px; margin-bottom: 30px; line-height: 1.6; }
        .historial-item { border-left: 3px solid #ffcc00; padding-left: 15px; margin-bottom: 15px; background: #fdfdfd; padding: 10px 15px; border-radius: 0 4px 4px 0; border-top: 1px solid #eee; border-right: 1px solid #eee; border-bottom: 1px solid #eee; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; background: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-panel">
        <h1></h1> Ticket #{{ $ticket->id }}: {{ $ticket->asunto }}</h1>
        <a href="/panel" class="btn-volver">⬅ Volver al Panel</a>
    </div>

    <div class="info-grid">
        <div><strong> Solicitante:</strong> {{ $ticket->reportado_por }} {{ $ticket->apellido }}</div>
        <div><strong> Distrito:</strong> {{ $ticket->distrito }}</div>
        <div><strong> Categoría:</strong> {{ $ticket->categoria }}</div>
        <div><strong> Prioridad:</strong> <span class="badge">{{ $ticket->prioridad }}</span></div>
        <div><strong> Estado Actual:</strong> <span class="badge">{{ $ticket->estado }}</span></div>
        <div><strong> Fecha de Creación:</strong> {{ $ticket->fecha_creacion }}</div>
    </div>

    <h3>📝 Descripción Detallada del Problema</h3>
    <div class="descripcion-box">
        {{ $ticket->descripcion_detallada }}
    </div>

    <h3>📎 Archivos Adjuntos / Evidencia</h3>
    <div style="margin-bottom: 30px;">
        @if(count($adjuntos) == 0)
            <p style="color: #666;">No se adjuntaron archivos en este reporte.</p>
        @else
            @foreach($adjuntos as $adjunto)
                <div style="background: #f8f9fa; padding: 10px 15px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                    <span>📄 <strong>{{ $adjunto->nombre_archivo }}</strong> <small style="color: #666;">({{ round($adjunto->tamano_bytes / 1024, 1) }} KB)</small></span>
                    <a href="{{ asset('storage/' . $adjunto->ruta_almacenamiento) }}" target="_blank" style="background: #003366; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; font-weight: bold;">👁️ Ver / Descargar</a>
                </div>
            @endforeach
        @endif
    </div>
        {{ $ticket->descripcion_detallada }}
    </div>

    <h2 style="margin-bottom: 15px; border-bottom: 2px solid #eee; padding-bottom: 8px;"> (Historial de Cambios)</h2>

    @if(count($historial) == 0)
        <p style="color: #666;"></p>Este ticket aún no tiene movimientos registrados en su historial.</p>
    @else
        @foreach($historial as $item)
            <div class="historial-item">
                <p style="margin: 0 0 5px 0;">
                    <strong>{{ $item->modificado_por }}</strong> cambió el estado de
                    <span class="badge">{{ $item->estado_anterior }}</span> ➔
                    <span class="badge">{{ $item->estado_nuevo }}</span>
                </p>
                <p style="margin: 0; color: #555; font-size: 14px;">💬 <em>"{{ $item->comentario }}"</em></p>
            </div>
        @endforeach
    @endif
</div>

</body>
</html>
