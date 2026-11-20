<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div style="text-align: center; margin-bottom: 15px;">
    <img src="{{ asset('img/logoSSS2.jpeg') }}" alt="Logotipo oficial de la Alcaldía Municipal de San Salvador Sur, con la identificación institucional de la municipalidad sobre un fondo blanco." style="max-height: 80px; width: auto;">
</div>
    <title>Dashboard Administrativo - Alcaldía San Salvador Sur</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: linear-gradient(135deg, #1933a7 0%, #0d3168 100%); min-height: 100vh; color: #334155; margin: 0; padding: 20px;}
        .container { max-width: 1100px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header-panel { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #CAFBFF; padding-bottom: 15px; margin-bottom: 25px; }
        h1, h2, h3 { color: #041E42; margin: 0; font-weight: 700; }
        .nav-links { display: flex; gap: 10px; }
        .btn { background-color: #041E42; color: white; padding: 10px 15px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; }
        .btn-secundario { background-color: #e2e8f0; color: #041E42; }

        .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 35px; }
        .kpi-card { background: #f8fafc; padding: 20px; border-radius: 8px; border-left: 5px solid #041E42; box-shadow: 0 2px 5px rgba(0,0,0,0.03); }
        .kpi-card.abiertos { border-left-color: #16a34a; }
        .kpi-card.pendientes { border-left-color: #eab308; }
        .kpi-card.resueltos { border-left-color: #64748b; }
        .kpi-numero { font-size: 32px; font-weight: 700; color: #041E42; margin: 5px 0; }
        .kpi-titulo { font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 600; }

        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .stat-box { background: #f8fafc; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .barra-item { margin-top: 15px; }
        .barra-header { display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; margin-bottom: 5px; color: #041E42; }
        .barra-fondo { background: #e2e8f0; height: 10px; border-radius: 5px; overflow: hidden; }
        .barra-relleno { background: #041E42; height: 100%; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-panel">
        <h1>Resumen del Flujo de Trabajo</h1>
        <div class="nav-links">
            <a href="/panel" class="btn btn-secundario"> Lista de Tickets</a>
            <a href="/" class="btn">➕ Nuevo Ticket</a>
        </div>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-titulo">Total de Reportes</div>
            <div class="kpi-numero">{{ $totalTickets }}</div>
        </div>
        <div class="kpi-card abiertos">
            <div class="kpi-titulo">🟢 Abiertos (Nuevos)</div>
            <div class="kpi-numero">{{ $abiertos }}</div>
        </div>
        <div class="kpi-card pendientes">
            <div class="kpi-titulo">🟡 En Proceso / Pendientes</div>
            <div class="kpi-numero">{{ $pendientes }}</div>
        </div>
        <div class="kpi-card resueltos">
            <div class="kpi-titulo">⚪ Resueltos / Cerrados</div>
            <div class="kpi-numero">{{ $resueltos }}</div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-box">
            <h3 style="margin-bottom: 15px;"> Tickets por Distrito Municipal</h3>
            @foreach($porDistrito as $item)
                @php $porcentaje = $totalTickets > 0 ? round(($item->total / $totalTickets) * 100) : 0; @endphp
                <div class="barra-item">
                    <div class="barra-header">
                        <span>{{ $item->distrito }}</span>
                        <span>{{ $item->total }} ({{ $porcentaje }}%)</span>
                    </div>
                    <div class="barra-fondo">
                        <div class="barra-relleno" style="width: {{ $porcentaje }}%;"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="stat-box">
            <h3 style="margin-bottom: 15px;"> Distribución por Categoría</h3>
            @foreach($porCategoria as $cat)
                @php $porcentajeCat = $totalTickets > 0 ? round(($cat->total / $totalTickets) * 100) : 0; @endphp
                <div class="barra-item">
                    <div class="barra-header">
                        <span>{{ $cat->categoria }}</span>
                        <span>{{ $cat->total }} ({{ $porcentajeCat }}%)</span>
                    </div>
                    <div class="barra-fondo">
                        <div class="barra-relleno" style="width: {{ $porcentajeCat }}%; background-color: #0284c7;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

</body>
</html>
