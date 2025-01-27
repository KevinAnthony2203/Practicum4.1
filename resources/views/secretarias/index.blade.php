@extends('layouts.master')

@section('title', 'Secretarías')

@section('content')
    <h1>Secretarías</h1>
    <a href="{{ route('secretarias.create') }}" class="btn btn-primary mb-3">Crear Nueva Secretaria</a>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($secretarias as $secretaria)
                <tr>
                    <td>{{ $secretaria->name }}</td>
                    <td>{{ $secretaria->last_name }}</td>
                    <td>
                        <a href="{{ route('secretarias.show', $secretaria->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('secretarias.edit', $secretaria->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('secretarias.destroy', $secretaria->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
