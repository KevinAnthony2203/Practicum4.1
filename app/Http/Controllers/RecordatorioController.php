<?php

namespace App\Http\Controllers;

use App\Models\Recordatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RecordatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recordatorios = Recordatorio::where('patient_id', Auth::id())->get();
        return view('patients.recordatorios', compact('recordatorios'));
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
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'message' => 'required|string',
            'scheduled_at' => 'required|date'
        ]);

        Recordatorio::create($request->all());

        return redirect()->route('recordatorios.index')
                        ->with('success', 'Recordatorio created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recordatorio $recordatorio)
    {
        return view('recordatorios.show', compact('recordatorio'));
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
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'message' => 'required|string',
            'scheduled_at' => 'required|date'
        ]);

        $recordatorio->update($request->all());

        return redirect()->route('recordatorios.index')
                        ->with('success', 'Recordatorio updated successfully.');
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
}
