<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Reporte' }}</title>
    <style>
      body{font-family:Arial, Helvetica, sans-serif;color:#222}
      .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px}
      .title{font-weight:800;font-size:18px}
      .day-block{margin-bottom:12px}
      .section{margin-top:8px}
      .item{margin-bottom:6px}
      .meta{font-size:12px;color:#666}
      .notice{background:#fff3cd;color:#856404;padding:8px;border-radius:6px;margin-bottom:10px}
      table{width:100%;border-collapse:collapse}
      th,td{border:1px solid #ddd;padding:8px;text-align:left}
    </style>
  </head>
  <body>
    <div style="text-align:center;margin-bottom:12px;line-height:1.05;">
      <div style="font-size:18px;font-weight:800;letter-spacing:0.6px">VENEZOLANA DE INDUSTRIA TECNOLOGICA C.A</div>
      <div style="font-size:16px;font-weight:700;letter-spacing:0.4px;margin-top:4px">BITACORA DE ACTIVIDADES</div>
      <div style="font-size:14px;font-weight:700;margin-top:2px">DEPARTAMENTO DE REDES Y SERVIDORES</div>
    </div>

    <div class="header">
      <div class="title">{{ $title ?? 'Reporte' }}</div>
      <div class="meta">Generado: {{ isset($generated_at) ? $generated_at->format('d/m/Y H:i') : \Carbon\Carbon::now()->format('d/m/Y H:i') }}<br>
        Por: {{ isset($generated_by) ? ($generated_by->name ?? $generated_by->email ?? 'Desconocido') : 'Desconocido' }}</div>
    </div>

    @if(isset($notice))
      <div class="notice">{{ $notice }}</div>
    @endif

    @if(isset($byDay) && count($byDay))
      @foreach($byDay as $day)
        <div class="day-block">
          <div style="font-weight:700">{{ $day['weekday'] }} - {{ $day['date']->format('d/m/Y') }}</div>

          <div class="section">
            <div style="font-weight:700">Actividades</div>
            @php
              $activities = [];
              if(isset($day['routines'])){
                foreach($day['routines'] as $r){ $activities[] = $r->content; }
              }
              if(isset($day['incidencias'])){
                foreach($day['incidencias'] as $inc){ $activities[] = $inc->content; }
              }
            @endphp

            @if(count($activities))
              <ul style="padding-left:18px;margin-top:6px">
                @foreach($activities as $act)
                  <li style="margin-bottom:6px">{{ $act }}</li>
                @endforeach
              </ul>
            @else
              <div class="item">No hay actividades este día.</div>
            @endif
          </div>
        </div>
      @endforeach
    @else
      <div>No hay datos para el rango seleccionado.</div>
    @endif
  </body>
</html>