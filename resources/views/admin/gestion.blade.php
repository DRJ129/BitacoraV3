@extends('layouts.app')

@section('title', 'Bitácora - Gestión')

@section('content')
    <div class="">
        <h2 class="text-sm text-center font-bold tracking-tight text-heading md:text-sm lg:text-2xl">
            Gestión</h2>
    </div>
    <div class="flex justify-end items-center">
        <div class="flex gap-2 rounded-xl bg-blue-500 text-white px-2">
            <div class="">{{ $dayName ?? '' }}</div>
            <div class="">{{ $today ?? '' }}</div>
        </div>
    </div>
    @if (session('success'))
        <div style="background:rgba(0,0,0,0.25);padding:10px;border-radius:8px;margin-bottom:12px;color:#cfeee9">
            {{ session('success') }}</div>
    @endif




    <fieldset class="grid grid-cols-1 md:grid-cols-2 gap-2 p-2 border border-slate-300 lg:mt-6">
        <legend class="text-black dark:text-white text-xl font-bold">Rutinas</legend>
        @if (isset($routines) && count($routines))
            @foreach ($routines as $r)
                <div class="rounded-xl bg-slate-300 dark:bg-slate-600 p-2 text-black dark:text-white">
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
    </fieldset>

    <div class="flex justify-between items-center px-6 mt-6">
        <div class="">
            <button type="button" onclick="toggleIncidencia()"
                class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Agregar
                incidencias</button>
        </div>
    </div>

    <div id="incidenciaBox" style="display:none" class="p-4">
        <form method="POST" action="{{ route('admin.incidencias.store') }}">
            @csrf
            <textarea name="content" rows="4"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-3.5 py-3 shadow-xs placeholder:text-body"
                placeholder="Describe la incidencia..."></textarea>
            <div style="margin-top:8px;text-align:right">
                <button type="submit"
                    class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Guardar
                    incidencia</button>
            </div>
        </form>
    </div>

    
    <fieldset class="p-2 flex flex-col gap-2 border border-slate-300 mt-4">
          <legend class="text-black dark:text-white text-xl font-bold">Incidencias</legend>
        @if (isset($incidencias) && count($incidencias))
            @foreach ($incidencias as $inc)
                <div class="flex justify-between gap-4 items-center bg-slate-300 rounded-sm p-2">
                    <div class="flex flex-col w-[80%]">
                        <div class="text-xs py-2">Incidencia
                            #{{ $loop->iteration }}</div>
                        <div class="border border-gray-400 p-1 rounded-sm">{{ $inc->content }}</div>
                        <div class="flex gap-2 text-xs">
                            <div class="p-1">Por:
                                {{ optional($inc->user)->name }} {{ optional($inc->user)->lastname }}
                            </div>
                            <div class="p-1">
                                {{ $inc->created_at ? $inc->created_at->format('Y-m-d H:i') : '' }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-2 w-[20%]">
                        @if (Auth::check() && (Auth::id() === $inc->user_id || Auth::user()->role === 'admin'))
                            <button type="button" class="btn-edit cursor-pointer" data-id="{{ $inc->id }}"><svg
                                    class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </button>

                            <form method="POST" action="{{ route('admin.incidencias.destroy', $inc) }}"
                                onsubmit="return confirm('¿Eliminar incidencia?');" style="margin:0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cursor-pointer"><svg
                                        class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
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
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-3.5 py-3 shadow-xs placeholder:text-body">{{ old('content', $inc->content) }}</textarea>
                            <div style="margin-top:8px;text-align:right;display:flex;gap:8px;justify-content:flex-end">
                                <button type="button" data-id="{{ $inc->id }}"
                                    class="btn-cancel text-white bg-danger box-border border border-transparent hover:bg-danger-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancelar</button>
                                <button type="button" data-id="{{ $inc->id }}"
                                    class="btn-confirm text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Confirmar</button>
                            </div>
                        </form>
                    </div>
                @endif
            @endforeach
        @else
            <div class="check-item" style="justify-content:center;color:#9fb0b8">No hay
                incidencias registradas.</div>
        @endif
    </fieldset>
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
