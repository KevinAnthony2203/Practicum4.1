@extends('layouts.master')

@section('title', 'Detalles de la Estadística')

@section('content')
    <h1>Detalles de la Estadística</h1>
    <p><strong>Date:</strong> {{ $estadistica->date }}</p>
    <p><strong>Citas Programadas:</strong> {{ $estadistica->citas_programadas }}</p>
    <p><strong>Citas Canceladas:</strong> {{ $estadistica->citas_canceladas }}</p>
    <p><strong>Citas Completadas:</strong> {{ $estadistica->citas_completadas }}</p>
    <a href="{{ route('estadisticas.index') }}">Back to List</a>
@endsection
