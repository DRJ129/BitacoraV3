@extends('layouts.app')
@section('title', 'Bitácora - Editar usuario')

@section('content')
    <main class="main">
        <div class="">
            <h2 class="text-sm text-center font-bold tracking-tight text-heading md:text-sm lg:text-2xl">
                Editar Usuarios</h2>
        </div>

        <div class="content">
            <div class="card">
                <h2 style="margin-top:0">Editar usuario</h2>
                <form method="POST" action="{{ route('admin.usuarios.update', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <label>Nombre</label>
                    <input name="name" value="{{ $user->name }}" placeholder="Nombre">
                    <label>Apellido</label>
                    <input name="lastname" value="{{ $user->lastname }}" placeholder="Apellido">
                    <label>Correo</label>
                    <input name="email" value="{{ $user->email }}" placeholder="correo@ejemplo.com">
                    <label>Rol</label>
                    <select name="role">
                        <option value="">-- seleccionar --</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>admin</option>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>user</option>
                    </select>
                    <label>Contraseña (opcional)</label>
                    <input name="password" type="password" placeholder="Dejar vacío para no cambiar" />
                    <label>Confirmar contraseña</label>
                    <input name="password_confirmation" type="password" placeholder="Confirmar contraseña" />
                    <div style="margin-top:12px;text-align:right">
                        <button class="btn" type="submit">Guardar</button>
                    </div>
                </form>
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
    </script>
@endpush
