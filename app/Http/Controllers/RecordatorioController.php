<?php

namespace App\Http\Controllers;

use App\Models\Recordatorio;
use Illuminate\Http\Request;

use App\Models\User;

class RecordatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recordatorios = Recordatorio::with('user')->get();
        return view('recordatorios.index', compact('recordatorios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('recordatorios.create', compact('users'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recordatorio $recordatorio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recordatorio $recordatorio)
    {
        //
    }
}
