@extends('layouts.master')

@section('title', 'Editar Paciente')

@section('content')
<h1>Editar Paciente</h1>
<form action="{{ route('patients.update', $patient->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="name">Nombre:</label>
    <input type="text" name="name" value="{{ $patient->name }}" required><br>
    <label for="last_name">Apellido:</label>
    <input type="text" name="last_name" value="{{ $patient->last_name }}" required><br>
    <label for="birth_date">Fecha de Nacimiento:</label>
    <input type="date" name="birth_date" value="{{ $patient->birth_date }}" required><br>
    <label for="age">Edad:</label>
    <input type="number" name="age" value="{{ $patient->age }}" required><br>
    <label for="contacto">Contacto:</label>
    <input type="text" name="contacto" value="{{ $patient->contacto }}" required><br>
    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ $patient->email }}" required><br>
    <button type="submit">Actualizar</button>
</form>
@endsection
