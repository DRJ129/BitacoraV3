@extends('layouts.app')
@section('title', 'Bitácora - Agregar usuario')

@section('content')
    <main class="main">
        <div class="topbar">
            <div class="title-pill">Usuarios</div>
        </div>

        <div class="content">
            <div class="card">
                <h2 style="margin-top:0">Agregar usuario</h2>
                <form method="POST" action="{{ route('admin.usuarios.store') }}">
                    @csrf
                    <label>Nombre</label>
                    <input name="name" placeholder="Nombre">
                    <label>Apellido</label>
                    <input name="lastname" placeholder="Apellido">
                    <label>Correo</label>
                    <input name="email" placeholder="correo@ejemplo.com">
                    <label>Rol</label>
                    <select name="role">
                        <option value="">-- seleccionar --</option>
                        <option value="admin">admin</option>
                        <option value="user">user</option>
                    </select>
                    <label>Contraseña</label>
                    <input name="password" type="password" placeholder="********">
                    <label>Confirmar contraseña</label>
                    <input name="password_confirmation" type="password" placeholder="********">
                    <div style="margin-top:12px;text-align:right">
                        <button class="btn" type="submit">Crear</button>
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
