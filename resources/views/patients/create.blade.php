@extends('layouts.master')

@section('title', 'Crear Paciente')

@section('content')
<h1>Crear Paciente</h1>
<form action="{{ route('patients.store') }}" method="POST">
    @csrf
    <label for="name">Nombre:</label>
    <input type="text" name="name" required><br>
    <label for="last_name">Apellido:</label>
    <input type="text" name="last_name" required><br>
    <label for="birth_date">Fecha de Nacimiento:</label>
    <input type="date" name="birth_date" required><br>
    <label for="age">Edad:</label>
    <input type="number" name="age" required><br>
    <label for="contacto">Contacto:</label>
    <input type="text" name="contacto" required><br>
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>
    <button type="submit">Crear</button>
</form>
@endsection
