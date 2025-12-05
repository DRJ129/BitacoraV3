@extends('layouts.app')

@section('title', 'Bitácora - Dashboard')

@section('content')
    <main class="main">
        <div class="topbar">
            <div class="title-pill">Bitácora</div>
        </div>

        <div class="content">
            <!-- Aquí irá el contenido principal: lista, tablas, etc. -->
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
        // Cerrar submenu al clicar fuera
        document.addEventListener('click', function(e) {
            var btn = document.getElementById('adminBtn');
            var sub = document.getElementById('adminSub');
            if (!btn || !sub) return;
            if (!btn.contains(e.target) && !sub.contains(e.target)) {
                sub.style.display = 'none';
            }
        });

        function toggleUser() {
            var sub = document.getElementById('userSub');
            if (!sub) return;
            sub.style.display = (sub.style.display === 'none' || sub.style.display === '') ? 'block' : 'none';
        }
        // Cerrar user submenu al clicar fuera
        document.addEventListener('click', function(e) {
            var btn = document.getElementById('userBtn');
            var sub = document.getElementById('userSub');
            if (!btn || !sub) return;
            if (!btn.contains(e.target) && !sub.contains(e.target)) {
                sub.style.display = 'none';
            }
        });
    </script>
    @endphp
