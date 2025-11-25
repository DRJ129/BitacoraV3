<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Mostrar listado
    public function index()
    {
        $users = User::orderBy('id','desc')->get();
        return view('admin.usuarios', compact('users'));
    }

    // Crear nuevo usuario
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'role' => $data['role'] ?? null,
            'password' => isset($data['password']) ? Hash::make($data['password']) : Hash::make(uniqid()),
        ]);

        return redirect()->route('admin.usuarios')->with('success','Usuario creado');
    }

    // Actualizar usuario
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'nullable|string|max:50',
        ]);

        $user->name = $data['name'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->role = $data['role'] ?? null;
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('admin.usuarios')->with('success','Usuario actualizado');
    }

    // Eliminar usuario
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.usuarios')->with('success','Usuario eliminado');
    }
}
