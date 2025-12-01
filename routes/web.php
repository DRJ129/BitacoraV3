<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RutinaController;
use App\Models\Rutina;
use Carbon\Carbon;

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

// Página de gestión (checklist de rutinas)
Route::get('/admin/gestion', function(){
    $routines = App\Models\Rutina::orderBy('id','desc')->get();
    // Mostrar solo incidencias creadas en la fecha actual (orden ascendente para numeración por inserción)
    $incidencias = App\Models\Incidencia::whereDate('created_at', Carbon::today())->orderBy('created_at','asc')->get();

    // Obtener completions de hoy para mostrar las rutinas marcadas del día
    $completedIds = App\Models\RutinaCompletion::whereDate('date', Carbon::today())->pluck('rutina_id')->toArray();

    // Mostrar el nombre del día en español usando Carbon
    $dayName = Carbon::now()->locale('es')->isoFormat('dddd');
    // Capitalizar correctamente (soporte multibyte)
    $dayName = mb_convert_case($dayName, MB_CASE_TITLE, 'UTF-8');
    $today = Carbon::now()->format('Y-m-d');
        return view('admin.gestion', compact('routines', 'incidencias', 'dayName', 'today', 'completedIds'));
})->name('admin.gestion');

    // incidencias
    Route::post('/admin/incidencias', [App\Http\Controllers\Admin\IncidenciaController::class, 'store'])->name('admin.incidencias.store');
    Route::patch('/admin/incidencias/{incidencia}', [App\Http\Controllers\Admin\IncidenciaController::class, 'update'])->name('admin.incidencias.update');
    Route::delete('/admin/incidencias/{incidencia}', [App\Http\Controllers\Admin\IncidenciaController::class, 'destroy'])->name('admin.incidencias.destroy');

    // reportes
    Route::get('/admin/reportes', [App\Http\Controllers\Admin\ReporteController::class, 'index'])->name('admin.reportes');
    Route::get('/admin/reportes/pdf/day/{date}', [App\Http\Controllers\Admin\ReporteController::class, 'pdfDay'])->name('admin.reportes.pdf.day');
    Route::get('/admin/reportes/pdf/range', [App\Http\Controllers\Admin\ReporteController::class, 'pdfRange'])->name('admin.reportes.pdf.range');

// Página de crear usuario (GET)
Route::get('/admin/usuarios/create', function(){
    if(!Auth::check() || Auth::user()->role !== 'admin'){
        return redirect('/')->with('error','No autorizado');
    }
    return view('admin.usuarios_create');
})->name('admin.usuarios.create');

// Página de editar usuario (GET)
Route::get('/admin/usuarios/{user}/edit', function(User $user){
    if(!Auth::check() || Auth::user()->role !== 'admin'){
        return redirect('/')->with('error','No autorizado');
    }
    return view('admin.usuarios_edit', compact('user'));
})->name('admin.usuarios.edit');

// Información de usuario
Route::get('/user/info', function(){
    return view('user.info');
})->name('user.info');

// Actualizar información de usuario (nombre, apellido, contraseña)
Route::match(['put','patch'],'/user/info', function(\Illuminate\Http\Request $request){
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if(! $user instanceof User){
        return redirect()->route('login');
    }

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'lastname' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $user->name = $data['name'];
    $user->lastname = $data['lastname'] ?? $user->lastname;
    if(!empty($data['password'])){
        $user->password = \Illuminate\Support\Facades\Hash::make($data['password']);
    }
    $user->save();

    return redirect()->route('user.info')->with('success','Información actualizada');
})->name('user.info.update');

// Logout (POST)
use Illuminate\Http\Request;
Route::post('/logout', function(Request $request){
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


