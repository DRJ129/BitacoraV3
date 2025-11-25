<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar rutina - Bitácora</title>
    <style>
      :root{--red-1:#E22227;--red-2:#C7080C;--dark-1:#222B31;--card-bg:rgba(34,43,49,0.95);--muted:#55666E}
      html,body{height:100%;margin:0;font-family:Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:linear-gradient(180deg,var(--dark-1) 0%, #16181a 60%);color:#e6eef2}
      .wrap{min-height:100%;display:flex;align-items:center;justify-content:center;padding:28px}
      .card{width:100%;max-width:900px;background:var(--card-bg);padding:22px;border-radius:12px;border:1px solid rgba(255,255,255,0.03)}
      h2{color:var(--red-1);text-align:center;margin:0 0 18px}
      label{color:#cbd5dd;display:block;margin-bottom:6px}
      input, textarea, select{width:100%;padding:10px;border-radius:8px;border:1px solid rgba(0,0,0,0.3);background:rgba(255,255,255,0.02);color:#fff;margin-bottom:12px}
      .grid{display:grid;grid-template-columns:1fr 1fr;gap:36px}
      .btn{background:linear-gradient(90deg,var(--red-1),var(--red-2));padding:10px 14px;border-radius:8px;border:0;color:#fff;font-weight:800;cursor:pointer}
      .muted{color:#9fb0b8}
      @media(max-width:860px){.grid{grid-template-columns:1fr}}
    </style>
  </head>
  <body>
    <div class="wrap">
      <div class="card">
        <h2>Editar rutina</h2>

        @if($errors->any())
          <div style="color:#ffdddd;margin-bottom:12px">
            <ul style="margin:0;padding-left:18px">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if(isset($routine))
          <form method="POST" action="{{ route('admin.rutinas.update', $routine) }}">
            @csrf
            @method('PATCH')

            <div class="grid">
              <div>
                <label for="title">Título</label>
                <input id="title" name="title" value="{{ old('title', $routine->title ?? '') }}" required />

                <label for="description">Descripción</label>
                <textarea id="description" name="description" rows="6">{{ old('description', $routine->description ?? '') }}</textarea>
              </div>

              <div>
                <label for="schedule">Horario / Programación</label>
                <input id="schedule" name="schedule" value="{{ old('schedule', $routine->schedule ?? '') }}" placeholder="Ej: Lunes 08:00, diario, semanal" />

                <label for="frequency">Frecuencia</label>
                <select id="frequency" name="frequency">
                  <option value="">-- seleccionar --</option>
                  <option value="diario" {{ (old('frequency',$routine->frequency ?? '')=='diario') ? 'selected' : '' }}>Diario</option>
                  <option value="semanal" {{ (old('frequency',$routine->frequency ?? '')=='semanal') ? 'selected' : '' }}>Semanal</option>
                  <option value="mensual" {{ (old('frequency',$routine->frequency ?? '')=='mensual') ? 'selected' : '' }}>Mensual</option>
                </select>

                <label for="owner">Responsable</label>
                <input id="owner" name="owner" value="{{ old('owner', $routine->owner ?? '') }}" placeholder="Nombre del responsable" />
              </div>
            </div>

            <div style="text-align:center;margin-top:18px">
              <button type="submit" class="btn">Confirmar</button>
            </div>
          </form>
        @else
          <p>No se encontró la rutina.</p>
        @endif

      </div>
    </div>
  </body>
</html>
