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

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // Redireccionar según el rol usando el middleware
        if (auth()->check()) {
            if (request()->user()->hasAnyRole(['patient'])) {
                return redirect()->route('patients.dashboard');
            }
            if (request()->user()->hasAnyRole(['gerencia'])) {
                return redirect()->route('gerencia.dashboard');
            }
            if (request()->user()->hasAnyRole(['secretaria'])) {
                return redirect()->route('secretaria.dashboard');
            }
            if (request()->user()->hasAnyRole(['doctor'])) {
                return redirect()->route('doctor.dashboard');
            }
            if (request()->user()->hasAnyRole(['admin'])) {
                return redirect()->route('admin.dashboard');
            }
        }

        return redirect()->route('home');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:gerencia'])->group(function () {
    Route::get('/gerencia/dashboard', [GerenciaController::class, 'dashboard'])->name('gerencia.dashboard');
    // Otras rutas para el rol Gerencia
});

Route::middleware(['auth', 'role:secretaria|doctor'])->group(function () {
    Route::get('/secretaria/dashboard', [SecretariaController::class, 'dashboard'])->name('secretaria.dashboard');
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');

    // Rutas para la secretaria
    Route::prefix('secretaria')->name('secretaria.')->group(function () {
        // Rutas de pacientes
        Route::get('/pacientes', [SecretariaController::class, 'pacientes'])->name('pacientes.index');
        Route::get('/pacientes/data', [SecretariaController::class, 'getPacientesData'])->name('pacientes.data');
        Route::get('/pacientes/create', [SecretariaController::class, 'createPaciente'])->name('pacientes.create');
        Route::post('/pacientes', [SecretariaController::class, 'storePaciente'])->name('pacientes.store');
        Route::get('/pacientes/{paciente}/edit', [SecretariaController::class, 'editPaciente'])->name('pacientes.edit');
        Route::get('/pacientes/{paciente}', [SecretariaController::class, 'showPaciente'])->name('pacientes.show');

        // Rutas de citas
        Route::get('/citas', [SecretariaController::class, 'citas'])->name('citas.index');
        Route::get('/citas/create', [SecretariaController::class, 'createCita'])->name('citas.create');
        Route::post('/citas', [SecretariaController::class, 'storeCita'])->name('citas.store');
        Route::get('/citas/{cita}/edit', [SecretariaController::class, 'editCita'])->name('citas.edit');
        Route::put('/citas/{cita}', [SecretariaController::class, 'updateCita'])->name('citas.update');
        Route::delete('/citas/{cita}', [SecretariaController::class, 'destroyCita'])->name('citas.destroy');

        // Rutas de agenda
        Route::get('/citas/eventos', [SecretariaController::class, 'getEventos'])->name('citas.eventos');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/citas/create', [CitaController::class, 'create'])->name('citas.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('patients', PatientController::class)->except(['edit', 'update']);
});

Route::middleware(['auth', 'role:patient'])->prefix('pacientes')->name('patients.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\PatientController::class, 'dashboard'])->name('dashboard');

    // Citas
    Route::controller(App\Http\Controllers\PatientController::class)->group(function () {
        Route::get('/citas', 'appointments')->name('appointments.index');
        Route::get('/citas/crear', 'createAppointment')->name('appointments.create');
        Route::post('/citas', 'storeAppointment')->name('appointments.store');
        Route::post('/citas/{cita}/cancelar', 'cancelAppointment')->name('appointments.cancel');
    });

    // Historial Médico
    Route::get('/historial', [App\Http\Controllers\HistorialController::class, 'index'])->name('historial.index');
    Route::get('/historial/{historial}', [App\Http\Controllers\HistorialController::class, 'show'])->name('historial.show');

    // Recordatorios
    Route::controller(App\Http\Controllers\RecordatorioController::class)->group(function () {
        Route::get('/recordatorios', 'index')->name('recordatorios.index');
        Route::post('/recordatorios', 'store')->name('recordatorios.store');
        Route::get('/recordatorios/{recordatorio}', 'show')->name('recordatorios.show');
        Route::put('/recordatorios/{recordatorio}', 'update')->name('recordatorios.update');
        Route::delete('/recordatorios/{recordatorio}', 'destroy')->name('recordatorios.destroy');
        Route::post('/recordatorios/configuracion', 'updateConfig')->name('recordatorios.configuracion');
    });

    // Ruta para obtener disponibilidad
    Route::get('/citas/disponibilidad/{doctor}/{fecha}', [App\Http\Controllers\CitaController::class, 'getDisponibilidad'])
        ->name('appointments.disponibilidad');

    // Perfil del paciente
    Route::get('/perfil', [App\Http\Controllers\PatientController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [App\Http\Controllers\PatientController::class, 'update'])->name('profile.update');
    Route::post('/perfil/foto', [App\Http\Controllers\PatientController::class, 'updatePhoto'])->name('profile.photo');
});

Route::resource('doctors', DoctorController::class);
Route::resource('historials', HistorialController::class);
Route::resource('secretarias', SecretariaController::class);
Route::resource('citas', CitaController::class);
Route::resource('disponibilidades', DisponibilidadController::class);
Route::resource('notificaciones', NotificacionController::class);
Route::resource('recordatorios', RecordatorioController::class);
Route::resource('gerencias', GerenciaController::class);
Route::resource('estadisticas', EstadisticaController::class);

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Rutas de gestión de usuarios
    Route::get('/users', [App\Http\Controllers\Admin\DashboardController::class, 'listUsers'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\DashboardController::class, 'createUser'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Admin\DashboardController::class, 'storeUser'])->name('users.store');
    Route::get('/users/data', [App\Http\Controllers\Admin\DashboardController::class, 'getUsersData'])->name('users.data');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\DashboardController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\DashboardController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\DashboardController::class, 'destroyUser'])->name('users.destroy');
});

