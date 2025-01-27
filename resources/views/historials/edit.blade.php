@extends('layouts.master')

@section('title', 'Editar Historial')

@section('content')
    <h1>Editar Historial</h1>
    <form action="{{ route('historials.update', $historial->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="patient_id">Patient:</label>
        <select name="patient_id" required>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}" {{ $patient->id == $historial->patient_id ? 'selected' : '' }}>
                    {{ $patient->name }} {{ $patient->last_name }}
                </option>
            @endforeach
        </select><br>
        <label for="doctor_id">Doctor:</label>
        <select name="doctor_id" required>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ $doctor->id == $historial->doctor_id ? 'selected' : '' }}>
                    {{ $doctor->name }} {{ $doctor->last_name }}
                </option>
            @endforeach
        </select><br>
        <label for="date">Date:</label>
        <input type="date" name="date" value="{{ $historial->date }}" required><br>
        <label for="description">Description:</label>
        <textarea name="description" required>{{ $historial->description }}</textarea><br>
        <button type="submit">Update</button>
    </form>
@endsection
