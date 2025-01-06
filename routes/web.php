<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\DisponibilidadController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\RecordatorioController;
use App\Http\Controllers\GerenciaController;
use App\Http\Controllers\EstadisticaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio', function () {
    return view('inicio');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/panelPaciente', function () {
    return view('panelPaciente');
});

Route::get('/register', function () {
    return view('register');
});
*/
Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('patients', PatientController::class);
Route::resource('doctors', DoctorController::class);
Route::resource('historials', HistorialController::class);
Route::resource('secretarias', SecretariaController::class);
Route::resource('citas', CitaController::class);
Route::resource('disponibilidades', DisponibilidadController::class);
Route::resource('notificaciones', NotificacionController::class);
Route::resource('recordatorios', RecordatorioController::class);
Route::resource('gerencias', GerenciaController::class);
Route::resource('estadisticas', EstadisticaController::class);