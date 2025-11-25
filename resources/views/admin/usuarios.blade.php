<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios - Bitácora</title>
    <style>
      :root{--red-1:#E22227;--red-2:#C7080C;--dark-1:#222B31;--muted:#55666E;--card-bg:rgba(34,43,49,0.95);--sidebar-bg:rgba(20,26,29,0.95);}
      html,body{height:100%;margin:0;font-family:Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:linear-gradient(180deg,var(--dark-1) 0%, #16181a 60%);color:#e6eef2}
      .container{max-width:1100px;margin:28px auto;padding:18px}
      .panel{background:var(--card-bg);padding:20px;border-radius:12px;border:1px solid rgba(255,255,255,0.03)}
      .head{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
      .head h1{margin:0;color:var(--red-1)}
      .btn-add{background:linear-gradient(90deg,var(--red-1),var(--red-2));color:#fff;padding:8px 14px;border-radius:8px;border:0;font-weight:700;cursor:pointer}

      .fields{display:flex;gap:10px;align-items:center;margin-bottom:12px}
      .field{background:var(--sidebar-bg);padding:10px 12px;border-radius:8px;color:#cbd5dd}

      table{width:100%;border-collapse:collapse;margin-top:12px}
      th,td{padding:12px 10px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.02);color:#d1d5db}
      th{font-weight:700;color:#9fb0b8}
      .actions{display:flex;gap:8px}
      .action-btn{background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px 10px;border-radius:6px;color:#cbd5dd;cursor:pointer}
      .action-btn.delete{color:var(--red-1);border-color:rgba(200,20,20,0.12)}

      .form-row{display:flex;gap:10px;margin-top:12px}
      .form-row input, .form-row select{flex:1;padding:10px;border-radius:8px;border:1px solid rgba(0,0,0,0.3);background:rgba(255,255,255,0.03);color:#fff}

      .small-muted{font-size:13px;color:#9fb0b8}

      @media(max-width:860px){.form-row{flex-direction:column}}
    </style>
  </head>
  <body>
    <div class="container">
      <div class="panel">
        <div class="head">
          <h1>Usuarios</h1>
          <a href="{{ route('admin.usuarios.create') }}" class="btn-add">Agregar</a>
        </div>

        @if(session('success'))
          <div style="margin-bottom:10px;color:#bbffcc">{{ session('success') }}</div>
        @endif

        <table>
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Correo</th>
              <th>Rol</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $u)
              <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->lastname }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role ?? '-' }}</td>
                <td>
                  <div class="actions">
                    <a class="action-btn" href="{{ route('admin.usuarios.edit', $u) }}">Editar</a>
                    <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}" style="display:inline">
                      @csrf
                      @method('DELETE')
                      <button class="action-btn delete" onclick="return confirm('Eliminar usuario?')">Eliminar</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </body>
</html>
