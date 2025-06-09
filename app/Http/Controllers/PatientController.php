<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\Appointment;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'age' => 'required|integer|min:0',
            'contacto' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients',
        ]);

        Patient::create($request->all());

        return redirect()->route('patients.index')
                        ->with('success', 'Patient created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user();
        $patient = $user->patient;

        if (!$patient) {
            return redirect()->route('patients.dashboard')
                ->with('error', 'No se encontró el perfil del paciente.');
        }

        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $patient = $user->patient;

        if (!$patient) {
            return redirect()->route('patients.dashboard')
                ->with('error', 'No se encontró el perfil del paciente.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
        ]);

        $patient->update($request->only([
            'name',
            'last_name',
            'contacto',
        ]));

        return redirect()->route('patients.dashboard')
                        ->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')
                        ->with('success', 'Patient deleted successfully.');
    }

    /**
     * Show the dashboard for the patient.
     */
    public function dashboard()
    {
        $user = auth()->user();
        $patient = $user->patient;

        if (!$patient) {
            // Redirigir o mostrar un mensaje de error si no se encuentra el registro del paciente
            // Esto puede ocurrir si un usuario con rol 'patient' no tiene un registro asociado en la tabla 'patients'
            return redirect()->route('home') // O a una página de error/configuración de perfil si existe
                ->with('error', 'No se encontró la información de su perfil de paciente. Contacte al administrador.');
        }

        $proximaCita = $patient->appointments()
            ->with('doctor')
            ->where('fecha', '>=', now())
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->first();

        $proximasCitas = $patient->appointments()
            ->with('doctor')
            ->where('fecha', '>=', now())
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->take(5)
            ->get();

        $resultados = $patient->historials()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recordatorios = $patient->recordatorios()
            ->where('fecha_hora', '>=', now())
            ->orderBy('fecha_hora', 'asc')
            ->take(5)
            ->get();

        return view('patients.dashboard', compact('proximaCita', 'proximasCitas', 'resultados', 'recordatorios'));
    }

    public function appointments()
    {
        $user = auth()->user();
        $appointments = $user->patient->appointments()
            ->with('doctor')
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('patients.appointments.index', compact('appointments'));
    }

    public function createAppointment()
    {
        $doctors = User::role('Doctor')->get();
        return view('patients.appointments.create', compact('doctors'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'fecha' => 'required|date|after:today',
            'hora' => 'required',
            'motivo' => 'required|string|max:255',
        ]);

        $appointment = new Appointment();
        $appointment->patient_id = auth()->id();
        $appointment->doctor_id = $request->doctor_id;
        $appointment->fecha = $request->fecha;
        $appointment->hora = $request->hora;
        $appointment->motivo = $request->motivo;
        $appointment->estado = 'pendiente';
        $appointment->save();

        return redirect()->route('patients.appointments.index')
            ->with('success', 'Cita programada exitosamente.');
    }

    public function cancelAppointment(Appointment $cita)
    {
        // Verificar que la cita pertenece al paciente autenticado
        if ($cita->patient_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para cancelar esta cita'
            ], 403);
        }

        // Verificar que la cita no esté ya cancelada o completada
        if ($cita->estado === 'cancelada' || $cita->estado === 'completada') {
            return response()->json([
                'success' => false,
                'message' => 'No se puede cancelar una cita que ya está ' . $cita->estado
            ], 400);
        }

        // Verificar que la cita no sea del pasado
        if ($cita->fecha < now()->format('Y-m-d')) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede cancelar una cita pasada'
            ], 400);
        }

        $cita->estado = 'cancelada';
        $cita->save();

        return response()->json([
            'success' => true,
            'message' => 'Cita cancelada exitosamente'
        ]);
    }
}
