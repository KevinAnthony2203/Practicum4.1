@extends('layouts.master')

@section('title', 'Gerencias')

@section('content')
    <h1>Gerencias</h1>
    <a href="{{ route('gerencias.create') }}" class="btn btn-primary mb-3">Crear Nueva Gerencia</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Posicion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gerencias as $gerencia)
                <tr>
                    <td>{{ $gerencia->name }}</td>
                    <td>{{ $gerencia->last_name }}</td>
                    <td>{{ $gerencia->position }}</td>
                    <td>
                        <a href="{{ route('gerencias.show', $gerencia->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('gerencias.edit', $gerencia->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('gerencias.destroy', $gerencia->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
