<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incidencia;
use Illuminate\Support\Facades\Auth;

class IncidenciaController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $payload = ['content' => $data['content']];
        if (Auth::check()) {
            $payload['user_id'] = Auth::id();
        }

        Incidencia::create($payload);

        return redirect()->route('admin.gestion')->with('success','Incidencia guardada');
    }

    public function update(Request $request, Incidencia $incidencia)
    {
        $data = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        // Only allow the owner or an admin to update
        if (!Auth::check() || (Auth::id() !== $incidencia->user_id && Auth::user()->role !== 'admin')) {
            return redirect()->route('admin.gestion')->with('error', 'No autorizado para editar esta incidencia');
        }

        $incidencia->content = $data['content'];
        $incidencia->save();

        return redirect()->route('admin.gestion')->with('success','Incidencia actualizada');
    }

    public function destroy(Incidencia $incidencia)
    {
        // Only allow the owner or an admin to delete
        if (!Auth::check() || (Auth::id() !== $incidencia->user_id && Auth::user()->role !== 'admin')) {
            return redirect()->route('admin.gestion')->with('error', 'No autorizado para eliminar esta incidencia');
        }

        $incidencia->delete();
        return redirect()->route('admin.gestion')->with('success','Incidencia eliminada');
    }
}
