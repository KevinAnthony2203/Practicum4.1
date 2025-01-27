@extends('layouts.master')

@section('title', 'Detalles de la Notificación')

@section('content')
    <h1>Detalles de la Notificación</h1>
    <p><strong>User:</strong> {{ $notificacion->user->name }}</p>
    <p><strong>Type:</strong> {{ $notificacion->type }}</p>
    <p><strong>Message:</strong> {{ $notificacion->message }}</p>
    <p><strong>Read At:</strong> {{ $notificacion->read_at }}</p>
    <a href="{{ route('notificaciones.index') }}">Back to List</a>
@endsection
