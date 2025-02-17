@extends('layouts.master')

@section('title', 'Historiales')

@section('content')
    <h1>Historiales</h1>
    <a href="{{ route('historials.create') }}">Create New Historial</a>
    <table>
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Doctor</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historials as $historial)
                <tr>
                    <td>{{ $historial->patient->name }} {{ $historial->patient->last_name }}</td>
                    <td>{{ $historial->doctor->name }} {{ $historial->doctor->last_name }}</td>
                    <td>{{ $historial->date }}</td>
                    <td>{{ $historial->description }}</td>
                    <td>
                        <a href="{{ route('historials.show', $historial->id) }}">View</a>
                        <a href="{{ route('historials.edit', $historial->id) }}">Edit</a>
                        <form action="{{ route('historials.destroy', $historial->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
