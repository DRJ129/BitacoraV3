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
    <div class="header">
      <div class="title">{{ $title ?? 'Reporte' }}</div>
      <div class="meta">Generado: {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</div>
    </div>

    @if(isset($notice))
      <div class="notice">{{ $notice }}</div>
    @endif

    @if(isset($byDay) && count($byDay))
      @foreach($byDay as $day)
        <div class="day-block">
          <div style="font-weight:700">{{ $day['weekday'] }} - {{ $day['date']->format('d/m/Y') }}</div>

          <div class="section">
            <div style="font-weight:700">Rutinas marcadas</div>
            @if(isset($day['routines']) && count($day['routines']))
              <table>
                <thead><tr><th>Rutina</th><th>Hora</th></tr></thead>
                <tbody>
                  @foreach($day['routines'] as $r)
                    <tr>
                      <td>{{ $r->content }}</td>
                      <td>{{ $r->updated_at ? $r->updated_at->format('H:i') : '' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @else
              <div class="item">No hay rutinas marcadas este día.</div>
            @endif
          </div>

          <div class="section">
            <div style="font-weight:700">Incidencias</div>
            @if(isset($day['incidencias']) && count($day['incidencias']))
              <table>
                <thead><tr><th>ID</th><th>Contenido</th><th>Hora</th></tr></thead>
                <tbody>
                  @foreach($day['incidencias'] as $inc)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $inc->content }}</td>
                      <td>{{ $inc->created_at ? $inc->created_at->format('H:i') : '' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @else
              <div class="item">No hay incidencias este día.</div>
            @endif
          </div>
        </div>
      @endforeach
    @else
      <div>No hay datos para el rango seleccionado.</div>
    @endif
  </body>
</html>