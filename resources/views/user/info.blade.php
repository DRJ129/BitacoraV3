@extends('layouts.app')
@section('title', 'Información de Usuario')


@section('content')


    <main class="main">
        <div class="topbar">
            <div class="title-pill">Información</div>
        </div>

        <div class="content">
            <div class="info-card">
                @auth
                    <div style="display:flex;justify-content:flex-end;margin-bottom:12px">
                        <button id="editProfileBtn" onclick="toggleProfileEdit();return false;"
                            style="background:var(--red-1);color:#fff;padding:6px 10px;border-radius:6px;border:0;cursor:pointer">Editar</button>
                    </div>

                    <div id="profileView">
                        <div class="info-row">
                            <label>Nombre:</label>
                            <div class="value">{{ Auth::user()->name }}</div>
                        </div>
                        <div class="info-row">
                            <label>Apellido:</label>
                            <div class="value">{{ Auth::user()->lastname ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <label>Correo:</label>
                            <div class="value">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div id="profileEdit" style="display:none">
                        <form method="POST" action="{{ route('user.info.update') }}">
                            @csrf
                            @method('PATCH')
                            <div class="info-row">
                                <label for="name">Nombre:</label>
                                <input id="name" name="name" class="value"
                                    style="background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;color:#e6eef2"
                                    value="{{ old('name', Auth::user()->name) }}" required />
                            </div>
                            <div class="info-row">
                                <label for="lastname">Apellido:</label>
                                <input id="lastname" name="lastname" class="value"
                                    style="background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;color:#e6eef2"
                                    value="{{ old('lastname', Auth::user()->lastname) }}" />
                            </div>
                            <div class="info-row">
                                <label>Correo:</label>
                                <input disabled class="value"
                                    style="background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;color:#9fb0b8"
                                    value="{{ Auth::user()->email }}" />
                            </div>
                            <div class="info-row">
                                <label for="password">Nueva contraseña:</label>
                                <input id="password" name="password" type="password" class="value"
                                    style="background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;color:#e6eef2" />
                            </div>
                            <div class="info-row">
                                <label for="password_confirmation">Confirmar contraseña:</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="value"
                                    style="background:transparent;border:1px solid rgba(255,255,255,0.03);padding:6px;border-radius:6px;color:#e6eef2" />
                            </div>

                            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:12px">
                                <button type="button" onclick="toggleProfileEdit();return false;"
                                    style="background:#3b3f44;color:#fff;padding:6px 10px;border-radius:6px;border:0;cursor:pointer">Cancelar</button>
                                <button type="submit"
                                    style="background:var(--red-1);color:#fff;padding:6px 10px;border-radius:6px;border:0;cursor:pointer">Guardar</button>
                            </div>
                        </form>
                    </div>
                @else
                    <p>No hay usuario autenticado.</p>
                @endauth
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
