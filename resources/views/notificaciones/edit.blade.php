@extends('layouts.master')

@section('title', 'Editar Notificación')

@section('content')
    <h1>Editar Notificación</h1>
    <form action="{{ route('notificaciones.update', $notificacion->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="user_id">User:</label>
        <select name="user_id" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $user->id == $notificacion->user_id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select><br>
        <label for="type">Type:</label>
        <input type="text" name="type" value="{{ $notificacion->type }}" required><br>
        <label for="message">Message:</label>
        <textarea name="message" required>{{ $notificacion->message }}</textarea><br>
        <label for="read_at">Read At:</label>
        <input type="date" name="read_at" value="{{ $notificacion->read_at }}"><br>
        <button type="submit">Update</button>
    </form>
@endsection
