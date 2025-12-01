<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitácora - Reportes</title>
    <style>
      :root{
        --red-1:#E22227;
        --dark-1:#222B31;
        --card-bg:rgba(34,43,49,0.95);
        --sidebar-bg:rgba(20,26,29,0.95);
        --glass-border:rgba(255,255,255,0.03);
      }
      html,body{height:100%;margin:0;font-family:Segoe UI, Roboto, Helvetica, Arial, sans-serif;background:linear-gradient(180deg,var(--dark-1) 0%, #16181a 60%);color:#e6eef2}
      .wrap{min-height:100%;display:flex;align-items:center;justify-content:center;padding:28px}
      .outer{width:100%;max-width:1300px;border-radius:14px;padding:18px;background:transparent}
      .inner{background:var(--card-bg);border-radius:12px;padding:18px;display:flex;min-height:620px;border:1px solid var(--glass-border);box-shadow:0 30px 70px rgba(0,0,0,0.6)}
      .sidebar{width:260px;background:var(--sidebar-bg);border-radius:8px;padding:22px;display:flex;flex-direction:column;gap:18px}
      .brand{font-weight:800;color:var(--red-1);font-size:22px}
      .dept{font-size:13px;color:#cbd5dd}
      .menu{display:flex;flex-direction:column;gap:8px;margin-top:10px}
      .menu a{color:#cbd5dd;text-decoration:none;padding:10px 12px;border-radius:8px;font-weight:600}
      .menu a:hover{background:rgba(255,255,255,0.02)}
      .user-bottom{margin-top:auto;font-size:14px;color:#cbd5dd}
      .main{flex:1;padding-left:28px;display:flex;flex-direction:column}
      .topbar{display:flex;justify-content:center;align-items:center;padding:6px 0}
      .title-pill{background:rgba(255,255,255,0.03);padding:10px 40px;border-radius:8px;border:1px solid rgba(255,255,255,0.02);font-weight:700}
      .content{margin-top:18px;flex:1;border-radius:8px;padding:18px;background:linear-gradient(180deg,rgba(255,255,255,0.01), rgba(0,0,0,0.03));position:relative}

      .form-row{display:flex;align-items:center;gap:12px;margin-bottom:12px}
      .form-row label{min-width:80px}
      .card{background:rgba(0,0,0,0.18);border-radius:10px;padding:14px;border:1px solid rgba(255,255,255,0.02)}

      .results{margin-top:18px}
      .result-box{background:rgba(255,255,255,0.02);padding:12px;border-radius:8px;margin-bottom:8px}

      @media(max-width:980px){.inner{flex-direction:column}.sidebar{width:100%;flex-direction:row;gap:12px;overflow:auto}.main{padding-left:0}.topbar{justify-content:flex-start}}
    </style>
  </head>
  <body>
    <div class="wrap">
      <div class="outer">
        <div class="inner">
          <aside class="sidebar">
            <div>
              <div class="brand">Bitácora</div>
              <div class="dept">Departamento de redes y servidores</div>
            </div>

            <nav class="menu" aria-label="Menú principal">
              <div style="position:relative">
                <button id="adminBtn" onclick="toggleAdmin()" style="width:100%;text-align:left;padding:10px 12px;border-radius:8px;border:0;background:transparent;color:#cbd5dd;font-weight:700;cursor:pointer">Administrador ▾</button>
                <div id="adminSub" class="submenu" style="display:none;margin-top:6px;">
                  <a href="{{ route('admin.usuarios') }}" style="display:block;padding:8px 12px;border-radius:6px;color:#cbd5dd;text-decoration:none">Usuarios</a>
                  <a href="{{ route('admin.rutinas') }}" style="display:block;padding:8px 12px;border-radius:6px;color:#cbd5dd;text-decoration:none">Rutinas</a>
                </div>
              </div>

              <a href="{{ route('admin.gestion') }}">Gestión</a>
              <a href="{{ route('admin.reportes') }}">Reportes</a>
            </nav>

            <div class="user-bottom" style="position:relative">
              <button id="userBtn" onclick="toggleUser()" style="background:transparent;border:0;color:#cbd5dd;font-weight:700;cursor:pointer">@auth {{ Auth::user()->name }} {{ Auth::user()->lastname ?? '' }} @else Usuario @endauth ▴</button>
              <div id="userSub" class="submenu" style="display:none;margin-top:6px;">
                <a href="{{ route('user.info') }}" style="display:block;padding:8px 12px;border-radius:6px;color:#cbd5dd;text-decoration:none">Información</a>
                <form method="POST" action="{{ route('logout') }}" style="margin:6px 0 0">
                  @csrf
                  <button type="submit" style="display:block;padding:8px 12px;border-radius:6px;color:#cbd5dd;background:transparent;border:0;text-align:left;width:100%">Salir</button>
                </form>
              </div>
            </div>
          </aside>

          <main class="main">
            <div class="topbar">
              <div class="title-pill">Reportes</div>
            </div>

            <div class="content">
              <form method="GET" action="{{ route('admin.reportes') }}" class="card">
                <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
                  <label style="font-weight:700">Rango</label>
                  <label><input type="radio" name="range" value="week" checked> Semana</label>

                  <label style="margin-left:12px">Desde (fecha)</label>
                  @php $defaultFrom = isset($from_date) ? $from_date : (isset($from) ? $from->copy()->startOfDay() : \Carbon\Carbon::today()->startOfWeek()); @endphp
                  <input type="date" name="from_date" value="{{ isset($defaultFrom) ? $defaultFrom->format('Y-m-d') : '' }}" style="padding:6px;border-radius:6px;background:transparent;color:#e6eef2;border:1px solid rgba(255,255,255,0.03)">

                  <label>Hasta (fecha)</label>
                  @php $defaultTo = isset($to_date) ? $to_date : (isset($to) ? $to->copy()->endOfDay() : \Carbon\Carbon::today()->endOfWeek()); @endphp
                  <input type="date" name="to_date" value="{{ isset($defaultTo) ? $defaultTo->format('Y-m-d') : '' }}" style="padding:6px;border-radius:6px;background:transparent;color:#e6eef2;border:1px solid rgba(255,255,255,0.03)">

                  <div style="margin-left:auto">
                    <button type="submit" style="background:var(--red-1);color:#fff;padding:8px 12px;border-radius:8px;border:0;cursor:pointer;font-weight:700">Consultar</button>
                  </div>
                </div>
              </form>

              <div class="results">
                @if(isset($range) && $range === 'week' && isset($byDay) && count($byDay))
                  {{-- Mostrar lista por día para la semana --}}
                  @foreach($byDay as $day)
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:8px;margin-bottom:6px">
                      <div style="font-weight:800;font-size:18px">{{ $day['weekday'] }}</div>
                      <div style="color:#cbd5dd">{{ $day['date']->format('d/m/Y') }}</div>
                    </div>
                    <div style="text-align:right;margin-bottom:8px">
                      <a href="{{ route('admin.reportes.pdf.day', ['date' => $day['date']->format('Y-m-d')]) }}" target="_blank" style="background:var(--red-1);color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none">Generar PDF del día</a>
                    </div>

                    <div class="card" style="margin-bottom:10px">
                      <div style="display:flex;gap:18px;flex-wrap:wrap">
                        <div style="flex:1;min-width:240px">
                          <div style="font-weight:700;margin-bottom:6px">Rutinas marcadas</div>
                          @if(isset($day['routines']) && count($day['routines']))
                            @foreach($day['routines'] as $r)
                              <div style="padding:6px 0;border-bottom:1px solid rgba(255,255,255,0.02)">
                                <div style="font-weight:700">{{ $r->content }}</div>
                                <div style="font-size:12px;color:#9fb0b8">Marcada: {{ $r->updated_at ? $r->updated_at->format('H:i') : '' }}</div>
                              </div>
                            @endforeach
                          @else
                            <div style="color:#9fb0b8">No hay rutinas marcadas este día.</div>
                          @endif
                        </div>

                        <div style="flex:1;min-width:240px">
                          <div style="font-weight:700;margin-bottom:6px">Incidencias</div>
                          @if(isset($day['incidencias']) && count($day['incidencias']))
                            @foreach($day['incidencias'] as $inc)
                              <div style="padding:6px 0;border-bottom:1px solid rgba(255,255,255,0.02)">
                                <div style="font-weight:700">Incidencia #{{ $loop->iteration }}</div>
                                <div style="color:#cbd5dd">{{ $inc->content }}</div>
                                <div style="font-size:13px;color:#cbd5dd">Por: {{ optional($inc->user)->name }} {{ optional($inc->user)->lastname }}</div>
                                <div style="font-size:12px;color:#9fb0b8">Creada: {{ $inc->created_at ? $inc->created_at->format('H:i') : '' }}</div>
                              </div>
                            @endforeach
                          @else
                            <div style="color:#9fb0b8">No hay incidencias este día.</div>
                          @endif
                        </div>
                      </div>
                    </div>
                  @endforeach
                @else
                  {{-- Comportamiento normal (today/custom/yesterday) --}}
                  <h3>Rutinas</h3>
                  @if(isset($routinesDone) && count($routinesDone))
                    @foreach($routinesDone as $r)
                      <div class="result-box">
                        <div style="font-weight:700">{{ $r->content }}</div>
                        <div style="font-size:12px;color:#9fb0b8">Marcada: {{ $r->updated_at ? $r->updated_at->format('Y-m-d H:i') : '' }}</div>
                      </div>
                    @endforeach
                  @else
                    <div class="result-box">No hay rutinas marcadas en el rango seleccionado.</div>
                  @endif

                  <h3 style="margin-top:18px">Incidencias registradas</h3>
                  @if(isset($incidencias) && count($incidencias))
                    @php $currentDate = null; $dailyCounter = 0; @endphp
                    @foreach($incidencias as $inc)
                      @php
                        $incDate = $inc->created_at ? $inc->created_at->format('Y-m-d') : null;
                        if ($incDate !== $currentDate) { $currentDate = $incDate; $dailyCounter = 1; } else { $dailyCounter++; }
                      @endphp
                      <div class="result-box">
                        <div style="font-weight:700">Incidencia #{{ $dailyCounter }} ({{ $inc->created_at ? $inc->created_at->format('d/m/Y') : '' }})</div>
                        <div style="color:#cbd5dd">{{ $inc->content }}</div>
                        <div style="font-size:13px;color:#cbd5dd">Por: {{ optional($inc->user)->name }} {{ optional($inc->user)->lastname }}</div>
                        <div style="font-size:12px;color:#9fb0b8">Creada: {{ $inc->created_at ? $inc->created_at->format('Y-m-d H:i') : '' }}</div>
                      </div>
                    @endforeach
                  @else
                    <div class="result-box">No hay incidencias en el rango seleccionado.</div>
                  @endif
                @endif

                {{-- Botón para generar PDF del rango seleccionado --}}
                <div style="margin-top:18px;text-align:right">
                  @php
                    $pdfQuery = [];
                    if(isset($from_date)) $pdfQuery['from_date'] = $from_date->format('Y-m-d');
                    if(isset($to_date)) $pdfQuery['to_date'] = $to_date->format('Y-m-d');
                  @endphp
                  <a href="{{ route('admin.reportes.pdf.range', $pdfQuery) }}" target="_blank" style="background:#111;color:#fff;padding:8px 12px;border-radius:8px;text-decoration:none">Generar PDF de la semana</a>
                </div>
              </div>

            </div>
          </main>
        </div>
      </div>
    </div>

    <script>
      function toggleAdmin(){
        var sub = document.getElementById('adminSub');
        if(!sub) return;
        sub.style.display = (sub.style.display === 'none' || sub.style.display === '') ? 'block' : 'none';
      }
      function toggleUser(){
        var sub = document.getElementById('userSub');
        if(!sub) return;
        sub.style.display = (sub.style.display === 'none' || sub.style.display === '') ? 'block' : 'none';
      }
    </script>
  </body>
</html>