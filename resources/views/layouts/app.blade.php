<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title')</title>
    @stack('css')
</head>

<body>
    <div class="wrap">
        <div class="outer">
            <div class="inner">
                <aside class="sidebar">
                    <div>
                        <div class="brand">Bitácora</div>
                        <div class="dept">Departamento de redes y servidores</div>
                    </div>

                    <nav class="menu" aria-label="Menú principal">
                        <div style="position:relative">
                            <button id="adminBtn" onclick="toggleAdmin()"
                                style="width:100%;text-align:left;padding:10px 12px;border-radius:8px;border:0;background:transparent;color:#cbd5dd;font-weight:700;cursor:pointer">Administrador
                                ▾</button>
                            <div id="adminSub" class="submenu" style="display:none;margin-top:6px;">
                                @if (Auth::check() && Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.usuarios') }}"
                                        style="display:block;padding:8px 12px;border-radius:6px;color:#cbd5dd;text-decoration:none">Usuarios</a>
                                @endif
                                <a href="{{ route('admin.rutinas') }}"
                                    style="display:block;padding:8px 12px;border-radius:6px;color:#cbd5dd;text-decoration:none">Rutinas</a>
                            </div>
                        </div>

                        <a href="{{ route('admin.gestion') }}">Gestión</a>
                        <a href="{{ route('admin.reportes') }}">Reportes</a>
                    </nav>

                    <div class="user-bottom" style="position:relative">
                        <button id="userBtn" onclick="toggleUser()"
                            style="background:transparent;border:0;color:#cbd5dd;font-weight:700;cursor:pointer">@auth
                                {{ Auth::user()->name }} {{ Auth::user()->lastname ?? '' }}
                            @else
                            Usuario @endauth ▴</button>
                        <div id="userSub" class="submenu" style="display:none;margin-top:6px;">
                            <a href="{{ route('user.info') }}"
                                style="display:block;padding:8px 12px;border-radius:6px;color:#cbd5dd;text-decoration:none">Información</a>
                            <form method="POST" action="{{ route('logout') }}" style="margin:6px 0 0">
                                @csrf
                                <button type="submit"
                                    style="display:block;padding:8px 12px;border-radius:6px;color:#cbd5dd;background:transparent;border:0;text-align:left;width:100%">Salir</button>
                            </form>
                        </div>
                    </div>
                </aside>
                @yield('content')
            </div>
        </div>
    </div>
    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>

</html>
