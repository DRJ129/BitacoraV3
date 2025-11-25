<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Routine;

class RoutineController extends Controller
{
    /**
     * Store a newly created routine.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:100',
            'owner' => 'nullable|string|max:255',
        ]);

        Routine::create($data);

        return redirect()->route('admin.rutinas')->with('success', 'Rutina creada');
    }

    /**
     * Update the specified routine.
     */
    public function update(Request $request, Routine $routine)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:100',
            'owner' => 'nullable|string|max:255',
        ]);

        $routine->update($data);

        return redirect()->route('admin.rutinas')->with('success', 'Rutina actualizada');
    }

    /**
     * Remove the specified routine.
     */
    public function destroy(Routine $routine)
    {
        $routine->delete();
        return redirect()->route('admin.rutinas')->with('success', 'Rutina eliminada');
    }
}
