@extends('layouts.app')

@section('title', 'Bitácora - Dashboard')

@section('content')
    <main class="main">
        <div class="topbar">
            <div class="title-pill">Bitácora</div>
        </div>

        <div class="content">
            <!-- Gráfico de barras: incidencias registradas vs rutinas realizadas (últimos 7 días) -->
            <div class="card p-4 bg-white rounded-base shadow-sm">
                <h2 class="text-lg font-semibold mb-3">Resumen semanal</h2>
                <div id="chartData" style="width:340px;height:160px"
                     data-labels='{!! json_encode($labels ?? []) !!}'
                     data-inc='{!! json_encode($incCounts ?? []) !!}'
                     data-rut='{!! json_encode($rutCounts ?? []) !!}'>
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

        // Chart: pintar barras con los datos proporcionados desde la ruta
        (function(){
            try {
                var ctx = document.getElementById('activityChart');
                if (!ctx) return;

                var dataEl = document.getElementById('chartData');
                var labels = JSON.parse(dataEl.getAttribute('data-labels') || '[]');
                var inc = JSON.parse(dataEl.getAttribute('data-inc') || '[]');
                var rut = JSON.parse(dataEl.getAttribute('data-rut') || '[]');

                // determine a simple y-axis max so bars don't look huge
                var flat = [].concat(inc || [], rut || []);
                var maxVal = flat.length ? Math.max.apply(null, flat) : 0;
                var yMax = Math.max(5, Math.ceil(maxVal * 1.2)); // at least 5, otherwise 20% headroom
                var step = Math.ceil(yMax / 5);

                var chart = new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Incidencias',
                                data: inc,
                                backgroundColor: 'rgba(255,99,132,0.8)'
                            },
                            {
                                label: 'Rutinas realizadas',
                                data: rut,
                                backgroundColor: 'rgba(54,162,235,0.8)'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        aspectRatio: 2.5,
                        scales: {
                            x: { stacked: false },
                            y: { beginAtZero: true, max: yMax, ticks: { stepSize: step } }
                        },
                        plugins: {
                            legend: { position: 'top' }
                        }
                    }
                });
            } catch (e) {
                console.error('Error inicializando el gráfico', e);
            }
        })();
    </script>
    @endpush
