<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitácora - Agregar usuario</title>
    <style>
      :root{
        --red-1:#E22227;
        --red-2:#C7080C;
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

      .card{width:100%;max-width:760px;background:rgba(0,0,0,0.12);padding:18px;border-radius:10px;border:1px solid rgba(255,255,255,0.02);margin:0 auto}
      label{color:#cbd5dd}
      input, select{width:100%;padding:10px;border-radius:8px;border:1px solid rgba(0,0,0,0.3);background:rgba(255,255,255,0.02);color:#fff;margin-bottom:12px}
      .btn{background:linear-gradient(90deg,var(--red-1),var(--red-2));padding:10px 14px;border-radius:8px;border:0;color:#fff;font-weight:800;cursor:pointer}

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
              <div class="title-pill">Usuarios</div>
            </div>

            <div class="content">
              <div class="card">
                <h2 style="margin-top:0">Agregar usuario</h2>
                <form method="POST" action="{{ route('admin.usuarios.store') }}">
                  @csrf
                  <label>Nombre</label>
                  <input name="name" placeholder="Nombre">
                  <label>Apellido</label>
                  <input name="lastname" placeholder="Apellido">
                  <label>Correo</label>
                  <input name="email" placeholder="correo@ejemplo.com">
                  <label>Rol</label>
                  <select name="role">
                    <option value="">-- seleccionar --</option>
                    <option value="admin">admin</option>
                    <option value="user">user</option>
                  </select>
                  <label>Contraseña</label>
                  <input name="password" type="password" placeholder="********">
                  <label>Confirmar contraseña</label>
                  <input name="password_confirmation" type="password" placeholder="********">
                  <div style="margin-top:12px;text-align:right">
                    <button class="btn" type="submit">Crear</button>
                  </div>
                </form>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>

    <script>
      function toggleAdmin(){var sub=document.getElementById('adminSub');if(!sub)return;sub.style.display=(sub.style.display==='none'||sub.style.display==='')?'block':'none';}
      function toggleUser(){var sub=document.getElementById('userSub');if(!sub)return;sub.style.display=(sub.style.display==='none'||sub.style.display==='')?'block':'none';}
    </script>
  </body>
</html>
