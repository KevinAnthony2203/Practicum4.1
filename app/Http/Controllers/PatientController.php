<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'age' => 'required|interger|min:0',
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
        return view('patient.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patient.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $request ->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'age' => 'required|interger|min:0',
            'contacto' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients' . $patient->id,
        ]);
        $patient->update($request->all());

        return redirect()->route('patients.index')
                        ->with('success', 'Patient created successfully.');

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')
                        ->with('success', 'Patient delete successfully.');

    }
}
