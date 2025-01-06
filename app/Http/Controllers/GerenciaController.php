<?php

namespace App\Http\Controllers;

use App\Models\Gerencia;
use Illuminate\Http\Request;

class GerenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gerencias = Gerencia::all();
        return view('gerencias.index', compact('gerencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gerencias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        Gerencia::create($request->all());

        return redirect()->route('gerencias.index')
                        ->with('success', 'Gerencia created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gerencia $gerencia)
    {
        return view('gerencias.show', compact('gerencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gerencia $gerencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gerencia $gerencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gerencia $gerencia)
    {
        //
    }
}
