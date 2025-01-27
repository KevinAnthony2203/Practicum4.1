@extends('layouts.master')

@section('title', 'Detalles de la Gerencia')

@section('content')
    <h1>Detalles de la Gerencia</h1>
    <p><strong>Name:</strong> {{ $gerencia->name }}</p>
    <p><strong>Last Name:</strong> {{ $gerencia->last_name }}</p>
    <p><strong>Position:</strong> {{ $gerencia->position }}</p>
    <a href="{{ route('gerencias.index') }}">Back to List</a>
@endsection
