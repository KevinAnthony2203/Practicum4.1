@extends('layouts.master')

@section('title', 'Disponibilidades')

@section('content')
<h1>Disponibilidades</h1>
<a href="{{ route('disponibilidades.create') }}" class="btn btn-primary mb-3">Crea Nueva Disponibilidad</a>
<table class="table">
    <thead>
        <tr>
            <th>Doctor</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($disponibilidades as $disponibilidad)
            <tr>
                <td>{{ $disponibilidad->doctor->name }} {{ $disponibilidad->doctor->last_name }}</td>
                <td>{{ $disponibilidad->date }}</td>
                <td>{{ $disponibilidad->start_time }}</td>
                <td>{{ $disponibilidad->end_time }}</td>
                <td>
                    <a href="{{ route('disponibilidades.show', $disponibilidad->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('disponibilidades.edit', $disponibilidad->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('disponibilidades.destroy', $disponibilidad->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
