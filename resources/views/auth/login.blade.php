<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión - Bitácora</title>
    <style>
      :root{
        --red-1:#E22227;
        --red-2:#C7080C;
        --dark-1:#222B31;
        --muted:#55666E;
        --card-bg:rgba(34,43,49,0.9);
        --input-bg:rgba(255,255,255,0.03);
        --glass-border:rgba(255,255,255,0.04);
      }
        html,body{height:100%;margin:0;font-family:Segoe UI, Roboto, Helvetica, Arial, sans-serif;background:linear-gradient(180deg,var(--dark-1) 0%, #16181a 60%);color:#e6eef2}

        .wrap{min-height:100%;display:flex;align-items:center;justify-content:center;padding:36px}
        .outer{width:100%;max-width:1100px;border-radius:14px;padding:20px;background:transparent}
        .inner{background:var(--card-bg);border-radius:12px;padding:48px 56px;display:flex;justify-content:center;align-items:center;min-height:420px;border:1px solid var(--glass-border);box-shadow:0 20px 50px rgba(0,0,0,0.6)}

      .form-wrap{width:100%;max-width:520px}
      h2{margin:0 0 22px;font-size:20px;text-align:center;color:#fff;font-weight:700}

      .field{display:flex;flex-direction:column;margin-bottom:14px}
      label{font-size:14px;color:#cbd5dd;margin-bottom:6px}
      input[type="email"], input[type="password"]{width:100%;padding:12px 14px;border-radius:8px;border:1px solid rgba(0,0,0,0.3);background:var(--input-bg);color:#fff;outline:none}
      input[type="email"]::placeholder, input[type="password"]::placeholder{color:rgba(255,255,255,0.4)}

  .actions{display:flex;justify-content:center;align-items:center;flex-direction:column;gap:12px;margin-top:18px}
  button[type="submit"]{background:linear-gradient(90deg,var(--red-1),var(--red-2));color:#fff;padding:10px 22px;border-radius:8px;border:0;font-weight:800;cursor:pointer;box-shadow:0 10px 30px rgba(226,34,39,0.12)}

  .helpers{display:flex;justify-content:space-between;align-items:center;width:100%;margin-top:8px}
  .helpers a{color:#cbd5dd;text-decoration:none;font-size:14px}

  /* Enlaces centrados debajo del botón, estilo según maqueta */
  .below-links{display:flex;flex-direction:column;align-items:center;gap:6px;margin-top:8px}
  .below-links a{color:#cbd5dd;text-decoration:none;font-size:15px}
  .below-links a.register-link{color:var(--red-1);font-weight:700}

      .error{background:rgba(200,20,20,0.06);border:1px solid rgba(200,20,20,0.18);color:#ffdddd;padding:10px;border-radius:6px;margin-bottom:12px}

      @media(max-width:640px){.inner{padding:28px}.form-wrap{max-width:100%}}
    </style>
  </head>
  <body>
    <div class="wrap">
      <div class="outer">
        <div class="inner">
          <div class="form-wrap">
            <h2>Iniciar sesión</h2>

            @if ($errors->any())
              <div class="error">
                <ul style="margin:0;padding-left:18px">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="field">
                <label for="email">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="tucorreo@ejemplo.com" required autofocus>
              </div>

              <div class="field">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" placeholder="********" required>
              </div>

              <div class="helpers">
                <div style="display:flex;align-items:center;gap:8px">
                  <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label for="remember" style="color:#cbd5dd;font-size:14px">Recordarme</label>
                </div>
                <div>
                  @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">¿Olvidó su contraseña?</a>
                  @endif
                </div>
              </div>

              <div class="actions">
                <button type="submit">Iniciar sesión</button>
                <!-- Enlaces centrados debajo del botón -->
                <div class="below-links">
                  @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">¿Olvidó su contraseña?</a>
                  @endif

                  @if (Route::has('register'))
                    <a class="register-link" href="{{ route('register') }}">Registrarse</a>
                  @endif
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
