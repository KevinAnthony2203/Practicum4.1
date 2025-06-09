<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Cita::where('patient_id', Auth::id())->get();
        return view('patients.citas', compact('citas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $doctors = User::role('Doctor')->get();
        $patients = User::role('Patient')->get();
        return view('citas.create', compact('doctors', 'patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'fecha' => 'required|date|after:today',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string|max:255',
        ]);

        $cita = new Cita();
        $cita->patient_id = $request->patient_id;
        $cita->doctor_id = $request->doctor_id;
        $cita->fecha_hora = $request->fecha . ' ' . $request->hora;
        $cita->motivo = $request->motivo;
        $cita->estado = 'pendiente';
        $cita->save();

        return redirect()->route('secretaria.dashboard')
            ->with('success', 'Cita programada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cita $cita)
    {
        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cita $cita)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('citas.edit', compact('cita', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|string',
        ]);

        $cita->update($request->all());

        return redirect()->route('citas.index')
                        ->with('success', 'Cita updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cita $cita)
    {
        $cita->delete();

        return redirect()->route('citas.index')
                        ->with('success', 'Cita deleted successfully.');
    }

    public function getDisponibilidad($doctorId, $fecha)
    {
        // Obtener la disponibilidad del doctor para ese día
        $disponibilidad = \App\Models\Disponibilidad::where('doctor_id', $doctorId)
            ->whereDate('date', $fecha)
            ->first();

        if (!$disponibilidad) {
            return response()->json([]);
        }

        // Obtener la duración de cita y tiempo entre citas del doctor
        $doctor = \App\Models\Doctor::find($doctorId);
        $duracionCita = $doctor->duracion_cita ?? 30; // duración por defecto: 30 minutos
        $tiempoEntreCitas = $doctor->tiempo_entre_citas ?? 10; // tiempo entre citas por defecto: 10 minutos

        $horaInicio = substr($disponibilidad->start_time, 0, 5);
        $horaFin = substr($disponibilidad->end_time, 0, 5);

        // Obtener citas existentes para ese doctor y fecha
        $citasExistentes = Cita::where('doctor_id', $doctorId)
            ->whereDate('fecha_hora', $fecha)
            ->where('estado', '!=', 'cancelada')
            ->pluck('fecha_hora')
            ->map(function($fechaHora) {
                return substr($fechaHora, 11, 5); // Formato HH:mm
            })
            ->toArray();

        $horasDisponibles = [];
        $tiempo = strtotime($horaInicio);
        $tiempoFin = strtotime($horaFin);

        // Generar horas disponibles según la duración de la cita y el tiempo entre citas
        while ($tiempo < $tiempoFin) {
            $horaActual = date('H:i', $tiempo);

            // Verificar si hay alguna cita que se solape con este horario
            $estaDisponible = true;
            foreach ($citasExistentes as $citaExistente) {
                $inicioCita = strtotime($citaExistente);
                $finCita = strtotime("+$duracionCita minutes", $inicioCita);

                if ($tiempo >= $inicioCita && $tiempo < $finCita) {
                    $estaDisponible = false;
                    break;
                }
            }

            if ($estaDisponible) {
                $horasDisponibles[] = $horaActual;
            }

            // Avanzar al siguiente slot considerando la duración de la cita y el tiempo entre citas
            $tiempo = strtotime("+".($duracionCita + $tiempoEntreCitas)." minutes", $tiempo);
        }

        return response()->json($horasDisponibles);
    }

    public function getEventos(): JsonResponse
    {
        $citas = Cita::with(['paciente', 'doctor'])
            ->get()
            ->map(function($cita) {
                return [
                    'id' => $cita->id,
                    'title' => "Cita con: " . $cita->paciente->name,
                    'start' => $cita->fecha_hora,
                    'end' => \Carbon\Carbon::parse($cita->fecha_hora)->addMinutes(30)->format('Y-m-d H:i:s'),
                    'color' => $this->getStatusColor($cita->estado),
                    'extendedProps' => [
                        'estado' => $cita->estado,
                        'paciente' => $cita->paciente->name,
                        'doctor' => $cita->doctor->name,
                        'motivo' => $cita->motivo ?? 'No especificado',
                        'notas' => $cita->notas ?? 'Sin notas'
                    ]
                ];
            });

        return response()->json($citas);
    }

    private function getStatusColor($estado)
    {
        return match($estado) {
            'pendiente' => '#ffc107',   // amarillo
            'confirmada' => '#28a745',  // verde
            'cancelada' => '#dc3545',   // rojo
            'completada' => '#17a2b8',  // azul
            default => '#6c757d'        // gris
        };
    }
}
