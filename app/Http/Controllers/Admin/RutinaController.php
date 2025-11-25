<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rutina;

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
        $data = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $rutina->content = $data['content'];
        $rutina->save();

        return redirect()->route('admin.rutinas')->with('success','Rutina actualizada');
    }

    public function destroy(Rutina $rutina)
    {
        $rutina->delete();
        return redirect()->route('admin.rutinas')->with('success','Rutina eliminada');
    }
}
