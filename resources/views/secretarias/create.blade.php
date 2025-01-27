@extends('layouts.master')

@section('title', 'Crear Secretaria')

@section('content')
    <h1>Crear Secretaria</h1>
    <form action="{{ route('secretarias.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="last_name">Apellido:</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
@endsection
