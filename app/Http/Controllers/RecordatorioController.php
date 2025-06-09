<?php

namespace App\Http\Controllers;

use App\Models\Recordatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\NotificacionConfig;

class RecordatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patient = Auth::user()->patient;

        // Obtener todos los recordatorios del paciente
        $recordatorios = Recordatorio::where('patient_id', $patient->id)
            ->orderBy('fecha_hora', 'desc')
            ->paginate(10);

        // Obtener los próximos recordatorios
        $proximosRecordatorios = Recordatorio::where('patient_id', $patient->id)
            ->where('fecha_hora', '>=', now())
            ->where('estado', 'pendiente')
            ->orderBy('fecha_hora', 'asc')
            ->take(5)
            ->get();

        // Obtener o crear la configuración de notificaciones
        $config = $patient->notificacionConfig ?? (object)[
            'notificaciones_email' => true,
            'notificaciones_sms' => false,
            'tiempo_anticipacion' => 30
        ];

        return view('patients.recordatorios', compact('recordatorios', 'proximosRecordatorios', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'fecha_hora' => 'required|date',
            'tipo' => 'required|string|in:medicamento,cita,examen,otro'
        ]);

        $patient = Auth::user()->patient;

        $recordatorio = new Recordatorio([
            'patient_id' => $patient->id,
            'titulo' => $request->titulo,
            'descripcion' => $request->mensaje,
            'fecha_hora' => $request->fecha_hora,
            'tipo' => $request->tipo,
            'estado' => 'pendiente'
        ]);

        $recordatorio->save();

        return redirect()->route('patients.recordatorios.index')
                        ->with('success', 'Recordatorio creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recordatorio $recordatorio)
    {
        return response()->json([
            'titulo' => $recordatorio->titulo,
            'mensaje' => $recordatorio->descripcion,
            'fecha_hora' => $recordatorio->fecha_hora,
            'tipo' => $recordatorio->tipo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recordatorio $recordatorio)
    {
        $users = User::all();
        return view('recordatorios.edit', compact('recordatorio', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recordatorio $recordatorio)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'fecha_hora' => 'required|date',
            'tipo' => 'required|string|in:medicamento,cita,examen,otro'
        ]);

        $recordatorio->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->mensaje,
            'fecha_hora' => $request->fecha_hora,
            'tipo' => $request->tipo
        ]);

        return redirect()->route('patients.recordatorios.index')
                        ->with('success', 'Recordatorio actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recordatorio $recordatorio)
    {
        $recordatorio->delete();

        return redirect()->route('recordatorios.index')
                        ->with('success', 'Recordatorio deleted successfully.');
    }

    /**
     * Actualiza la configuración de notificaciones del paciente
     */
    public function updateConfig(Request $request)
    {
        $patient = Auth::user()->patient;

        $config = $patient->notificacionConfig ?? new NotificacionConfig(['patient_id' => $patient->id]);

        $config->fill([
            'notificaciones_email' => $request->has('notificaciones_email'),
            'notificaciones_sms' => $request->has('notificaciones_sms'),
            'tiempo_anticipacion' => $request->input('tiempo_anticipacion', 30)
        ]);

        $config->save();

        return redirect()->route('patients.recordatorios.index')
                        ->with('success', 'Configuración actualizada correctamente');
    }
}
