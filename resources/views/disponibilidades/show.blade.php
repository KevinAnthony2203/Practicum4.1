@extends('layouts.master')

@section('title', 'Detalles de la Disponibilidad')

@section('content')
    <h1>Detalles de la Disponibilidad</h1>
    <p><strong>Doctor:</strong> {{ $disponibilidad->doctor->name }} {{ $disponibilidad->doctor->last_name }}</p>
    <p><strong>Date:</strong> {{ $disponibilidad->date }}</p>
    <p><strong>Start Time:</strong> {{ $disponibilidad->start_time }}</p>
    <p><strong>End Time:</strong> {{ $disponibilidad->end_time }}</p>
    <a href="{{ route('disponibilidades.index') }}">Back to List</a>
@endsection
