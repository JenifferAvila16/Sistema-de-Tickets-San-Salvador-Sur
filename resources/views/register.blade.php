<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Personal - Alcaldía San Salvador Sur</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: linear-gradient(135deg, #1933a7 0%, #0d3168 100%); min-height: 100vh; color: #334155; margin: 0; padding: 20px;}
        .card { background: white; padding: 35px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); width: 100%; max-width: 550px; border-top: 5px solid #041E42; }
        h1 { color: #041E42; text-align: center; font-size: 22px; margin-bottom: 5px; }
        p.subtitulo { text-align: center; color: #64748b; font-size: 14px; margin-bottom: 20px; border-bottom: 2px solid #CAFBFF; padding-bottom: 10px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        label { font-weight: 600; color: #041E42; display: block; margin-top: 12px; font-size: 13px; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-family: inherit; }
        button { background-color: #041E42; color: white; border: none; padding: 12px; margin-top: 25px; width: 100%; border-radius: 6px; font-size: 16px; cursor: pointer; font-weight: 700; }
        button:hover { background-color: #0a2d5e; }
        .link-login { display: block; text-align: center; margin-top: 15px; color: #041E42; text-decoration: none; font-size: 14px; font-weight: 600; }
        .alerta-error { background-color: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; }
    </style>
</head>
<body>

<div class="card">
    <div style="text-align: center; margin-bottom: 15px;">
    <img src="{{ asset('img/logoSSS2.jpeg') }}" alt="Logotipo oficial de la Alcaldía Municipal de San Salvador Sur, con la identificación institucional de la municipalidad sobre un fondo blanco." style="max-height: 80px; width: auto;">
</div>
    <h1>🏛️ Alcaldía San Salvador Sur</h1>
    <p class="subtitulo">Registro de Nuevo Empleado</p>

    @if($errors->any())
        <div class="alerta-error">
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <div class="grid-2">
            <div>
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div>
                <label>Apellido:</label>
                <input type="text" name="apellido" required>
            </div>
        </div>

        <div class="grid-2">
            <div>
                <label>Cargo:</label>
                <input type="text" name="cargo" placeholder="Ej. Auxiliar Administrativo" required>
            </div>
            <div>
                <label>Departamento / Unidad:</label>
                <input type="text" name="departamento_unidad" placeholder="Ej. Catastro / TI" required>
            </div>
        </div>

        <div class="grid-2">
            <div>
                <label>Distrito Municipal:</label>
                <select name="distrito">
                    <option value="San Marcos">San Marcos</option>
                    <option value="Santo Tomas">Santo Tomás</option>
                    <option value="Panchimalco">Panchimalco</option>
                    <option value="Santiago Texacuangos">Santiago Texacuangos</option>
                    <option value="Rosario de Mora">Rosario de Mora</option>
                </select>
            </div>
            <div>
                <label>Teléfono / Extensión:</label>
                <input type="text" name="telefono" placeholder="Ej. 2222-0000" required>
            </div>
        </div>

        <label>Correo Institucional:</label>
        <input type="email" name="correo_institucional" placeholder="nombre.apellido@sansalvadorsur.gob.sv" required>

        <label>Contraseña:</label>
<div style="position: relative; display: flex; align-items: center;">
    <input type="password" id="campo-password" name="password" placeholder="••••••••" required style="padding-right: 40px;">
    <span onclick="togglePassword()" style="position: absolute; right: 12px; cursor: pointer; display: flex; align-items: center; color: #64748b;" title="Mostrar/Ocultar contraseña">
        <!-- Ojo Abierto (Visible por defecto) -->
        <svg id="icono-abierto" xmlns="http://w3.org" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
        <!-- Ojo Cerrado / Tachado (Oculto por defecto) -->
        <svg id="icono-cerrado" xmlns="http://w3.org" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
        </svg>
    </span>
</div>



        <button type="submit">Crear Mi Cuenta</button>
    </form>

    <a href="/login" class="link-login">⬅ ¿Ya tienes cuenta? Inicia sesión aquí</a>
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
