<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Auth::user()->appointments()
            ->with(['doctor'])
            ->orderBy('fecha', 'asc')
            ->get();

        return view('patients.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::all();
        return view('patients.appointments.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'fecha' => 'required|date|after:today',
            'hora' => 'required',
            'motivo' => 'required|string|max:255',
        ]);

        $appointment = new Appointment();
        $appointment->patient_id = Auth::id();
        $appointment->doctor_id = $request->doctor_id;
        $appointment->fecha = $request->fecha;
        $appointment->hora = $request->hora;
        $appointment->motivo = $request->motivo;
        $appointment->estado = 'pendiente';
        $appointment->save();

        return redirect()->route('patients.appointments.index')
            ->with('success', 'Cita programada exitosamente.');
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }

        return view('patients.appointments.show', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }

        $appointment->delete();

        return redirect()->route('patients.appointments.index')
            ->with('success', 'Cita cancelada exitosamente.');
    }
}