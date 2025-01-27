@extends('layouts.master')

@section('title', 'Detalles del Recordatorio')

@section('content')
    <h1>Detalles del Recordatorio</h1>
    <p><strong>Usuario:</strong> {{ $recordatorio->user->name }}</p>
    <p><strong>Tipo:</strong> {{ $recordatorio->type }}</p>
    <p><strong>Mensaje:</strong> {{ $recordatorio->message }}</p>
    <p><strong>Programado para:</strong> {{ \Carbon\Carbon::parse($recordatorio->scheduled_at)->format('Y-m-d H:i') }}</p>
    <a href="{{ route('recordatorios.index') }}" class="btn btn-secondary">Volver a la Lista</a>
@endsection
