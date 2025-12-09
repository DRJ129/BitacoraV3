<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitácora - Gestión</title>
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

      /* date box top-right */
      .date-box{position:absolute;right:18px;top:18px;background:rgba(255,255,255,0.02);padding:12px;border-radius:8px;border:1px solid rgba(255,255,255,0.03);text-align:center}
      .date-box .day{font-weight:800;color:var(--red-1);font-size:18px}
      .date-box .date{color:#cbd5dd;font-size:13px}

      .checklist{margin-top:18px}
  .checklist{margin-top:18px}
  .check-item{display:flex;align-items:center;gap:12px;padding:10px;border-radius:8px;background:rgba(255,255,255,0.02);margin-bottom:8px}
  .check-item input[type="checkbox"]{width:18px;height:18px}
  .completed{text-decoration:line-through;opacity:0.7}

  /* incidencias scroll container */
  .incidencias-list{margin-top:8px;max-height:260px;overflow:auto;padding-right:8px}
  .incidencias-list .check-item{padding:12px}
  /* custom thin scrollbar for webkit browsers */
  .incidencias-list::-webkit-scrollbar{width:8px}
  .incidencias-list::-webkit-scrollbar-thumb{background:rgba(255,255,255,0.06);border-radius:6px}
  .incidencias-list::-webkit-scrollbar-track{background:transparent}

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
                  @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.usuarios') }}" style="display:block;padding:8px 12px;border-radius:6px;color:#cbd5dd;text-decoration:none">Usuarios</a>
                  @endif
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
              <div class="title-pill">Gestión</div>
            </div>

            <div class="content">
              <div class="date-box">
                <div class="day">{{ $dayName ?? '' }}</div>
                <div class="date">{{ $today ?? '' }}</div>
              </div>

              <h3>Rutinas</h3>
              @if(session('success'))
                <div style="background:rgba(0,0,0,0.25);padding:10px;border-radius:8px;margin-bottom:12px;color:#cfeee9">{{ session('success') }}</div>
              @endif

              <div style="margin-bottom:12px">
                <button type="button" onclick="toggleIncidencia()" style="background:var(--red-1);color:#fff;padding:8px 12px;border-radius:8px;border:0;cursor:pointer;font-weight:700">Agregar incidencias</button>
              </div>

              <div id="incidenciaBox" style="display:none;margin-bottom:16px">
                <form method="POST" action="{{ route('admin.incidencias.store') }}">
                  @csrf
                  <textarea name="content" rows="4" style="width:100%;border-radius:8px;padding:8px;border:1px solid rgba(255,255,255,0.04);background:transparent;color:#e6eef2" placeholder="Describe la incidencia..."></textarea>
                  <div style="margin-top:8px;text-align:right">
                    <button type="submit" style="background:var(--red-1);color:#fff;padding:8px 12px;border-radius:8px;border:0;cursor:pointer;font-weight:700">Guardar incidencia</button>
                  </div>
                </form>
              </div>
              <div class="checklist">
                @if(isset($routines) && count($routines))
                  @foreach($routines as $r)
                    <div class="check-item">
                      <form method="POST" action="{{ route('admin.rutinas.update', $r) }}">
                        @csrf
                        @method('PATCH')
                        {{-- ensure unchecked checkboxes submit a 0 value --}} 
                        <input type="hidden" name="completed" value="0" />
                        @php $isDone = isset($completedIds) && in_array($r->id, $completedIds); @endphp
                        <input type="checkbox" id="rut-{{ $r->id }}" name="completed" value="1" onchange="this.form.submit();" {{ $isDone ? 'checked' : '' }} />
                        <label for="rut-{{ $r->id }}" class="{{ $isDone ? 'completed' : '' }}">{{ $r->content }}</label>
                      </form>
                    </div>
                  @endforeach
                @else
                  <div class="check-item" style="justify-content:center;color:#9fb0b8">No hay rutinas aún.</div>
                @endif
              </div>

              <h3 style="margin-top:18px">Incidencias</h3>
              <div class="incidencias-list" style="margin-top:8px">
                @if(isset($incidencias) && count($incidencias))
                  @foreach($incidencias as $inc)
                    <div class="check-item" style="display:flex;justify-content:space-between;align-items:flex-start">
                      <div style="flex:1;display:flex;flex-direction:column;gap:6px">
                        <div style="font-weight:700;color:#e6eef2">Incidencia #{{ $loop->iteration }}</div>
                        <div style="color:#cbd5dd">{{ $inc->content }}</div>
                        <div style="font-size:13px;color:#cbd5dd">Por: {{ optional($inc->user)->name }} {{ optional($inc->user)->lastname }}</div>
                        <div style="font-size:12px;color:#9fb0b8">{{ $inc->created_at ? $inc->created_at->format('Y-m-d H:i') : '' }}</div>
                      </div>

                      <div style="margin-left:12px;display:flex;flex-direction:column;gap:6px">
                        @if(Auth::check() && (Auth::id() === $inc->user_id || Auth::user()->role === 'admin'))
                          <button type="button" class="btn-edit" data-id="{{ $inc->id }}" style="background:transparent;color:var(--red-1);border:1px solid rgba(255,255,255,0.03);padding:6px 10px;border-radius:6px;cursor:pointer">Editar</button>

                          <form method="POST" action="{{ route('admin.incidencias.destroy', $inc) }}" onsubmit="return confirm('¿Eliminar incidencia?');" style="margin:0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:#3b3f44;color:#fff;border:0;padding:6px 10px;border-radius:6px;cursor:pointer">Eliminar</button>
                          </form>
                        @endif
                      </div>
                    </div>

                    @if(Auth::check() && (Auth::id() === $inc->user_id || Auth::user()->role === 'admin'))
                      <div id="inc-edit-{{ $inc->id }}" style="display:none;margin-top:8px">
                        <form id="inc-edit-form-{{ $inc->id }}" method="POST" action="{{ route('admin.incidencias.update', $inc) }}">
                          @csrf
                          @method('PATCH')
                          <textarea name="content" rows="3" style="width:100%;border-radius:8px;padding:8px;border:1px solid rgba(255,255,255,0.04);background:transparent;color:#e6eef2">{{ old('content', $inc->content) }}</textarea>
                          <div style="margin-top:8px;text-align:right;display:flex;gap:8px;justify-content:flex-end">
                            <button type="button" class="btn-cancel" data-id="{{ $inc->id }}" style="background:#3b3f44;color:#fff;padding:6px 10px;border-radius:6px;border:0;cursor:pointer">Cancelar</button>
                            <button type="button" class="btn-confirm" data-id="{{ $inc->id }}" style="background:var(--red-1);color:#fff;padding:6px 10px;border-radius:6px;border:0;cursor:pointer">Confirmar</button>
                          </div>
                        </form>
                      </div>
                    @endif
                  @endforeach
                @else
                  <div class="check-item" style="justify-content:center;color:#9fb0b8">No hay incidencias registradas.</div>
                @endif
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>

    <script>
      function toggleIncidencia(){
        var box = document.getElementById('incidenciaBox');
        if(!box) return;
        box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
      }
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
      function toggleEdit(id){
        var el = document.getElementById('inc-edit-' + id);
        if(!el) return;
        el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
      }
      function confirmIncidenciaSave(id){
        var form = document.getElementById('inc-edit-form-' + id);
        if(!form) return;
        if(confirm('¿Confirmar los cambios en la incidencia #' + id + '?')){
          form.submit();
        }
      }

      (function bindIncidenciaButtons(){
        var edits = document.querySelectorAll('.btn-edit');
        edits.forEach(function(b){
          b.addEventListener('click', function(){ toggleEdit(this.dataset.id); });
        });

        var cancels = document.querySelectorAll('.btn-cancel');
        cancels.forEach(function(b){
          b.addEventListener('click', function(){ toggleEdit(this.dataset.id); });
        });

        var confirms = document.querySelectorAll('.btn-confirm');
        confirms.forEach(function(b){
          b.addEventListener('click', function(){
            var id = this.dataset.id;
            var form = document.getElementById('inc-edit-form-' + id);
            if(!form) return;
            if(confirm('¿Confirmar los cambios en la incidencia #' + id + '?')){
              form.submit();
            }
          });
        });
      })();
    </script>
  </body>
</html>
