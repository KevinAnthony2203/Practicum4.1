<?php

namespace App\Http\Controllers;

use App\Models\Disponibilidad;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DisponibilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disponibilidades = Disponibilidad::with('doctor')->get();
        return view('disponibilidades.index', compact('disponibilidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::all();
        return view('disponibilidades.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Disponibilidad::create($request->all());

        return redirect()->route('disponibilidades.index')
                        ->with('success', 'Disponibilidad created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disponibilidad $disponibilidad)
    {
        return view('disponibilidades.show', compact('disponibilidad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disponibilidad $disponibilidad)
    {
        $doctors = Doctor::all();
        return view('disponibilidades.edit', compact('disponibilidad', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disponibilidad $disponibilidad)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $disponibilidad->update($request->all());

        return redirect()->route('disponibilidades.index')
                        ->with('success', 'Disponibilidad updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disponibilidad $disponibilidad)
    {
        $disponibilidad->delete();

        return redirect()->route('disponibilidades.index')
                        ->with('success', 'Disponibilidad deleted successfully.');
    }
}
