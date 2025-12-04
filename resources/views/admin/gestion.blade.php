@extends('layouts.app')

@section('title', 'Bitácora - Gestión')

@section('content')
    <main class="main">
        <div class="topbar">
            <div class="title-pill">Gestión</div>
        </div>

        <div class="content">
            <div class="date-box">
                <div class="day">{{ $dayName ?? '' }}</div>
                <div class="date">{{ $today ?? '' }}</div>
            </div>

            <h3>Rutinas</h3>
            @if (session('success'))
                <div style="background:rgba(0,0,0,0.25);padding:10px;border-radius:8px;margin-bottom:12px;color:#cfeee9">
                    {{ session('success') }}</div>
            @endif

            <div style="margin-bottom:12px">
                <button type="button" onclick="toggleIncidencia()"
                    style="background:var(--red-1);color:#fff;padding:8px 12px;border-radius:8px;border:0;cursor:pointer;font-weight:700">Agregar
                    incidencias</button>
            </div>

            <div id="incidenciaBox" style="display:none;margin-bottom:16px">
                <form method="POST" action="{{ route('admin.incidencias.store') }}">
                    @csrf
                    <textarea name="content" rows="4"
                        style="width:100%;border-radius:8px;padding:8px;border:1px solid rgba(255,255,255,0.04);background:transparent;color:#e6eef2"
                        placeholder="Describe la incidencia..."></textarea>
                    <div style="margin-top:8px;text-align:right">
                        <button type="submit"
                            style="background:var(--red-1);color:#fff;padding:8px 12px;border-radius:8px;border:0;cursor:pointer;font-weight:700">Guardar
                            incidencia</button>
                    </div>
                </form>
            </div>
            <div class="checklist">
                @if (isset($routines) && count($routines))
                    @foreach ($routines as $r)
                        <div class="check-item">
                            <form method="POST" action="{{ route('admin.rutinas.update', $r) }}">
                                @csrf
                                @method('PATCH')
                                {{-- ensure unchecked checkboxes submit a 0 value --}}
                                <input type="hidden" name="completed" value="0" />
                                @php $isDone = isset($completedIds) && in_array($r->id, $completedIds); @endphp
                                <input type="checkbox" id="rut-{{ $r->id }}" name="completed" value="1"
                                    onchange="this.form.submit();" {{ $isDone ? 'checked' : '' }} />
                                <label for="rut-{{ $r->id }}"
                                    class="{{ $isDone ? 'completed' : '' }}">{{ $r->content }}</label>
                            </form>
                        </div>
                    @endforeach
                @else
                    <div class="check-item" style="justify-content:center;color:#9fb0b8">No hay rutinas aún.
                    </div>
                @endif
            </div>

            <h3 style="margin-top:18px">Incidencias</h3>
            <div class="incidencias-list" style="margin-top:8px">
                @if (isset($incidencias) && count($incidencias))
                    @foreach ($incidencias as $inc)
                        <div class="check-item" style="display:flex;justify-content:space-between;align-items:flex-start">
                            <div style="flex:1;display:flex;flex-direction:column;gap:6px">
                                <div style="font-weight:700;color:#e6eef2">Incidencia
                                    #{{ $loop->iteration }}</div>
                                <div style="color:#cbd5dd">{{ $inc->content }}</div>
                                <div style="font-size:13px;color:#cbd5dd">Por:
                                    {{ optional($inc->user)->name }} {{ optional($inc->user)->lastname }}
                                </div>
                                <div style="font-size:12px;color:#9fb0b8">
                                    {{ $inc->created_at ? $inc->created_at->format('Y-m-d H:i') : '' }}
                                </div>
                            </div>

                            <div style="margin-left:12px;display:flex;flex-direction:column;gap:6px">
                                @if (Auth::check() && (Auth::id() === $inc->user_id || Auth::user()->role === 'admin'))
                                    <button type="button" class="btn-edit" data-id="{{ $inc->id }}"
                                        style="background:transparent;color:var(--red-1);border:1px solid rgba(255,255,255,0.03);padding:6px 10px;border-radius:6px;cursor:pointer">Editar</button>

                                    <form method="POST" action="{{ route('admin.incidencias.destroy', $inc) }}"
                                        onsubmit="return confirm('¿Eliminar incidencia?');" style="margin:0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background:#3b3f44;color:#fff;border:0;padding:6px 10px;border-radius:6px;cursor:pointer">Eliminar</button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        @if (Auth::check() && (Auth::id() === $inc->user_id || Auth::user()->role === 'admin'))
                            <div id="inc-edit-{{ $inc->id }}" style="display:none;margin-top:8px">
                                <form id="inc-edit-form-{{ $inc->id }}" method="POST"
                                    action="{{ route('admin.incidencias.update', $inc) }}">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="content" rows="3"
                                        style="width:100%;border-radius:8px;padding:8px;border:1px solid rgba(255,255,255,0.04);background:transparent;color:#e6eef2">{{ old('content', $inc->content) }}</textarea>
                                    <div
                                        style="margin-top:8px;text-align:right;display:flex;gap:8px;justify-content:flex-end">
                                        <button type="button" class="btn-cancel" data-id="{{ $inc->id }}"
                                            style="background:#3b3f44;color:#fff;padding:6px 10px;border-radius:6px;border:0;cursor:pointer">Cancelar</button>
                                        <button type="button" class="btn-confirm" data-id="{{ $inc->id }}"
                                            style="background:var(--red-1);color:#fff;padding:6px 10px;border-radius:6px;border:0;cursor:pointer">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="check-item" style="justify-content:center;color:#9fb0b8">No hay
                        incidencias registradas.</div>
                @endif
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script>
        function toggleIncidencia() {
            var box = document.getElementById('incidenciaBox');
            if (!box) return;
            box.style.display = (box.style.display === 'none' || box.style.display === '') ? 'block' : 'none';
        }

        function toggleAdmin() {
            var sub = document.getElementById('adminSub');
            if (!sub) return;
            sub.style.display = (sub.style.display === 'none' || sub.style.display === '') ? 'block' : 'none';
        }

        function toggleUser() {
            var sub = document.getElementById('userSub');
            if (!sub) return;
            sub.style.display = (sub.style.display === 'none' || sub.style.display === '') ? 'block' : 'none';
        }

        function toggleEdit(id) {
            var el = document.getElementById('inc-edit-' + id);
            if (!el) return;
            el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
        }

        function confirmIncidenciaSave(id) {
            var form = document.getElementById('inc-edit-form-' + id);
            if (!form) return;
            if (confirm('¿Confirmar los cambios en la incidencia #' + id + '?')) {
                form.submit();
            }
        }

        /* attach event listeners to buttons rendered with data-id attributes */
        (function bindIncidenciaButtons() {
            var edits = document.querySelectorAll('.btn-edit');
            edits.forEach(function(b) {
                b.addEventListener('click', function() {
                    toggleEdit(this.dataset.id);
                });
            });

            var cancels = document.querySelectorAll('.btn-cancel');
            cancels.forEach(function(b) {
                b.addEventListener('click', function() {
                    toggleEdit(this.dataset.id);
                });
            });

            var confirms = document.querySelectorAll('.btn-confirm');
            confirms.forEach(function(b) {
                b.addEventListener('click', function() {
                    var id = this.dataset.id;
                    var form = document.getElementById('inc-edit-form-' + id);
                    if (!form) return;
                    if (confirm('¿Confirmar los cambios en la incidencia #' + id + '?')) {
                        form.submit();
                    }
                });
            });
        })();
    </script>
@endpush
