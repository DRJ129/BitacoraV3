<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar usuario - Bitácora</title>
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
        <h2 style="text-align:center;margin-bottom:18px">Editar usuario</h2>

        @if($errors->any())
          <div style="color:#ffdddd;margin-bottom:12px">
            <ul style="margin:0;padding-left:18px">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if(isset($user))
          <form method="POST" action="{{ route('admin.usuarios.update', $user) }}">
            @csrf
            @method('PATCH')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:36px;align-items:start">
              <div>
                <label>Nombre</label>
                <input name="name" value="{{ old('name', $user->name) }}" required />

                <label>Apellido</label>
                <input name="lastname" value="{{ old('lastname', $user->lastname) }}" required />

                <label>Correo</label>
                <input name="email" type="email" value="{{ old('email', $user->email) }}" required />
              </div>

              <div>
                <label>Contraseña</label>
                <input name="password" type="password" placeholder="Dejar vacío para no cambiar" />

                <label>Confirmar contraseña</label>
                <input name="password_confirmation" type="password" placeholder="Confirmar contraseña" />

                <label>Rol</label>
                <select name="role" style="width:100%;padding:10px;border-radius:8px;border:1px solid rgba(0,0,0,0.3);background:rgba(255,255,255,0.02);color:#fff;margin-top:6px">
                  <option value="">-- seleccionar --</option>
                  <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>admin</option>
                  <option value="user" {{ (old('role', $user->role) == 'user') ? 'selected' : '' }}>user</option>
                </select>
              </div>
            </div>

            <div style="text-align:center;margin-top:22px">
              <button class="btn" type="submit">Confirmar</button>
            </div>
          </form>
        @else
          <p>No se encontró el usuario.</p>
        @endif
      </div>
    </div>
  </body>
</html>
