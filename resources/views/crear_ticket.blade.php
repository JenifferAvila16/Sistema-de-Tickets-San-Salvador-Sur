<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alcaldía San Salvador Sur - Sistema de Tickets</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f0f4f8; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        h1 { color: #003366; text-align: center; margin-bottom: 25px; border-bottom: 3px solid #ffcc00; padding-bottom: 10px; }
        label { font-weight: bold; color: #333; display: block; margin-top: 15px; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        textarea { height: 100px; resize: none; }
        button { background-color: #003366; color: white; border: none; padding: 12px 20px; margin-top: 20px; width: 100%; border-radius: 4px; font-size: 16px; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #002244; }
        .banner { display: none; padding: 15px; border-radius: 4px; margin-bottom: 20px; font-weight: bold; text-align: center; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; background: #e9ecef; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px; font-size: 14px;">
    <span>👤 Conectado como: <strong>{{ session('usuario_nombre') }}</strong> ({{ session('usuario_rol') }})</span>
    <a href="{{ route('logout') }}" style="background: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 12px;">🚪 Cerrar Sesión</a>
</div>

    <!-- Banner de Alerta Único Dinámico -->
    <div id="alerta-sistema" class="banner"></div>

    <h1> Nuevo Ticket de Soporte</h1>
    <div style="text-align: right; margin-bottom: 15px;">
    <a href="/panel" style="color: #003366; font-weight: bold; text-decoration: none;">📋 Ver Panel de Tickets ➔</a>
</div>

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

        <button type="submit" id="btn-enviar">Enviar Reporte a TI</button>
        <label>Evidencia / Captura de pantalla (Opcional):</label>
        <input type="file" name="archivo" accept=".jpg,.jpeg,.png,.pdf">

        <button type="submit" id="btn-enviar">Enviar Reporte a TI</button>
    </form>
</div>

<script>
    document.getElementById('form-ticket').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = document.getElementById('btn-enviar');
        const alerta = document.getElementById('alerta-sistema');

        btn.disabled = true;
        btn.innerText = " Guardando en Ticket...";

        try {
            // Enviamos los datos de forma silenciosa al backend de Laravel
            const respuesta = await fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            // Mostramos el banner verde de éxito de forma inmediata
            alerta.className = "banner success";
            alerta.innerText = " ¡Ticket creado exitosamente!";
            alerta.style.display = "block";

            this.reset(); // Limpia los campos del formulario para el siguiente ticket

        } catch (error) {
            alerta.className = "banner error";
            alerta.innerText = "❌ Error en el sistema: " + error.message;
            alerta.style.display = "block";
        } finally {
            btn.disabled = false;
            btn.innerText = "Enviar Reporte a TI";
        }
    });
</script>

</body>
</html>
