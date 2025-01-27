@extends('layouts.master')

@section('title', 'Detalle Cita')

@section('content')
    <h1>Detalle Cita</h1>
    <p><strong>Patient:</strong> {{ $cita->patient->name }} {{ $cita->patient->last_name }}</p>
    <p><strong>Doctor:</strong> {{ $cita->doctor->name }} {{ $cita->doctor->last_name }}</p>
    <p><strong>Date:</strong> {{ $cita->date }}</p>
    <p><strong>Time:</strong> {{ $cita->time }}</p>
    <p><strong>Status:</strong> {{ $cita->status }}</p>
    <a href="{{ route('citas.index') }}">Back to List</a>
</body>
@endsection
