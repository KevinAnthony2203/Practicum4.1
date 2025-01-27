@extends('layouts.master')

@section('title', 'Pacientes')

@section('content')
<h1>Pacientes</h1>
<a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Crear Nuevo Paciente</a>
<table class="table">
    <thead>
        <tr>
            <th>Identificación</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha de Nacimiento</th>
            <th>Edad</th>
            <th>Contacto</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->last_name }}</td>
                <td>{{ $patient->birth_date }}</td>
                <td>{{ $patient->age }}</td>
                <td>{{ $patient->contacto }}</td>
                <td>{{ $patient->email }}</td>
                <td>
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
