<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitácora - Inicio</title>
    <style>
      /* Paleta proporcionada:
        #E22227, #C7080C, #6C0102, #440101, #222B31, #55666E
      */
      :root{
        --red-1:#E22227; /* más brillante */
        --red-2:#C7080C;
        --red-3:#6C0102;
        --red-4:#440101; /* más oscuro */
        --dark-1:#222B31; /* fondo oscuro */
        --muted:#55666E; /* gris azulado */
        --card-bg:rgba(34,43,49,0.85);
        --glass-border:rgba(255,255,255,0.06);
      }

      html,body{height:100%;margin:0;font-family:Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:linear-gradient(180deg,var(--dark-1) 0%, #16181a 60%), radial-gradient(circle at 10% 30%, rgba(226,34,39,0.12), transparent 25%), radial-gradient(circle at 90% 70%, rgba(85,102,110,0.06), transparent 20%);background-blend-mode:overlay;background-color:var(--dark-1);color:var(--muted)}

      .wrap{min-height:100%;display:flex;align-items:center;justify-content:center;padding:48px}

      .outer{
        width:100%;max-width:1100px;border-radius:14px;padding:28px;background:linear-gradient(180deg,rgba(255,255,255,0.02),rgba(0,0,0,0.04));box-shadow:0 20px 50px rgba(0,0,0,0.6);border:1px solid rgba(255,255,255,0.02);
      }

      .inner{
        background:var(--card-bg);border-radius:12px;padding:56px 44px;display:flex;justify-content:space-between;align-items:center;min-height:320px;border:1px solid var(--glass-border);backdrop-filter: blur(6px);
      }

  /* Centrado vertical de los bloques */
  .left{flex:1;padding-right:28px;display:flex;flex-direction:column;justify-content:center}
  .title{font-size:36px;font-weight:800;margin:0 0 8px;color:var(--red-1);letter-spacing:0.6px}
  .subtitle{font-size:16px;color:#d1d5db;margin:0}

  /* Botones alineados al centro verticalmente y a la derecha visualmente */
  .right{display:flex;flex-direction:column;justify-content:center;align-items:flex-end;gap:14px}

      .links{display:flex;flex-direction:column;gap:12px}
      .links a{display:inline-block;text-decoration:none;font-weight:700;padding:10px 18px;border-radius:8px;min-width:140px;text-align:center}
      .links a.login{background:linear-gradient(90deg,var(--muted),#434e56);color:#fff;border:1px solid rgba(255,255,255,0.04);box-shadow:0 6px 18px rgba(0,0,0,0.4)}
      .links a.register{background:linear-gradient(90deg,var(--red-1),var(--red-2));color:#fff;border:1px solid rgba(0,0,0,0.25);box-shadow:0 8px 24px rgba(200,0,0,0.12)}

      /* Tarjetas de color (opcional, estilo de la paleta en el centro) */
      /* La paleta es solo de referencia; ocultada para replicar la maqueta limpia */
      .palette{display:none}
     
      @media(max-width:820px){
        .inner{flex-direction:column;align-items:flex-start;padding:36px}
        .right{width:100%;align-items:flex-start}
        .links{flex-direction:row}
        .links a{min-width:120px}
        .left{padding-right:0}
      }
    </style>
  </head>
  <body>
    <div class="wrap">
      <div class="outer">
        <div class="inner">
          <div class="left">
            <h1 class="title">Bitácora</h1>
            <p class="subtitle">Departamento de redes y servidores</p>
          </div>

          <div class="right">
            <div class="links">
              @if (Route::has('login'))
                <a href="{{ route('login') }}" class="login">Iniciar sesión</a>
              @else
                <a href="#" class="login">Iniciar sesión</a>
              @endif
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="register">Registrarse</a>
              @else
                <a href="#" class="register">Registrarse</a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
