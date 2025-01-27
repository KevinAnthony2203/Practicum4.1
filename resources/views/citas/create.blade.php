@extends('layouts.master')

@section('title', 'Crear Cita')

@section('content')
    <h1>Crea Cita</h1>
    <form action="{{ route('citas.store') }}" method="POST">
        @csrf
        <label for="patient_id">Patient:</label>
        <select name="patient_id" required>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}">{{ $patient->name }} {{ $patient->last_name }}</option>
            @endforeach
        </select><br>
        <label for="doctor_id">Doctor:</label>
        <select name="doctor_id" required>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->name }} {{ $doctor->last_name }}</option>
            @endforeach
        </select><br>
        <label for="date">Date:</label>
        <input type="date" name="date" required><br>
        <label for="time">Time:</label>
        <input type="time" name="time" required><br>
        <label for="status">Status:</label>
        <input type="text" name="status" required><br>
        <button type="submit">Create</button>
    </form>
@endsection
