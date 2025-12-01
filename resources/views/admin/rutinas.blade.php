<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitácora - Rutinas</title>
    <style>
      :root{
        --red-1:#E22227;
        --red-2:#C7080C;
        --dark-1:#222B31;
        --muted:#55666E;
        --card-bg:rgba(34,43,49,0.95);
        --sidebar-bg:rgba(20,26,29,0.95);
        --glass-border:rgba(255,255,255,0.03);
      }

      html,body{height:100%;margin:0;font-family:Segoe UI, Roboto, Helvetica, Arial, sans-serif;background:linear-gradient(180deg,var(--dark-1) 0%, #16181a 60%);color:#e6eef2}

      .wrap{min-height:100%;display:flex;align-items:center;justify-content:center;padding:28px}
      .outer{width:100%;max-width:1300px;border-radius:14px;padding:18px;background:transparent}
      .inner{background:var(--card-bg);border-radius:12px;padding:18px;display:flex;min-height:620px;border:1px solid var(--glass-border);box-shadow:0 30px 70px rgba(0,0,0,0.6)}

      /* Sidebar */
      .sidebar{width:260px;background:var(--sidebar-bg);border-radius:8px;padding:22px;display:flex;flex-direction:column;gap:18px}
      .brand{font-weight:800;color:var(--red-1);font-size:22px}
      .dept{font-size:13px;color:#cbd5dd}
      .menu{display:flex;flex-direction:column;gap:8px;margin-top:10px}
      .menu a{color:#cbd5dd;text-decoration:none;padding:10px 12px;border-radius:8px;font-weight:600}
      .menu a:hover{background:rgba(255,255,255,0.02)}

      .user-bottom{margin-top:auto;font-size:14px;color:#cbd5dd}

      /* Main area */
      .main{flex:1;padding-left:28px;display:flex;flex-direction:column}
      .topbar{display:flex;justify-content:center;align-items:center;padding:6px 0}
      .title-pill{background:rgba(255,255,255,0.03);padding:10px 40px;border-radius:8px;border:1px solid rgba(255,255,255,0.02);font-weight:700}

      .content{margin-top:18px;flex:1;border-radius:8px;padding:18px;background:linear-gradient(180deg,rgba(255,255,255,0.01), rgba(0,0,0,0.03));}

      .controls{display:flex;justify-content:flex-end;margin-bottom:8px}
      .btn-add{background:linear-gradient(90deg,var(--red-1),var(--red-2));color:#fff;padding:8px 14px;border-radius:8px;border:0;font-weight:700;cursor:pointer}

      .list{margin-top:12px}
      .list-item{display:flex;align-items:center;justify-content:space-between;padding:12px;border-radius:8px;background:rgba(255,255,255,0.02);margin-bottom:8px;color:#d1d5db}
      .action-btn{background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px 10px;border-radius:6px;color:#cbd5dd;cursor:pointer}
      .action-btn.delete{color:var(--red-1);border-color:rgba(200,20,20,0.12)}

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
              <a href="#">Reportes</a>
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
              <div class="title-pill">Rutinas</div>
            </div>

            <div class="content">
              <div class="controls">
                <button id="showAdd" class="btn-add">Agregar</button>
              </div>

              <!-- add box -->
              <form id="addBox" method="POST" action="{{ route('admin.rutinas.store') }}" style="display:none;margin-bottom:12px">
                @csrf
                <div style="display:flex;gap:10px;align-items:center">
                  <input name="content" placeholder="Escribe la rutina aquí" style="flex:1;padding:10px;border-radius:8px;border:1px solid rgba(0,0,0,0.3);background:rgba(255,255,255,0.02);color:#fff" required />
                  <button class="btn-add" type="submit">Guardar</button>
                  <button onclick="toggleAdd();return false;" class="action-btn" style="margin-left:6px">Cancelar</button>
                </div>
              </form>

              <div class="list">
                @if(isset($routines) && count($routines))
                  @foreach($routines as $r)
                    <div class="list-item">
                      <div style="flex:1">{{ $r->content }}</div>
                      <div style="display:flex;gap:8px;align-items:center">
                        <form method="POST" action="{{ route('admin.rutinas.update', $r) }}" style="display:flex;gap:8px;align-items:center">
                          @csrf
                          @method('PATCH')
                          <input name="content" value="{{ $r->content }}" style="display:none;padding:8px;border-radius:6px;background:rgba(255,255,255,0.03);color:#fff;border:1px solid rgba(0,0,0,0.2)" />
                          <button type="button" class="action-btn" onclick="openEdit(this);return false;">Editar</button>
                          <button type="submit" class="action-btn">Guardar</button>
                        </form>

                        <form method="POST" action="{{ route('admin.rutinas.destroy', $r) }}" style="display:inline">
                          @csrf
                          @method('DELETE')
                          <button class="action-btn delete" onclick="return confirm('Eliminar rutina?')">Eliminar</button>
                        </form>
                      </div>
                    </div>
                  @endforeach
                @else
                  <div class="list-item" style="justify-content:center;color:#9fb0b8">No hay rutinas todavía. Usa "Agregar" para crear una.</div>
                @endif
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

      function toggleAdd(){
        var b = document.getElementById('addBox');
        b.style.display = (b.style.display === 'none' || b.style.display === '') ? 'flex' : 'none';
      }
      document.getElementById('showAdd').addEventListener('click', function(e){ toggleAdd(); });

      function openEdit(btn){
        var form = btn.closest('form');
        if(!form) return;
        var input = form.querySelector('input[name="content"]');
        if(!input) return;
        if(input.style.display === 'none' || input.style.display === ''){
          input.style.display = 'inline-block';
          input.style.width = '320px';
          input.focus();
        } else {
          input.style.display = 'none';
        }
      }
    </script>
  </body>
</html>
