<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RutinaController;

Route::get('/', function () {
    // Si está autenticado, mostrar dashboard; si no, la vista welcome
    if (Auth::check()) {
        return view('dashboard');
    }

    return view('welcome');
});

// Ruta para la vista de login creada manualmente
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Ruta para la vista de registro creada manualmente
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Rutas POST para procesar formularios
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/register', [RegisterController::class, 'register']);

// Rutas administrativas (usuarios ahora usa controlador)
Route::get('/admin/usuarios', [UserController::class, 'index'])->name('admin.usuarios');
Route::post('/admin/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store');
Route::match(['put','patch'],'/admin/usuarios/{user}', [UserController::class, 'update'])->name('admin.usuarios.update');
Route::delete('/admin/usuarios/{user}', [UserController::class, 'destroy'])->name('admin.usuarios.destroy');

// Rutas de rutinas (controlador)
Route::get('/admin/rutinas', [RutinaController::class, 'index'])->name('admin.rutinas');
Route::post('/admin/rutinas', [RutinaController::class, 'store'])->name('admin.rutinas.store');
Route::match(['put','patch'], '/admin/rutinas/{rutina}', [RutinaController::class, 'update'])->name('admin.rutinas.update');
Route::delete('/admin/rutinas/{rutina}', [RutinaController::class, 'destroy'])->name('admin.rutinas.destroy');

// Página de crear usuario (GET)
Route::get('/admin/usuarios/create', function(){
    return view('admin.usuarios_create');
})->name('admin.usuarios.create');

// Página de editar usuario (GET)
Route::get('/admin/usuarios/{user}/edit', function(User $user){
    return view('admin.usuarios_edit', compact('user'));
})->name('admin.usuarios.edit');

// Información de usuario
Route::get('/user/info', function(){
    return view('user.info');
})->name('user.info');

// Logout (POST)
use Illuminate\Http\Request;
Route::post('/logout', function(Request $request){
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


