@extends('layouts.master')

@section('title', 'Detalles del Historial')

@section('content')
    <h1>Detalles del Historial</h1>
    <p><strong>Patient:</strong> {{ $historial->patient->name }} {{ $historial->patient->last_name }}</p>
    <p><strong>Doctor:</strong> {{ $historial->doctor->name }} {{ $historial->doctor->last_name }}</p>
    <p><strong>Date:</strong> {{ $historial->date }}</p>
    <p><strong>Description:</strong> {{ $historial->description }}</p>
    <a href="{{ route('historials.index') }}">Back to List</a>
@endsection
