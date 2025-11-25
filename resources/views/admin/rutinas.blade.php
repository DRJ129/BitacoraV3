<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rutinas - Bitácora</title>
    <style>
      :root{--dark-1:#222B31;--card-bg:rgba(34,43,49,0.95);--muted:#55666E;--red-1:#E22227}
      html,body{height:100%;margin:0;font-family:Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:linear-gradient(180deg,var(--dark-1) 0%, #16181a 60%);color:#e6eef2}
      .wrap{min-height:100%;display:flex;align-items:center;justify-content:center;padding:28px}
      .card{width:100%;max-width:1100px;background:var(--card-bg);padding:22px;border-radius:12px;border:1px solid rgba(255,255,255,0.03)}
      h1{color:var(--red-1);margin:0 0 12px}
      p{color:#cbd5dd}
      a{color:var(--red-1);text-decoration:none}
    </style>
  </head>
  <body>
    <div class="wrap">
      <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px">
          <h1 style="margin:0">Rutinas</h1>
          <div>
            <button id="showAdd" class="btn" style="padding:8px 12px;border-radius:18px">Agregar</button>
          </div>
        </div>

        @if(session('success'))
          <div style="color:#bbffcc;margin-bottom:10px">{{ session('success') }}</div>
        @endif

        <!-- small add box -->
        <form id="addBox" method="POST" action="{{ route('admin.rutinas.store') }}" style="display:none;margin-bottom:12px">
          @csrf
          <div style="display:flex;gap:10px;align-items:center">
            <input name="content" placeholder="Escribe la rutina aquí" style="flex:1;padding:10px;border-radius:8px;border:1px solid rgba(0,0,0,0.3);background:rgba(255,255,255,0.02);color:#fff" required />
            <button class="btn" type="submit">Guardar</button>
            <button onclick="toggleAdd();return false;" class="action-btn" style="margin-left:6px">Cancelar</button>
          </div>
        </form>

        <!-- Lista de rutinas -->
        <div>
          @if(isset($routines) && count($routines))
            <ul style="list-style:none;padding:0;margin:0">
              @foreach($routines as $r)
                <li style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;border-radius:8px;background:rgba(255,255,255,0.02);margin-bottom:8px">
                  <div style="flex:1;color:#d1d5db">{{ $r->content }}</div>
                  <div style="display:flex;gap:8px;align-items:center;margin-left:12px">
                    <!-- Edit inline form (hidden) -->
                    <form method="POST" action="{{ route('admin.rutinas.update', $r) }}" style="display:flex;gap:8px;align-items:center" onsubmit="return true;">
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
                </li>
              @endforeach
            </ul>
          @else
            <p class="small-muted">No hay rutinas todavía. Usa "Agregar" para crear una.</p>
          @endif
        </div>

        <p style="margin-top:14px">
          <a href="{{ \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : url('/') }}">Volver</a>
        </p>
      </div>
    </div>

    <script>
      function toggleAdd(){
        var b = document.getElementById('addBox');
        b.style.display = (b.style.display === 'none' || b.style.display === '') ? 'flex' : 'none';
      }
      document.getElementById('showAdd').addEventListener('click', function(e){ toggleAdd(); });

      function openEdit(btn){
        // find the parent form and toggle the input visibility
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
