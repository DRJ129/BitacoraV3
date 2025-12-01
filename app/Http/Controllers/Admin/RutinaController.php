<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rutina;
use App\Models\RutinaCompletion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RutinaController extends Controller
{
    public function index()
    {
        $routines = Rutina::orderBy('id','desc')->get();
        return view('admin.rutinas', compact('routines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        Rutina::create(['content' => $data['content']]);
        return redirect()->route('admin.rutinas')->with('success','Rutina creada');
    }

    public function update(Request $request, Rutina $rutina)
    {
        // If request is toggling completion only
        if ($request->has('completed') && !$request->has('content')) {
            // Treat completion toggles as daily completions persisted in rutina_completions
            $completed = $request->boolean('completed');
            $today = Carbon::today()->toDateString();
            $userId = Auth::check() ? Auth::id() : null;

            if ($completed) {
                // create if not exists
                RutinaCompletion::firstOrCreate([
                    'rutina_id' => $rutina->id,
                    'user_id' => $userId,
                    'date' => $today,
                ]);
            } else {
                // remove today's completion
                RutinaCompletion::where('rutina_id', $rutina->id)
                    ->where('date', $today)
                    ->when($userId, function($q) use ($userId){
                        return $q->where('user_id', $userId);
                    })
                    ->delete();
            }

            // If request comes from the Gestión page, stay there
            $referer = $request->headers->get('referer');
            if ($referer && strpos($referer, '/admin/gestion') !== false) {
                return redirect()->route('admin.gestion')->with('success','Rutina actualizada');
            }

            // AJAX support: respond JSON to avoid redirect
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'ok', 'completed' => $completed]);
            }

            return redirect()->route('admin.gestion')->with('success','Rutina actualizada');
        }
        $data = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $rutina->content = $data['content'];
        // allow optional completed input
        if ($request->has('completed')) {
            $rutina->completed = $request->boolean('completed');
        }
        $rutina->save();

        return redirect()->route('admin.rutinas')->with('success','Rutina actualizada');
    }

    public function destroy(Rutina $rutina)
    {
        $rutina->delete();
        return redirect()->route('admin.rutinas')->with('success','Rutina eliminada');
    }
}
