<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<div style="text-align: center; margin-bottom: 15px;">
    <img src="{{ asset('img/logoSSS2.jpeg') }}" alt="Logotipo oficial de la Alcaldía Municipal de San Salvador Sur, con la identificación institucional de la municipalidad sobre un fondo blanco." style="max-height: 80px; width: auto;">
</div>
    <title>Alcaldía Municipal de San Salvador Sur - Sistema de Tickets</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: linear-gradient(135deg, #1933a7 0%, #0d3168 100%); min-height: 100vh; color: #334155; margin: 0; padding: 20px;}
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        <div> style="text-align: center; margin-bottom: 15px;"> <img> src="{{ asset('img/logoSSS2.jpeg') }}" alt="Logotipo oficial de la Alcaldía Municipal de San Salvador Sur, con la identificación institucional de la municipalidad sobre un fondo blanco." style="max-height: 80px; width: auto;">
</div>

        h1 { color: #000060; text-align: center; margin-bottom: 10px; border-bottom: 3px solid#CAFBFF; padding-bottom: 10px; font-weight: 700; }
        label { font-weight: 600; color: #000060; display: block; margin-top: 15px; font-size: 14px; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-family: inherit; }
        textarea { height: 100px; resize: none; }
        button { background-color: #000060; color: white; border: none; padding: 12px 20px; margin-top: 20px; width: 100%; border-radius: 6px; font-size: 16px; cursor: pointer; font-weight: 700; }
        button:hover { background-color: #001BA0; }
        .banner { padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 600; text-align: center; }
        .success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .error { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
</head>
<body>

<div class="container">
    @if(session('exito'))
        <div class="banner success">{{ session('exito') }}</div>
    @endif

    @if(session('error'))
        <div class="banner error">{{ session('error') }}</div>
    @endif

    <h1> Nuevo Ticket</h1>
    <div style="text-align: right; margin-bottom: 15px;">
        <a href="/panel" style="color: #041E42; font-weight: 700; text-decoration: none;">Ver Panel de Tickets ➔</a>
    </div>

    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Asunto del Problema:</label>
        <input type="text" name="asunto" placeholder="Ej. Error de acceso al portal de tributos..." required>

        <label>Categoría:</label>
        <select name="categoria">
            <option value="Hardware">Hardware (Equipos, Impresoras, Redes)</option>
            <option value="Software">Software (Sistemas, Correos, Portal)</option>
        </select>

        <label>Prioridad:</label>
        <select name="prioridad">
            <option value="baja">Baja</option>
            <option value="media" selected>Media</option>
            <option value="alta">Alta</option>
            <option value="urgente">Urgente</option>
        </select>

        <label>Distrito Municipal:</label>
        <select name="distrito">
            <option value="San Marcos">San Marcos</option>
            <option value="Santo Tomas">Santo Tomás</option>
            <option value="Panchimalco">Panchimalco</option>
            <option value="Santiago Texacuangos">Santiago Texacuangos</option>
            <option value="Rosario de Mora">Rosario de Mora</option>
        </select>

        <label>Descripción detallada del fallo:</label>
        <textarea name="descripcion" placeholder="Describe detalladamente lo que ocurre con el equipo..." required></textarea>

        <label>Evidencia / Captura de pantalla (Opcional):</label>
        <input type="file" name="archivo" accept=".jpg,.jpeg,.png,.pdf">

        <button type="submit">Enviar Ticket</button>
    </form>
</div>

</body>
</html>

