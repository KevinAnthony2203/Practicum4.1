@extends('layouts.master')

@section('title', 'Crear Disponibilidad')

@section('content')
    <h1>Create Disponibilidad</h1>
    <form action="{{ route('disponibilidades.store') }}" method="POST">
        @csrf
        <label for="doctor_id">Doctor:</label>
        <select name="doctor_id" required>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->name }} {{ $doctor->last_name }}</option>
            @endforeach
        </select><br>
        <label for="date">Date:</label>
        <input type="date" name="date" required><br>
        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" required><br>
        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" required><br>
        <button type="submit">Create</button>
    </form>
@endsection
