@extends('layouts.master')

@section('title', 'Editar Secretaria')

@section('content')
    <h1>Editar Secretaria</h1>
    <form action="{{ route('secretarias.update', $secretaria->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name" value="{{ $secretaria->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="last_name">Apellido:</label>
            <input type="text" name="last_name" value="{{ $secretaria->last_name }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@endsection
