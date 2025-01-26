<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'age' => 'required|integer|min:0|max:150',
            'contacto' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients,email,' . $patient->id,
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')
                        ->with('success', 'Patient updated successfully.');
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
        return view('patient.dashboard');
    }
}
