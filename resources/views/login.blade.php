<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div style="text-align: center; margin-bottom: 15px;">
    <img src="{{ asset('img/logoSSS2.jpeg') }}" alt="Logotipo oficial de la Alcaldía Municipal de San Salvador Sur, con la identificación institucional de la municipalidad sobre un fondo blanco." style="max-height: 80px; width: auto;">
</div>
    <title>Acceso Institucional - Alcaldía San Salvador Sur</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; background: linear-gradient(135deg, #1933a7 0%, #0d3168 100%); min-height: 100vh; color: #334155; margin: 0; padding: 20px;}
        .login-card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); width: 100%; max-width: 400px; border-top: 5px solid #000060; }
        h1 { color: #000060; text-align: center; font-size: 22px; margin-bottom: 5px; font-weight: 700; }
        p.subtitulo { text-align: center; color: #64748b; font-size: 14px; margin-bottom: 25px; border-bottom: 2px solid #CAFBFF; padding-bottom: 10px; }
        label { font-weight: 600; color:#000060; display: block; margin-top: 15px; font-size: 14px; }
        input { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-family: inherit; }
        button { background-color: #000060; color: white; border: none; padding: 12px; margin-top: 25px; width: 100%; border-radius: 6px; font-size: 16px; cursor: pointer; font-weight: 700; }
        button:hover { background-color: #0a2d5e; }
        .alerta-error { background-color: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; text-align: center; font-weight: 600; }
        .alerta-exito { background-color: #dcfce7; color: #166534; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; text-align: center; font-weight: 600; }
        .btn-registro { display: block; text-align: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0; color: #000060; text-decoration: none; font-size: 14px; font-weight: 600; }
        .btn-registro:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="login-card">

    <h1> Alcaldía Municipal de San Salvador Sur</h1>
    <p class="subtitulo">Sistema de Soporte Técnico (TI)</p>

    @if(session('error'))
        <div class="alerta-error">{{ session('error') }}</div>
    @endif

    @if(session('exito'))
        <div class="alerta-exito">{{ session('exito') }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <!-- Campo de Correo Institucional -->
        <label>Correo Institucional:</label>
        <input type="email" name="correo" placeholder="usuario@sansalvadorsur.gob.sv" required>

        <!-- Campo de Contraseña con Iconos SVG -->
        <label>Contraseña:</label>
        <div style="position: relative; display: flex; align-items: center;">
            <input type="password" id="campo-password" name="password" placeholder="••••••••" required style="padding-right: 40px;">
            <span onclick="togglePassword()" style="position: absolute; right: 12px; cursor: pointer; display: flex; align-items: center; color: #64748b;" title="Mostrar/Ocultar contraseña">
                <svg id="icono-abierto" xmlns="http://w3.org" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <svg id="icono-cerrado" xmlns="http://w3.org" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>
            </span>
        </div>

        <button type="submit">Ingresar al Sistema</button>
    </form>

    <a href="/registro" class="btn-registro">📝 ¿No tienes cuenta? Regístrate aquí</a>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('campo-password');
        const ojoAbierto = document.getElementById('icono-abierto');
        const ojoCerrado = document.getElementById('icono-cerrado');
        if (input.type === 'password') {
            input.type = 'text';
            ojoAbierto.style.display = 'none';
            ojoCerrado.style.display = 'block';
        } else {
            input.type = 'password';
            ojoAbierto.style.display = 'block';
            ojoCerrado.style.display = 'none';
        }
    }
</script>

</body>
</html>

