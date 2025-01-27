@extends('layouts.master')

@section('title', 'Editar Recordatorio')

@section('content')
    <h1>Editar Recordatorio</h1>
    <form action="{{ route('recordatorios.update', $recordatorio->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="user_id">User:</label>
        <select name="user_id" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $user->id == $recordatorio->user_id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select><br>
        <label for="type">Type:</label>
        <input type="text" name="type" value="{{ $recordatorio->type }}" required><br>
        <label for="message">Message:</label>
        <textarea name="message" required>{{ $recordatorio->message }}</textarea><br>
        <label for="scheduled_at">Scheduled At:</label>
        <input type="datetime-local" name="scheduled_at" value="{{ $recordatorio->scheduled_at }}" required><br>
        <button type="submit">Update</button>
    </form>
@endsection
