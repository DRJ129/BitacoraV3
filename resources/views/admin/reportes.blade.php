@extends('layouts.app')
@section('title', 'Bitácora - Agregar usuario')

@section('content')
    <main class="main">


        <div class="topbar">
            <div class="title-pill">Reportes</div>
        </div>

        <div class="content">
            <form method="GET" action="{{ route('admin.reportes') }}" class="card">
                <div class="flex gap-2">
                    <label style="font-weight:700">Rango</label>
                    <label><input type="radio" name="range" value="week" checked> Semana</label>

                    <label style="margin-left:12px">Desde (fecha)</label>
                    @php $defaultFrom = isset($from_date) ? $from_date : (isset($from) ? $from->copy()->startOfDay() : \Carbon\Carbon::today()->startOfWeek()); @endphp
                    <input type="date" name="from_date"
                        value="{{ isset($defaultFrom) ? $defaultFrom->format('Y-m-d') : '' }}"
                        style="padding:6px;border-radius:6px;background:transparent;color:#e6eef2;border:1px solid rgba(255,255,255,0.03)">

                    <label>Hasta (fecha)</label>
                    @php $defaultTo = isset($to_date) ? $to_date : (isset($to) ? $to->copy()->endOfDay() : \Carbon\Carbon::today()->endOfWeek()); @endphp
                    <input type="date" name="to_date" value="{{ isset($defaultTo) ? $defaultTo->format('Y-m-d') : '' }}"
                        style="padding:6px;border-radius:6px;background:transparent;color:#e6eef2;border:1px solid rgba(255,255,255,0.03)">

                    <div style="margin-left:auto">
                        <button type="submit"
                            style="background:var(--red-1);color:#fff;padding:8px 12px;border-radius:8px;border:0;cursor:pointer;font-weight:700">Consultar</button>
                    </div>
                </div>
            </form>

            <div class="results">
                @if (isset($range) && $range === 'week' && isset($byDay) && count($byDay))
                    {{-- Mostrar lista por día para la semana --}}
                    @foreach ($byDay as $day)
                        <div
                            style="display:flex;align-items:center;justify-content:space-between;margin-top:8px;margin-bottom:6px">
                            <div style="font-weight:800;font-size:18px">{{ $day['weekday'] }}</div>
                            <div style="color:#cbd5dd">{{ $day['date']->format('d/m/Y') }}</div>
                        </div>
                        <div style="text-align:right;margin-bottom:8px">
                            <a href="{{ route('admin.reportes.pdf.day', ['date' => $day['date']->format('Y-m-d')]) }}"
                                target="_blank"
                                style="background:var(--red-1);color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none">Generar
                                PDF del día</a>
                        </div>

                        <div class="card" style="margin-bottom:10px">
                            <div style="display:flex;gap:18px;flex-wrap:wrap">
                                <div style="flex:1;min-width:240px">
                                    <div style="font-weight:700;margin-bottom:6px">Rutinas marcadas</div>
                                    @if (isset($day['routines']) && count($day['routines']))
                                        @foreach ($day['routines'] as $r)
                                            <div style="padding:6px 0;border-bottom:1px solid rgba(255,255,255,0.02)">
                                                <div style="font-weight:700">{{ $r->content }}</div>
                                                <div style="font-size:12px;color:#9fb0b8">Marcada:
                                                    {{ $r->updated_at ? $r->updated_at->format('H:i') : '' }}</div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div style="color:#9fb0b8">No hay rutinas marcadas este día.</div>
                                    @endif
                                </div>

                                <div style="flex:1;min-width:240px">
                                    <div style="font-weight:700;margin-bottom:6px">Incidencias</div>
                                    @if (isset($day['incidencias']) && count($day['incidencias']))
                                        @foreach ($day['incidencias'] as $inc)
                                            <div style="padding:6px 0;border-bottom:1px solid rgba(255,255,255,0.02)">
                                                <div style="font-weight:700">Incidencia #{{ $loop->iteration }}</div>
                                                <div style="color:#cbd5dd">{{ $inc->content }}</div>
                                                <div style="font-size:13px;color:#cbd5dd">Por:
                                                    {{ optional($inc->user)->name }} {{ optional($inc->user)->lastname }}
                                                </div>
                                                <div style="font-size:12px;color:#9fb0b8">Creada:
                                                    {{ $inc->created_at ? $inc->created_at->format('H:i') : '' }}</div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div style="color:#9fb0b8">No hay incidencias este día.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Comportamiento normal (today/custom/yesterday) --}}
                    <h3>Rutinas</h3>
                    @if (isset($routinesDone) && count($routinesDone))
                        @foreach ($routinesDone as $r)
                            <div class="result-box">
                                <div style="font-weight:700">{{ $r->content }}</div>
                                <div style="font-size:12px;color:#9fb0b8">Marcada:
                                    {{ $r->updated_at ? $r->updated_at->format('Y-m-d H:i') : '' }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="result-box">No hay rutinas marcadas en el rango seleccionado.</div>
                    @endif

                    <h3 style="margin-top:18px">Incidencias registradas</h3>
                    @if (isset($incidencias) && count($incidencias))
                        @php
                            $currentDate = null;
                            $dailyCounter = 0;
                        @endphp
                        @foreach ($incidencias as $inc)
                            @php
                                $incDate = $inc->created_at ? $inc->created_at->format('Y-m-d') : null;
                                if ($incDate !== $currentDate) {
                                    $currentDate = $incDate;
                                    $dailyCounter = 1;
                                } else {
                                    $dailyCounter++;
                                }
                            @endphp
                            <div class="result-box">
                                <div style="font-weight:700">Incidencia #{{ $dailyCounter }}
                                    ({{ $inc->created_at ? $inc->created_at->format('d/m/Y') : '' }})
                                </div>
                                <div style="color:#cbd5dd">{{ $inc->content }}</div>
                                <div style="font-size:13px;color:#cbd5dd">Por: {{ optional($inc->user)->name }}
                                    {{ optional($inc->user)->lastname }}</div>
                                <div style="font-size:12px;color:#9fb0b8">Creada:
                                    {{ $inc->created_at ? $inc->created_at->format('Y-m-d H:i') : '' }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="result-box">No hay incidencias en el rango seleccionado.</div>
                    @endif
                @endif

                {{-- Botón para generar PDF del rango seleccionado --}}
                <div style="margin-top:18px;text-align:right">
                    @php
                        $pdfQuery = [];
                        if (isset($from_date)) {
                            $pdfQuery['from_date'] = $from_date->format('Y-m-d');
                        }
                        if (isset($to_date)) {
                            $pdfQuery['to_date'] = $to_date->format('Y-m-d');
                        }
                    @endphp
                    <a href="{{ route('admin.reportes.pdf.range', $pdfQuery) }}" target="_blank"
                        style="background:#111;color:#fff;padding:8px 12px;border-radius:8px;text-decoration:none">Generar
                        PDF de la semana</a>
                </div>
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
    </script>
@endpush
