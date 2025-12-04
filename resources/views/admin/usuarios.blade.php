@extends('layouts.app')
@section('title', 'Bitácora - Usuarios')



@section('content')

    <main class="main">
        <div class="topbar">
            <div class="title-pill">Usuarios</div>
        </div>

        <div class="content">
            <div class="head">
                <h1>Usuarios</h1>
                <a href="{{ route('admin.usuarios.create') }}" class="btn-add">Agregar</a>
            </div>

            @if (session('success'))
                <div style="margin-bottom:10px;color:#bbffcc">{{ session('success') }}</div>
            @endif

            <table>
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
                                    <a class="action-btn" href="{{ route('admin.usuarios.edit', $u) }}">Editar</a>
                                    <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-btn delete"
                                            onclick="return confirm('Eliminar usuario?')">Eliminar</button>
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
    </script>
@endpush
