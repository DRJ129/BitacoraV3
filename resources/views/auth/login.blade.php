@extends('layouts.app')
@section('title', 'Bitácora - Login')


@section('content')

@endsection
<!doctype html>
<html lang="es">


<div class="min-h-screen flex items-center justify-center px-6 py-12 md:px-12">

    <div class="bg-neutral-primary-soft block md:min-w-lg p-6 border border-default rounded-base shadow-xs">
        <h5 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">Inicio de sesión</h5>
        @if ($errors->any())
            <div class="error">
                <ul style="margin:0;padding-left:18px">
                    @foreach ($errors->all() as $error)
                        <li>
                            <div class="p-4 mb-4 text-sm text-fg-danger-strong rounded-base bg-danger-soft"
                                role="alert">
                                <span class="font-medium">{{ $error }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="mx-auto" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-5">
                <label for="email" class="block mb-2.5 text-sm font-medium text-heading">Correo</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="bg-neutral-secondary-medium border
                border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full
                px-3 py-2.5 shadow-xs placeholder:text-body"
                    placeholder="name@flowbite.com" required />
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2.5 text-sm font-medium text-heading">Contaseña</label>
                <input type="password" id="password" name="password"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                    placeholder="••••••••" required />
            </div>

            <div class="">
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="dark:text-white text-black">Recordarme</label>
                </div>
            </div>

            <div class="text-right">

                <button type="submit"
                    class="text-white cursor-pointer bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Entrar</button>
            </div>

            <div class="mt-4 flex items-center justify-between text-sm">
                <div>
                    @if (Route::has('password.request'))
                        <a class="text-gray-700 hover:underline" href="{{ route('password.request') }}">¿Olvidó su contraseña?</a>
                    @endif
                </div>

                <div>
                    @if (Route::has('register'))
                        <span class="text-gray-700">¿No tienes cuenta?</span>
                        <a class="text-blue-600 hover:text-blue-400 ml-2" href="{{ route('register') }}">Registrarse aquí</a>
                    @endif
                </div>
            </div>
        </form>
    </div>





</div>
