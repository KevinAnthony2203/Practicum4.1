@extends('layouts.master')

@section('title', 'Detalles del Paciente')

@section('content')
<h1>Detalles del Paciente</h1>
<p><strong>Nombre:</strong> {{ $patient->name }}</p>
<p><strong>Apellido:</strong> {{ $patient->last_name }}</p>
<p><strong>Fecha de Nacimiento:</strong> {{ $patient->birth_date }}</p>
<p><strong>Edad:</strong> {{ $patient->age }}</p>
<p><strong>Contacto:</strong> {{ $patient->contacto }}</p>
<p><strong>Email:</strong> {{ $patient->email }}</p>
<a href="{{ route('patients.index') }}">Volver a la Lista</a>
@endsection
