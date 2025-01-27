@extends('layouts.master')

@section('title', 'Crear Notificación')

@section('content')
    <h1>Crear Notificación</h1>
    <form action="{{ route('notificaciones.store') }}" method="POST">
        @csrf
        <label for="user_id">User:</label>
        <select name="user_id" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select><br>
        <label for="type">Type:</label>
        <input type="text" name="type" required><br>
        <label for="message">Message:</label>
        <textarea name="message" required></textarea><br>
        <label for="read_at">Read At:</label>
        <input type="date" name="read_at"><br>
        <button type="submit">Create</button>
    </form>
@endsection
