@extends('layouts.app')
@section('title', 'Bitácora - Rutinas')

@section('content')

    <main class="main">
        <div class="topbar">
            <div class="title-pill">Rutinas</div>
        </div>

        <div class="content">
            <div class="controls">
                <button id="showAdd" class="btn-add">Agregar</button>
            </div>

            <!-- add box -->
            <form id="addBox" method="POST" action="{{ route('admin.rutinas.store') }}"
                style="display:none;margin-bottom:12px">
                @csrf
                <div style="display:flex;gap:10px;align-items:center">
                    <input name="content" placeholder="Escribe la rutina aquí"
                        style="flex:1;padding:10px;border-radius:8px;border:1px solid rgba(0,0,0,0.3);background:rgba(255,255,255,0.02);color:#fff"
                        required />
                    <button class="btn-add" type="submit">Guardar</button>
                    <button onclick="toggleAdd();return false;" class="action-btn" style="margin-left:6px">Cancelar</button>
                </div>
            </form>

            <div class="list">
                @if (isset($routines) && count($routines))
                    @foreach ($routines as $r)
                        <div class="list-item">
                            <div style="flex:1">{{ $r->content }}</div>
                            <div style="display:flex;gap:8px;align-items:center">
                                <form method="POST" action="{{ route('admin.rutinas.update', $r) }}"
                                    style="display:flex;gap:8px;align-items:center">
                                    @csrf
                                    @method('PATCH')
                                    <input name="content" value="{{ $r->content }}"
                                        style="display:none;padding:8px;border-radius:6px;background:rgba(255,255,255,0.03);color:#fff;border:1px solid rgba(0,0,0,0.2)" />
                                    <button type="button" class="action-btn"
                                        onclick="openEdit(this);return false;">Editar</button>
                                    <button type="submit" class="action-btn">Guardar</button>
                                </form>

                                <form method="POST" action="{{ route('admin.rutinas.destroy', $r) }}"
                                    style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-btn delete"
                                        onclick="return confirm('Eliminar rutina?')">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="list-item" style="justify-content:center;color:#9fb0b8">No hay rutinas todavía.
                        Usa "Agregar" para crear una.</div>
                @endif
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script>
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

        function toggleAdd() {
            var b = document.getElementById('addBox');
            b.style.display = (b.style.display === 'none' || b.style.display === '') ? 'flex' : 'none';
        }
        document.getElementById('showAdd').addEventListener('click', function(e) {
            toggleAdd();
        });

        function openEdit(btn) {
            var form = btn.closest('form');
            if (!form) return;
            var input = form.querySelector('input[name="content"]');
            if (!input) return;
            if (input.style.display === 'none' || input.style.display === '') {
                input.style.display = 'inline-block';
                input.style.width = '320px';
                input.focus();
            } else {
                input.style.display = 'none';
            }
        }
    </script>
@endpush
