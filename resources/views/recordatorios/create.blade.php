@extends('layouts.master')

@section('title', 'Crear Recordatorio')

@section('content')
    <h1>Crear Recordatorio</h1>
    <form action="{{ route('recordatorios.store') }}" method="POST">
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
        <label for="scheduled_at">Scheduled At:</label>
        <input type="datetime-local" name="scheduled_at" required><br>
        <button type="submit">Create</button>
    </form>
@endsection