// Rutas para el doctor
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/pacientes', [DoctorController::class, 'pacientes'])->name('doctor.pacientes');
    Route::get('/doctor/agenda', [DoctorController::class, 'verAgenda'])->name('doctor.agenda');
    Route::get('/doctor/agenda/eventos', [DoctorController::class, 'eventos'])->name('doctor.agenda.eventos');
    Route::get('/doctor/citas', [DoctorController::class, 'citas'])->name('doctor.citas');
    Route::get('/doctor/horario', [DoctorController::class, 'horario'])->name('doctor.horario');
    Route::post('/doctor/horario', [DoctorController::class, 'storeHorario'])->name('doctor.horario.store');
    Route::get('/doctor/horario/disponibilidad', [DoctorController::class, 'getDisponibilidad'])->name('doctor.horario.disponibilidad');
    Route::get('/doctor/horario/eventos', [DoctorController::class, 'getEventos'])->name('doctor.horario.eventos');
    Route::get('/doctor/horario/dia/{fecha}', [DoctorController::class, 'getDisponibilidadDia'])->name('doctor.horario.dia');
    Route::get('/doctor/horario/mes/{mes}', [DoctorController::class, 'getDisponibilidadMes'])->name('doctor.horario.mes');
    Route::get('/doctor/pacientes/data', [DoctorController::class, 'getPacientesData'])->name('doctor.pacientes.data');
    Route::post('/doctor/horario/eliminar', [DoctorController::class, 'eliminarDisponibilidad'])->name('doctor.horario.eliminar');
    Route::get('/doctor/horario/semana/{semana}', [DoctorController::class, 'getHorarioSemana'])->name('doctor.horario.semana');

    // Rutas para historial y consulta
    Route::get('/doctor/paciente/{paciente}/historial', [DoctorController::class, 'historial'])->name('doctor.historial');
    Route::get('/doctor/consulta/{cita}/iniciar', [DoctorController::class, 'iniciarConsulta'])->name('doctor.consulta.iniciar');
    Route::post('/doctor/consulta/{cita}/guardar', [DoctorController::class, 'guardarConsulta'])->name('doctor.consulta.guardar');
});
