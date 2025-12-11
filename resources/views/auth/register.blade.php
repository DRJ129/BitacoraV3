@extends('layouts.app')


@section('title', 'Bitacora - Registro')

@section('content')

    <div class="min-h-screen flex items-center justify-center px-6 py-12 md:px-12">

        <div class="bg-neutral-primary-soft block md:min-w-lg p-6 border border-default rounded-base shadow-xs">
            <h5 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">Registro de usuario</h5>
            @if ($errors->any())
                <div class="error">
                    <ul style="margin:0;padding-left:18px">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="min-w-xs mx-auto space-y-4 mt-6">
                @csrf
                <div>
                    <label for="name" name="name" class="block mb-2.5 text-sm font-medium text-heading">Nombre</label>
                    <input type="text" id="name" value="{{ old('name') }}"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body"
                        placeholder="Nombre" name="name" required />
                </div>
                <div>
                    <label for="lastname" class="block mb-2.5 text-sm font-medium text-heading">Apellido</label>
                    <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body"
                        placeholder="Apellido" required />
                </div>
                <div>
                    <label for="email" class="block mb-2.5 text-sm font-medium text-heading">Correo</label>
                    <input type="text" id="email" value="{{ old('email') }}"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body"
                        name="email" placeholder="correo@ejemplo.com" required />
                </div>
                <div>
                    <label for="password" class="block mb-2.5 text-sm font-medium text-heading">Contraseña</label>
                    <input type="password" id="email"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body"
                        name="password" placeholder="********" required />
                </div>
                <div>
                    <label for="password_confirmation" class="block mb-2.5 text-sm font-medium text-heading">Confirmar
                        contraseña</label>
                    <input type="password" id="email"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body"
                        name="password_confirmation" placeholder="********" required />
                </div>
                <div class="submit-wrap">
                    <div class="below">
                        <span class="text-black dark:text-white mr-2">¿Ya tienes cuenta? <a
                                class="text-blue-600 hover:text-blue-300" href="{{ route('login') }}">Iniciar
                                sesión</a></span>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit"
                        class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Registrarse</button>
                </div>
            </form>

        </div>
    </div>
@endsection
