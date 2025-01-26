<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:Patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    // Otras rutas para el rol Patient
    Route::get('/patient/historial', [HistorialController::class, 'index'])->name('patient.historial');
    Route::get('/patient/citas', [CitaController::class, 'index'])->name('patient.citas');
    Route::get('/patient/recordatorios', [RecordatorioController::class, 'index'])->name('patient.recordatorios');
    Route::get('/patient/profile', [PatientController::class, 'edit'])->name('patient.profile');
    Route::put('/patient/profile', [PatientController::class, 'update'])->name('patient.profile.update');
});

Route::middleware(['auth', 'role:Gerencia'])->group(function () {
    Route::get('/gerencia/dashboard', [GerenciaController::class, 'dashboard'])->name('gerencia.dashboard');
    // Otras rutas para el rol Gerencia
});

Route::middleware(['auth', 'role:Secretaria|Doctor'])->group(function () {
    Route::get('/secretaria/dashboard', [SecretariaController::class, 'dashboard'])->name('secretaria.dashboard');
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    // Otras rutas para los roles Secretaria y Doctor
});

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
