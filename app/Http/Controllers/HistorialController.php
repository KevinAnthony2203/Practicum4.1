<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Doctor;

class HistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $paciente = $user->patient;

        $registros = Historial::where('patient_id', $paciente->id)
            ->with('doctor')
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        // Calcular estadísticas
        $estadisticas = [
            'consultas' => $registros->where('tipo', 'consulta')->count(),
            'examenes' => $registros->where('tipo', 'examen')->count(),
            'ultima_consulta' => $registros->where('tipo', 'consulta')->first()?->fecha
        ];

        return view('patients.historial', compact('registros', 'paciente', 'estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('historials.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);

        Historial::create($request->all());

        return redirect()->route('historials.index')
                        ->with('success', 'Historial created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Historial $historial)
    {
        return view('historials.show', compact('historial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Historial $historial)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('historials.edit', compact('historial', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Historial $historial)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);

        $historial->update($request->all());

        return redirect()->route('historials.index')
                        ->with('success', 'Historial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Historial $historial)
    {
        $historial->delete();

        return redirect()->route('historials.index')
                        ->with('success', 'Historial deleted successfully.');
    }
}
