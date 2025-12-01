<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitácora - Información</title>
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

      .info-card{max-width:760px;margin:0 auto;background:rgba(0,0,0,0.12);border-radius:10px;padding:18px;border:1px solid rgba(255,255,255,0.02)}
      .info-row{display:flex;gap:12px;align-items:center;margin-bottom:10px}
      .info-row label{min-width:120px;color:#9fb0b8}
      .info-row .value{color:#e6eef2;font-weight:700}

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
              <div class="title-pill">Información</div>
            </div>

            <div class="content">
              <div class="info-card">
                @auth
                  <div style="display:flex;justify-content:flex-end;margin-bottom:12px">
                    <button id="editProfileBtn" onclick="toggleProfileEdit();return false;" style="background:var(--red-1);color:#fff;padding:6px 10px;border-radius:6px;border:0;cursor:pointer">Editar</button>
                  </div>

                  <div id="profileView">
                    <div class="info-row">
                      <label>Nombre:</label>
                      <div class="value">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="info-row">
                      <label>Apellido:</label>
                      <div class="value">{{ Auth::user()->lastname ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                      <label>Correo:</label>
                      <div class="value">{{ Auth::user()->email }}</div>
                    </div>
                  </div>

                  <div id="profileEdit" style="display:none">
                    <form method="POST" action="{{ route('user.info.update') }}">
                      @csrf
                      @method('PATCH')
                      <div class="info-row">
                        <label for="name">Nombre:</label>
                        <input id="name" name="name" class="value" style="background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;color:#e6eef2" value="{{ old('name', Auth::user()->name) }}" required />
                      </div>
                      <div class="info-row">
                        <label for="lastname">Apellido:</label>
                        <input id="lastname" name="lastname" class="value" style="background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;color:#e6eef2" value="{{ old('lastname', Auth::user()->lastname) }}" />
                      </div>
                      <div class="info-row">
                        <label>Correo:</label>
                        <input disabled class="value" style="background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;color:#9fb0b8" value="{{ Auth::user()->email }}" />
                      </div>
                      <div class="info-row">
                        <label for="password">Nueva contraseña:</label>
                        <input id="password" name="password" type="password" class="value" style="background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;color:#e6eef2" />
                      </div>
                      <div class="info-row">
                        <label for="password_confirmation">Confirmar contraseña:</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="value" style="background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;color:#e6eef2" />
                      </div>

                      <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px">
                        <button type="button" onclick="toggleProfileEdit();return false;" style="background:#3b3f44;color:#fff;padding:6px 10px;border-radius:6px;border:0;cursor:pointer">Cancelar</button>
                        <button type="submit" style="background:var(--red-1);color:#fff;padding:6px 10px;border-radius:6px;border:0;cursor:pointer">Guardar</button>
                      </div>
                    </form>
                  </div>
                @else
                  <p>No hay usuario autenticado.</p>
                @endauth
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
      function toggleProfileEdit(){
        var view = document.getElementById('profileView');
        var edit = document.getElementById('profileEdit');
        if(!view || !edit) return;
        var showing = edit.style.display !== 'none' && edit.style.display !== '';
        if(showing){
          edit.style.display = 'none';
          view.style.display = 'block';
        } else {
          edit.style.display = 'block';
          view.style.display = 'none';
        }
      }
    </script>
  </body>
</html>
