<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar usuario - Bitácora</title>
    <style>
      :root{--red-1:#E22227;--dark-1:#222B31;--card-bg:rgba(34,43,49,0.95)}
      html,body{height:100%;margin:0;font-family:Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:linear-gradient(180deg,var(--dark-1) 0%, #16181a 60%);color:#e6eef2}
      .wrap{min-height:100%;display:flex;align-items:center;justify-content:center;padding:28px}
      .card{width:100%;max-width:720px;background:var(--card-bg);padding:22px;border-radius:12px;border:1px solid rgba(255,255,255,0.03)}
      label{color:#cbd5dd}
      input{width:100%;padding:10px;border-radius:8px;border:1px solid rgba(0,0,0,0.3);background:rgba(255,255,255,0.02);color:#fff;margin-bottom:12px}
      .btn{background:linear-gradient(90deg,var(--red-1),#C7080C);padding:10px 14px;border-radius:8px;border:0;color:#fff;font-weight:800;cursor:pointer}
    </style>
  </head>
  <body>
    <div class="wrap">
      <div class="card">
        <h2>Agregar usuario</h2>
        <form method="POST" action="{{ route('admin.usuarios.store') }}">
          @csrf
          <label>Nombre</label>
          <input name="name" placeholder="Nombre">
          <label>Apellido</label>
          <input name="lastname" placeholder="Apellido">
          <label>Correo</label>
          <input name="email" placeholder="correo@ejemplo.com">
          <label>Rol</label>
          <select name="role" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(0,0,0,0.3);background:rgba(255,255,255,0.02);color:#fff;margin-bottom:12px">
            <option value="">-- seleccionar --</option>
            <option value="admin">admin</option>
            <option value="user">user</option>
          </select>
          <label>Contraseña</label>
          <input name="password" type="password" placeholder="********">
          <label>Confirmar contraseña</label>
          <input name="password_confirmation" type="password" placeholder="********">
          <div style="margin-top:12px">
            <button class="btn" type="submit">Crear</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
