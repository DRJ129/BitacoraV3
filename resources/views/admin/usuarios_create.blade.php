@extends('layouts.app')
@section('title', 'Bitácora - Agregar usuario')

@section('content')
    <div class="">
        <h2 class="text-sm text-center font-bold tracking-tight text-heading md:text-sm lg:text-2xl">
            Agregar Usuarios</h2>
    </div>
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-fg-success-strong rounded-base bg-success-soft" role="alert">
            <span class="font-medium">{{ session('success') }}</span> 
        </div>
    @endif

    <form method="POST" action="{{ route('admin.usuarios.store') }}" class="min-w-2xl mx-auto space-y-4 mt-6">
        @csrf
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="w-[50%]">
                <label for="name" name="name" class="block mb-2.5 text-sm font-medium text-heading">Nombre</label>
                <input type="text" id="name"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body"
                    placeholder="Nombre" name="name" required />
            </div>
            <div class="w-[50%]">
                <label for="lastname" class="block mb-2.5 text-sm font-medium text-heading">Apellido</label>
                <input type="text" id="lastname" name="lastname"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                    placeholder="Apellido" required />
            </div>
        </div>
        <div>
            <label for="email" class="block mb-2.5 text-sm font-medium text-heading">Correo</label>
            <input type="text" id="email"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-3.5 py-3 shadow-xs placeholder:text-body"
                name="email" placeholder="correo@ejemplo.com" required />
        </div>
        <div>
            <label for="visitors" class="block mb-2.5 text-sm font-medium text-heading">Rol</label>
            <select name="role"
                class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                <option value="">-- seleccionar --</option>
                <option value="admin">admin</option>
                <option value="user">user</option>
            </select>
        </div>
        <div>
            <label for="password" class="block mb-2.5 text-sm font-medium text-heading">Contraseña</label>
            <input type="password" id="email"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-3.5 py-3 shadow-xs placeholder:text-body"
                name="password" placeholder="********" required />
        </div>
        <div>
            <label for="password_confirmation" class="block mb-2.5 text-sm font-medium text-heading">Confirmar
                contraseña</label>
            <input type="password" id="email"
                class="bg-neutral-secondary-medium border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-3.5 py-3 shadow-xs placeholder:text-body"
                name="password_confirmation" placeholder="********" required />
        </div>
        <div>
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
