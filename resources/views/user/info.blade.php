<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Información de usuario - Bitácora</title>
    <style>
      :root{--dark-1:#222B31;--card-bg:rgba(34,43,49,0.95);--red-1:#E22227}
      html,body{height:100%;margin:0;font-family:Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:linear-gradient(180deg,var(--dark-1) 0%, #16181a 60%);color:#e6eef2}
      .wrap{min-height:100%;display:flex;align-items:center;justify-content:center;padding:28px}
      .card{width:100%;max-width:900px;background:var(--card-bg);padding:22px;border-radius:12px;border:1px solid rgba(255,255,255,0.03)}
      h1{color:var(--red-1);margin:0 0 12px}
      .info{color:#cbd5dd}
    </style>
  </head>
  <body>
    <div class="wrap">
      <div class="card">
        <h1>Información</h1>
        <div class="info">
          @auth
            <p><strong>Nombre:</strong> {{ Auth::user()->name }} {{ Auth::user()->lastname ?? '' }}</p>
            <p><strong>Correo:</strong> {{ Auth::user()->email }}</p>
            <p><small>Miembro desde: {{ Auth::user()->created_at }}</small></p>
          @else
            <p>No hay usuario autenticado.</p>
          @endauth
        </div>
      </div>
    </div>
  </body>
</html>
