<?php

namespace App\Http\Controllers;

use App\Models\Estadistica;
use Illuminate\Http\Request;

class EstadisticaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estadisticas = Estadistica::all();
        return view('estadisticas.index', compact('estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estadisticas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'citas_programadas' => 'required|integer',
            'citas_canceladas' => 'required|integer',
            'citas_completadas' => 'required|integer',
        ]);

        Estadistica::create($request->all());

        return redirect()->route('estadisticas.index')
                        ->with('success', 'Estadística created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estadistica $estadistica)
    {
        return view('estadisticas.show', compact('estadistica'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estadistica $estadistica)
    {
        return view('estadisticas.edit', compact('estadistica'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estadistica $estadistica)
    {
        $request->validate([
            'date' => 'required|date',
            'citas_programadas' => 'required|integer',
            'citas_canceladas' => 'required|integer',
            'citas_completadas' => 'required|integer',
        ]);

        $estadistica->update($request->all());

        return redirect()->route('estadisticas.index')
                        ->with('success', 'Estadística updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estadistica $estadistica)
    {
        $estadistica->delete();

        return redirect()->route('estadisticas.index')
                        ->with('success', 'Estadística deleted successfully.');
    }
}
