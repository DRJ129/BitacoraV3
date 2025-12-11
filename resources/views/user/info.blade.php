@extends('layouts.app')
@section('title', 'Información de Usuario')


@section('content')

    <div class="">
        <h2 class="text-sm text-center font-bold tracking-tight text-heading md:text-sm lg:text-2xl">
            Perfil del Usuarios</h2>
    </div>

    <div
        class="text-black dark:text-white mt-4 bg-neutral-primary-soft block md:min-w-lg p-6 border border-default rounded-base shadow-xs">
        @auth
            <div class="text-right">
                <button title="Editar usuario" class="p-2 cursor-pointer" id="editProfileBtn"
                    onclick="toggleProfileEdit();return false;"><svg class="w-6 h-6 text-gray-800 dark:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2"
                            d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.441 1.559a1.907 1.907 0 0 1 0 2.698l-6.069 6.069L10 19l.674-3.372 6.07-6.07a1.907 1.907 0 0 1 2.697 0Z" />
                    </svg>
                </button>
            </div>

            <div id="profileView">
                <div class="flex gap-2 items-center p-2">
                    <label class="font-bold">Nombre:</label>
                    <div class="">{{ Auth::user()->name }}</div>
                </div>
                <div class="flex gap-2 items-center p-2">
                    <label class="font-bold">Apellido:</label>
                    <div class="">{{ Auth::user()->lastname ?? '-' }}</div>
                </div>
                <div class="flex gap-2 items-center p-2">
                    <label class="font-bold">Correo:</label>
                    <div class="">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div id="profileEdit" style="display:none">
                <form method="POST" class="flex flex-col gap-4" action="{{ route('user.info.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-2">
                        <label for="name">Nombre:</label>
                        <input id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body"
                            required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="lastname">Apellido:</label>
                        <input id="lastname" name="lastname"
                            value="{{ old('lastname', Auth::user()->lastname) }}"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label>Correo:</label>
                        <input disabled value="{{ Auth::user()->email }}"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="password">Nueva contraseña:</label>
                        <input id="password" name="password" type="password"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="password_confirmation">Confirmar contraseña:</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" />
                    </div>

                    <div class="mt-4 text-right">
                        <button
                            class="mr-4 text-white bg-danger box-border border border-transparent hover:bg-danger-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none"
                            type="button" onclick="toggleProfileEdit();return false;">Cancelar</button>
                        <button type="submit"
                            class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Guardar</button>
                    </div>
                </form>
            </div>
        @else
            <p>No hay usuario autenticado.</p>
        @endauth
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

        function toggleProfileEdit() {
            var view = document.getElementById('profileView');
            var edit = document.getElementById('profileEdit');
            if (!view || !edit) return;
            var showing = edit.style.display !== 'none' && edit.style.display !== '';
            if (showing) {
                edit.style.display = 'none';
                view.style.display = 'block';
            } else {
                edit.style.display = 'block';
                view.style.display = 'none';
            }
        }
    </script>
@endpush
