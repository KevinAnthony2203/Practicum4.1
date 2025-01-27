@extends('layouts.master')

@section('title', 'Detalles de la Secretaria')

@section('content')
    <h1>Detalles de la Secretaria</h1>
    <p><strong>Nombre:</strong> {{ $secretaria->name }}</p>
    <p><strong>Apellido:</strong> {{ $secretaria->last_name }}</p>
    <a href="{{ route('secretarias.index') }}" class="btn btn-secondary">Volver a la Lista</a>
@endsection
