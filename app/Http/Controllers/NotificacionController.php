<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

use App\Models\User;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notificaciones = Notificacion::with('user')->get();
        return view('notificaciones.index', compact('notificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('notificaciones.create', compact('users'));
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
            'read_at' => 'nullable|date'
        ]);

        Notificacion::create($request->all());

        return redirect()->route('notificaciones.index')
                        ->with('success', 'Notificación created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notificacion $notificacion)
    {
        return view('notificaciones.show', compact('notificacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notificacion $notificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notificacion $notificacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notificacion $notificacion)
    {
        //
    }
}
