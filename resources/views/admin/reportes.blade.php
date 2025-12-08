@extends('layouts.app')
@section('title', 'Bitácora - Reportes')

@section('content')


    <div class="">
        <h2 class="text-sm text-center font-bold tracking-tight text-heading md:text-sm lg:text-2xl">
            Reportes</h2>
    </div>



    <form method="GET" action="{{ route('admin.reportes') }}" class=" text-black dark:text-white text-sm">
        <div class="flex flex-col md:flex-row justify-between gap-4 p-4">
            <div class="flex gap-2 items-center">
                <label>Rango</label>
                <label><input type="radio" name="range" value="week" checked> Semana</label>
            </div>

            <div class="flex gap-2 items-center">
                <label>Desde (fecha)</label>
                @php $defaultFrom = isset($from_date) ? $from_date : (isset($from) ? $from->copy()->startOfDay() : \Carbon\Carbon::today()->startOfWeek()); @endphp
                <input type="date" name="from_date"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-3.5 py-3 shadow-xs placeholder:text-body"
                    value="{{ isset($defaultFrom) ? $defaultFrom->format('Y-m-d') : '' }}">

            </div>

            <div class="flex gap-2 items-center">
                <label>Hasta (fecha)</label>
                @php $defaultTo = isset($to_date) ? $to_date : (isset($to) ? $to->copy()->endOfDay() : \Carbon\Carbon::today()->endOfWeek()); @endphp
                <input type="date" name="to_date" value="{{ isset($defaultTo) ? $defaultTo->format('Y-m-d') : '' }}"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-3.5 py-3 shadow-xs placeholder:text-body">
            </div>


            <div class="flex items-center">
                <button type="submit"
                    class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none cursor-pointer">Consultar</button>
            </div>
        </div>
    </form>

    <div class="flex flex-col gap-4">
        @if (isset($range) && $range === 'week' && isset($byDay) && count($byDay))
            {{-- Mostrar lista por día para la semana --}}
            @foreach ($byDay as $day)
                <div class="flex justify-between">
                    <div class="px-2 flex items-center gap-2">
                        <div class="text-black dark:text-white">{{ $day['weekday'] }}</div>
                        <div class="text-black dark:text-white">{{ $day['date']->format('d/m/Y') }}</div>
                    </div>
                    <div class="px-2 flex items-center gap-2">
                        <a href="{{ route('admin.reportes.pdf.day', ['date' => $day['date']->format('Y-m-d')]) }}"
                            target="_blank"
                            class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Generar
                            PDF del día</a>
                    </div>
                </div>

                <div class="border border-slate-300 rounded-sm p-2 text-sm text-black dark:text-white">
                    <div class="flex gap-2 items-center">
                        <div class="flex flex-col gap-2 w-[50%]">
                            <div class="font-bold">Rutinas marcadas</div>
                            @if (isset($day['routines']) && count($day['routines']))
                                @foreach ($day['routines'] as $r)
                                    <div style="padding:6px 0;border-bottom:1px solid rgba(255,255,255,0.02)">
                                        <div>{{ $r->content }}</div>
                                        <div>Marcada:
                                            {{ $r->updated_at ? $r->updated_at->format('H:i') : '' }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div>No hay rutinas marcadas este día.</div>
                            @endif
                        </div>

                        <div class="flex flex-col gap-2 w-[50%]">
                            <div class="font-bold">Incidencias</div>
                            @if (isset($day['incidencias']) && count($day['incidencias']))
                                @foreach ($day['incidencias'] as $inc)
                                    <div style="padding:6px 0;border-bottom:1px solid rgba(255,255,255,0.02)">
                                        <div class="">Incidencia #{{ $loop->iteration }}</div>
                                        <div class="">{{ $inc->content }}</div>
                                        <div class="">Por:
                                            {{ optional($inc->user)->name }} {{ optional($inc->user)->lastname }}
                                        </div>
                                        <div class="">Creada:
                                            {{ $inc->created_at ? $inc->created_at->format('H:i') : '' }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="">No hay incidencias este día.</div>
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
                    <div class="">
                        <div>{{ $r->content }}</div>
                        <div>Marcada:
                            {{ $r->updated_at ? $r->updated_at->format('Y-m-d H:i') : '' }}</div>
                    </div>
                @endforeach
            @else
                <div class="">No hay rutinas marcadas en el rango seleccionado.</div>
            @endif

            <h3>Incidencias registradas</h3>
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
                    <div class="">
                        <div>Incidencia #{{ $dailyCounter }}
                            ({{ $inc->created_at ? $inc->created_at->format('d/m/Y') : '' }})
                        </div>
                        <div>{{ $inc->content }}</div>
                        <div>Por: {{ optional($inc->user)->name }}
                            {{ optional($inc->user)->lastname }}</div>
                        <div>Creada:
                            {{ $inc->created_at ? $inc->created_at->format('Y-m-d H:i') : '' }}</div>
                    </div>
                @endforeach
            @else
                <div class="">No hay incidencias en el rango seleccionado.</div>
            @endif
        @endif

        {{-- Botón para generar PDF del rango seleccionado --}}
        <div class="flex items-center p-1 justify-end">
            @php
                $pdfQuery = [];
                if (isset($from_date)) {
                    $pdfQuery['from_date'] = $from_date->format('Y-m-d');
                }
                if (isset($to_date)) {
                    $pdfQuery['to_date'] = $to_date->format('Y-m-d');
                }
            @endphp
            <a class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none" href="{{ route('admin.reportes.pdf.range', $pdfQuery) }}" target="_blank" class="">Generar
                PDF de la semana</a>
        </div>
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
    </script>
@endpush
