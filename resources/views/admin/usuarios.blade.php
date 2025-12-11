@extends('layouts.app')
@section('title', 'Bitácora - Usuarios')



@section('content')

    <main class="border w-full p-4">
        <div class="">
            <h2 class="text-sm text-center font-bold tracking-tight text-heading md:text-sm lg:text-2xl">
                Usuarios</h2>
        </div>

        <div class="content">
            <div class="head">
                <a href="{{ route('admin.usuarios.create') }}"
                    class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Agregar</a>
            </div>

            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-fg-success-strong rounded-base bg-success-soft" role="alert">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <table id="search-table">
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
                    @foreach ($users as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->lastname }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->role ?? '-' }}</td>
                            <td>
                                <div class="actions">
                                    <a class="action-btn" href="{{ route('admin.usuarios.edit', $u) }}"><svg
                                            class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-btn delete" onclick="return confirm('Eliminar usuario?')"><svg
                                                class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>


@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false,
                labels: {
                    placeholder: "Buscar...", // Texto del input de búsqueda
                    perPage: "registros por página", // Etiqueta del selector de cantidad
                    noRows: "No se encontraron registros",
                    info: "Mostrando {start} a {end} de {rows} registros",
                    noResults: "No hay resultados"
                }
            });
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
    </script>
@endpush
