@extends('layouts.master')

@section('title', 'Crear Gerencia')

@section('content')
    <h1>Crear Gerencia</h1>
    <form action="{{ route('gerencias.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br>
        <label for="position">Position:</label>
        <input type="text" name="position" required><br>
        <button type="submit">Create</button>
    </form>
@endsection
