<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rutina;
use App\Models\Incidencia;
use App\Models\RutinaCompletion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
    // For now only weekly range is allowed from the UI; default to 'week'
    $range = $request->query('range', 'week');
        $from = null;
        $to = null;

        switch ($range) {
            case 'yesterday':
                $from = Carbon::today()->subDay()->startOfDay();
                $to = Carbon::today()->subDay()->endOfDay();
                break;
            case 'week':
                $from = Carbon::today()->startOfWeek();
                $to = Carbon::today()->endOfWeek();
                break;
            case 'custom':
                try {
                    $from = $request->query('from') ? Carbon::parse($request->query('from'))->startOfDay() : Carbon::today()->startOfDay();
                    $to = $request->query('to') ? Carbon::parse($request->query('to'))->endOfDay() : Carbon::today()->endOfDay();
                } catch (\Exception $e) {
                    $from = Carbon::today()->startOfDay();
                    $to = Carbon::today()->endOfDay();
                }
                break;
            case 'today':
            default:
                $from = Carbon::today()->startOfDay();
                $to = Carbon::today()->endOfDay();
                break;
        }

        // Routines considered 'done' are those with a completion record within the range for the current user
        $userId = Auth::id();
        if (!$userId) {
            $doneRoutineIds = [];
        } else {
            $doneRoutineIds = RutinaCompletion::whereBetween('date', [$from->toDateString(), $to->toDateString()])
                ->where('user_id', $userId)
                ->pluck('rutina_id')->unique()->toArray();
        }
        $routinesDone = Rutina::whereIn('id', $doneRoutineIds)->orderBy('id','desc')->get();

        if ($userId) {
            $incidencias = Incidencia::whereBetween('created_at', [$from, $to])
                ->where('user_id', $userId)
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $incidencias = collect();
        }

        // If week range, group results per day so the view can render a list per weekday
        $byDay = null;
        if ($range === 'week') {
            $byDay = [];
            // ensure starting at startOfWeek (Monday)
            $start = $from->copy()->startOfDay();

            // allow optional sub-range selection inside the week via date inputs from_date and to_date
            $fromDateParam = $request->query('from_date');
            $toDateParam = $request->query('to_date');

            try {
                $fromDate = $fromDateParam ? Carbon::parse($fromDateParam)->startOfDay() : $start->copy()->startOfDay();
            } catch (\Exception $e) {
                $fromDate = $start->copy()->startOfDay();
            }

            try {
                $toDate = $toDateParam ? Carbon::parse($toDateParam)->endOfDay() : $start->copy()->endOfDay();
            } catch (\Exception $e) {
                $toDate = $start->copy()->endOfDay();
            }

            // Clamp the selected dates to the week boundaries
            $weekStart = $start->copy()->startOfDay();
            $weekEnd = $start->copy()->endOfWeek()->endOfDay();

            if ($fromDate->lt($weekStart)) $fromDate = $weekStart->copy();
            if ($toDate->gt($weekEnd)) $toDate = $weekEnd->copy();
            if ($fromDate->gt($toDate)) {
                // swap if inverted
                $tmp = $fromDate;
                $fromDate = $toDate;
                $toDate = $tmp;
            }

            // iterate day by day from $fromDate to $toDate
            $cursor = $fromDate->copy()->startOfDay();
            while ($cursor->lte($toDate)) {
                $dayStart = $cursor->copy()->startOfDay();
                $dayEnd = $cursor->copy()->endOfDay();

                if ($userId) {
                    $rDoneIds = RutinaCompletion::whereDate('date', $dayStart->toDateString())
                        ->where('user_id', $userId)
                        ->pluck('rutina_id')->unique()->toArray();
                } else {
                    $rDoneIds = [];
                }
                $rDone = Rutina::whereIn('id', $rDoneIds)->orderBy('id','desc')->get();

                if ($userId) {
                    $incs = Incidencia::whereBetween('created_at', [$dayStart, $dayEnd])
                        ->where('user_id', $userId)
                        ->with('user')
                        ->orderBy('created_at', 'asc')
                        ->get();
                } else {
                    $incs = collect();
                }

                // Spanish weekday names starting Monday
                $weekdayName = ucfirst(
                    \Carbon\Carbon::parse($dayStart)->locale('es')->isoFormat('dddd')
                );

                $byDay[] = [
                    'date' => $dayStart->copy(),
                    'weekday' => $weekdayName,
                    'routines' => $rDone,
                    'incidencias' => $incs,
                ];
                $cursor->addDay();
            }
            // pass chosen date strings to the view for pre-filling inputs
            $from_date = $fromDate->copy();
            $to_date = $toDate->copy();
        }

        return view('admin.reportes', compact('routinesDone', 'incidencias', 'range', 'from', 'to', 'byDay', 'from_date', 'to_date'));
    }

    /**
     * Generate or return a PDF for a single day (YYYY-MM-DD)
     */
    public function pdfDay(Request $request, $date)
    {
        try {
            $day = Carbon::parse($date)->startOfDay();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Fecha inválida');
        }

        $dayStart = $day->copy()->startOfDay();
        $dayEnd = $day->copy()->endOfDay();

    $routines = [];
    $userId = Auth::id();
    if ($userId) {
        $routines = Rutina::whereIn('id', RutinaCompletion::whereDate('date', $dayStart->toDateString())->where('user_id', $userId)->pluck('rutina_id')->unique()->toArray())->orderBy('id','desc')->get();
    }

    // Incidencias del día en orden de inserción (asc)
    if ($userId) {
        $incidencias = Incidencia::whereBetween('created_at', [$dayStart, $dayEnd])
            ->where('user_id', $userId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();
    } else {
        $incidencias = collect();
    }

        $viewData = ['title' => 'Reporte ' . $day->format('Y-m-d'), 'byDay' => [[
            'date' => $day,
            'weekday' => ucfirst(\Carbon\Carbon::parse($day)->locale('es')->isoFormat('dddd')),
            'routines' => $routines,
            'incidencias' => $incidencias,
        ]]];

        // If PDF generator (barryvdh/laravel-dompdf) is installed, use it
        if (class_exists('\Barryvdh\DomPDF\Facade') || class_exists('\Dompdf\Dompdf')) {
            try {
                $pdf = app('dompdf.wrapper')->loadView('admin.pdf.reporte', $viewData);
                return $pdf->download('reporte-' . $day->format('Y-m-d') . '.pdf');
            } catch (\Exception $e) {
                // fallthrough to HTML view
            }
        }

        // Fallback: return HTML view with a notice instructing user to print to PDF
        return view('admin.pdf.reporte', array_merge($viewData, ['notice' => 'No hay generador PDF instalado en el servidor. Puedes usar "Imprimir -> Guardar como PDF" desde el navegador.']));
    }

    /**
     * Generate or return a PDF for the selected range (from_date,to_date)
     */
    public function pdfRange(Request $request)
    {
        $fromParam = $request->query('from_date');
        $toParam = $request->query('to_date');

        try {
            $fromDate = $fromParam ? Carbon::parse($fromParam)->startOfDay() : Carbon::today()->startOfWeek();
        } catch (\Exception $e) {
            $fromDate = Carbon::today()->startOfWeek();
        }
        try {
            $toDate = $toParam ? Carbon::parse($toParam)->endOfDay() : Carbon::today()->endOfWeek();
        } catch (\Exception $e) {
            $toDate = Carbon::today()->endOfWeek();
        }

        if ($fromDate->gt($toDate)) { $tmp = $fromDate; $fromDate = $toDate; $toDate = $tmp; }

        // current user id (needed to filter routines/incidencias per user)
        $userId = Auth::id();

        $byDay = [];
        $cursor = $fromDate->copy()->startOfDay();
        while ($cursor->lte($toDate)) {
            $dayStart = $cursor->copy()->startOfDay();
            $dayEnd = $cursor->copy()->endOfDay();

            if ($userId) {
                $rDoneIds = RutinaCompletion::whereDate('date', $dayStart->toDateString())->where('user_id', $userId)->pluck('rutina_id')->unique()->toArray();
            } else {
                $rDoneIds = [];
            }
            $rDone = Rutina::whereIn('id', $rDoneIds)->orderBy('id','desc')->get();

            if ($userId) {
                $incs = Incidencia::whereBetween('created_at', [$dayStart, $dayEnd])
                    ->where('user_id', $userId)
                    ->with('user')
                    ->orderBy('created_at', 'asc')
                    ->get();
            } else {
                $incs = collect();
            }

            $weekdayName = ucfirst(\Carbon\Carbon::parse($dayStart)->locale('es')->isoFormat('dddd'));

            $byDay[] = [
                'date' => $dayStart->copy(),
                'weekday' => $weekdayName,
                'routines' => $rDone,
                'incidencias' => $incs,
            ];

            $cursor->addDay();
        }

        $viewData = ['title' => 'Reporte ' . $fromDate->format('Y-m-d') . ' a ' . $toDate->format('Y-m-d'), 'byDay' => $byDay];

        if (class_exists('\Barryvdh\DomPDF\Facade') || class_exists('\Dompdf\Dompdf')) {
            try {
                $pdf = app('dompdf.wrapper')->loadView('admin.pdf.reporte', $viewData);
                return $pdf->download('reporte-' . $fromDate->format('Y-m-d') . '_to_' . $toDate->format('Y-m-d') . '.pdf');
            } catch (\Exception $e) {
                // fallthrough
            }
        }

        return view('admin.pdf.reporte', array_merge($viewData, ['notice' => 'No hay generador PDF instalado en el servidor. Puedes usar "Imprimir -> Guardar como PDF" desde el navegador.']));
    }
}
