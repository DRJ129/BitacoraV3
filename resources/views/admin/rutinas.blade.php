@extends('layouts.app')
@section('title', 'Bitácora - Rutinas')



@section('content')
    <div class="">
        <h2 class="text-sm text-center font-bold tracking-tight text-heading md:text-sm lg:text-2xl">
            Rutinas</h2>
    </div>




    <div class="flex justify-between items-center p-2 mt-4">
        <div class="w-[10%]">
            <button id="showAdd"
                class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                <svg
                    class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14m-7 7V5" />
                </svg>
            </button>
        </div>

        <!-- add box -->
        <form id="addBox" class="w-[90%]" method="POST" action="{{ route('admin.rutinas.store') }}"
            style="display:none;">
            @csrf
            <div class="flex gap-2 items-center w-full">
                <input name="content" placeholder="Escribe la rutina aquí"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-3.5 py-3 shadow-xs placeholder:text-body"
                    required />
                <button
                    class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none"
                    type="submit">Guardar</button>
                <button onclick="toggleAdd();return false;"
                    class="text-white bg-danger box-border border border-transparent hover:bg-danger-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none"
                    style="margin-left:6px">Cancelar</button>
            </div>
        </form>
    </div>

    <div class="flex flex-col gap-2">
        @if (isset($routines) && count($routines))
            @foreach ($routines as $r)
                <div class="flex items-center">
                    <div class="flex flex-1 border rounded-xl bg-slate-300 dark:bg-slate-600">
                        <p class="text-body p-2">{{ $r->content }}</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <form method="POST" action="{{ route('admin.rutinas.update', $r) }}"
                            style="display:flex;gap:8px;align-items:center">
                            @csrf
                            @method('PATCH')
                            <input name="content" value="{{ $r->content }}" style="display:none"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-3.5 py-3 shadow-xs placeholder:text-body" />
                            <button title="Editar" type="button" class="action-btn"
                                onclick="openEdit(this);return false;"><svg class="w-6 h-6 text-gray-800 dark:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </button>
                            <button title="Guardar" type="submit" class="action-btn"><svg
                                    class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                        d="M4 5a1 1 0 0 1 1-1h11.586a1 1 0 0 1 .707.293l2.414 2.414a1 1 0 0 1 .293.707V19a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5Z" />
                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                        d="M8 4h8v4H8V4Zm7 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.rutinas.destroy', $r) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="action-btn delete" onclick="return confirm('Eliminar rutina?')"><svg
                                    class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="list-item" style="justify-content:center;color:#9fb0b8">No hay rutinas todavía.
                Usa "Agregar" para crear una.</div>
        @endif
    </div>
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
