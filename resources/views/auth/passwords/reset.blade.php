@extends('layouts.app')
@section('title', 'Restablecer contraseña')

@section('content')

<div class="min-h-screen flex items-center justify-center px-6 py-12 md:px-12">
    <div class="bg-neutral-primary-soft block md:min-w-lg p-6 border border-default rounded-base shadow-xs">
        <h5 class="mb-3 text-2xl font-semibold tracking-tight text-heading leading-8">Restablecer contraseña</h5>

        @if ($errors->any())
            <div class="error">
                <ul style="margin:0;padding-left:18px">
                    @foreach ($errors->all() as $error)
                        <li>
                            <div class="p-4 mb-4 text-sm text-fg-danger-strong rounded-base bg-danger-soft" role="alert">
                                <span class="font-medium">{{ $error }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-5">
                <label for="email" class="block mb-2.5 text-sm font-medium text-heading">Correo</label>
                <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
            </div>

            <div class="mb-5">
                <label for="password" class="block mb-2.5 text-sm font-medium text-heading">Contraseña</label>
                <input type="password" id="password" name="password" required
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
            </div>

            <div class="mb-5">
                <label for="password_confirmation" class="block mb-2.5 text-sm font-medium text-heading">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" />
            </div>

            <div class="text-right">
                <button type="submit" class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5">Restablecer</button>
            </div>
        </form>
    </div>
</div>

@endsection
