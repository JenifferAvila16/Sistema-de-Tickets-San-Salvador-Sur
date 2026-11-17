<!DOCTYPE html>
<html lang="es">
<head><!-- Importar tipografía institucional desde Google Fonts -->
<link rel="preconnect" href="https://googleapis.com">
<link rel="preconnect" href="https://gstatic.com" crossorigin>
<link href="https://googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Institucional - Alcaldía San Salvador Sur</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fa; margin: 0; padding: 20px; }
        .login-card { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; border-top: 5px solid #003366; }
        h1 { color: #003366; text-align: center; font-size: 22px; margin-bottom: 5px; }
        p.subtitulo { text-align: center; color: #666; font-size: 14px; margin-bottom: 25px; border-bottom: 2px solid #ffcc00; padding-bottom: 10px; }
        label { font-weight: bold; color: #333; display: block; margin-top: 15px; font-size: 14px; }
        input { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #003366; color: white; border: none; padding: 12px; margin-top: 25px; width: 100%; border-radius: 4px; font-size: 16px; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #002244; }
        .alerta-error { background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 13px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

<div class="login-card">
    <h1>🏛️ Alcaldía Municipal de San Salvador Sur</h1>
    <p class="subtitulo">Sistema de Soporte Técnico (TI)</p>

    @if(session('error'))
        <div class="alerta-error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <label>Correo Institucional:</label>
        <input type="email" name="correo" placeholder="usuario@sansalvadorsur.gob.sv" required>

        <label>Contraseña:</label>
        <input type="password" name="password" placeholder="••••••••" required>

        <button type="submit">Ingresar al Sistema</button>
    </form>
</div>

</body>
</html>
