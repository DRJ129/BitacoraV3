@extends('layouts.app')
@section('title', 'Bitácora - Inicio ppp')


@section('content')


    <div class="min-h-screen flex items-center justify-center px-6 py-12 md:px-12">
        <div
            class="w-full max-w-[1100px] rounded-[14px] border border-[rgba(255,255,255,0.02)]
               bg-[linear-gradient(180deg,rgba(255,255,255,0.02),rgba(0,0,0,0.04))]
               shadow-[0_20px_50px_rgba(0,0,0,0.6)] p-7">
            <div
                class="flex min-h-80 flex-col items-start gap-8
                 rounded-xl border border-[--glass-border]
                 bg-[--card-bg] px-9 py-9
                 backdrop-blur-sm
                 md:flex-row md:items-center md:justify-between md:px-11 md:py-14">

                <!-- Left -->
                <div class="flex flex-1 flex-col justify-center md:pr-7">
                    <h1 class="mb-2 text-[36px] font-extrabold tracking-[0.06em] text-[--red-1]">
                        Bitácora
                    </h1>
                    <p class="text-base text-slate-300">
                        Departamento de redes y servidores
                    </p>
                </div>

                <!-- Right -->
                <div
                    class="flex w-full flex-col items-start justify-center gap-3.5
                   md:w-auto md:items-end">
                    <div class="flex flex-row gap-3 md:flex-col">
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}"
                                class="inline-flex min-w-[120px] md:min-w-[140px]
                         items-center justify-center rounded-lg
                         border border-[rgba(255,255,255,0.04)]
                         bg-[linear-gradient(90deg,var(--muted),#434e56)]
                         px-4 py-2.5 text-center font-bold text-white
                         shadow-[0_6px_18px_rgba(0,0,0,0.4)]">
                                Iniciar sesión
                            </a>
                        @else
                            <a href="#"
                                class="inline-flex min-w-[120px] md:min-w-[140px]
                         items-center justify-center rounded-lg
                         border border-[rgba(255,255,255,0.04)]
                         bg-[linear-gradient(90deg,var(--muted),#434e56)]
                         px-4 py-2.5 text-center font-bold text-white
                         shadow-[0_6px_18px_rgba(0,0,0,0.4)]">
                                Iniciar sesión
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-flex min-w-[120px] md:min-w-[140px]
                         items-center justify-center rounded-lg
                         border border-[rgba(0,0,0,0.25)]
                         bg-[linear-gradient(90deg,var(--red-1),var(--red-2))]
                         px-4 py-2.5 text-center font-bold text-white
                         shadow-[0_8px_24px_rgba(200,0,0,0.12)]">
                                Registrarse
                            </a>
                        @else
                            <a href="#"
                                class="inline-flex min-w-[120px] md:min-w-[140px]
                         items-center justify-center rounded-lg
                         border border-[rgba(0,0,0,0.25)]
                         bg-[linear-gradient(90deg,var(--red-1),var(--red-2))]
                         px-4 py-2.5 text-center font-bold text-white
                         shadow-[0_8px_24px_rgba(200,0,0,0.12)]">
                                Registrarse
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
