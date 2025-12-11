@extends('layouts.app')
@section('title', 'Bitácora - Editar usuario')

@section('content')
        <div class="">
            <h2 class="text-sm text-center font-bold tracking-tight text-heading md:text-sm lg:text-2xl">
                Editar Usuarios</h2>
        </div>


        <form method="POST" action="{{ route('admin.usuarios.update', $user->id) }}" class="min-w-2xl mx-auto space-y-4 mt-6">
            @csrf
            @method('PATCH')
            <label for="name" class="block mb-2.5 text-sm font-medium text-heading">Nombre</label>
            <input name="name" id="name" value="{{ $user->name }}" placeholder="Nombre"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body">
            <label for="lastname" class="block mb-2.5 text-sm font-medium text-heading">Apellido</label>
            <input name="lastname" id="lastname" value="{{ $user->lastname }}" placeholder="Apellido"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body">
            <label for="email" class="block mb-2.5 text-sm font-medium text-heading">Correo</label>
            <input name="email" id="email" value="{{ $user->email }}" placeholder="correo@ejemplo.com"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body">
            <label for="role" class="block mb-2.5 text-sm font-medium text-heading">Rol</label>
            <select id="role"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body"
                name="role">
                <option value="">-- seleccionar --</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>admin</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>user</option>
            </select>
            <label for="password" class="block mb-2.5 text-sm font-medium text-heading">Contraseña (opcional)</label>
            <input id="password" name="password" type="password" placeholder="Dejar vacío para no cambiar"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />
            <label for="password_confirmation" class="block mb-2.5 text-sm font-medium text-heading">Confirmar
                contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                placeholder="Confirmar contraseña"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />
            <div class="mt-4 text-right">
                <button type="submit"
                    class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Guardar</button>
            </div>
        </form>

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
