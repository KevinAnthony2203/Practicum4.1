@extends('layouts.master')

@section('title', 'Notificaciones')

@section('content')
    <h1>Notificaciones</h1>
    <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Crear Nuevo Paciente</a>
    <table class="table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Tipo</th>
                <th>Mensaje</th>
                <th>Leído el</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notificaciones as $notificacion)
                <tr>
                    <td>{{ $notificacion->user->name }}</td>
                    <td>{{ $notificacion->type }}</td>
                    <td>{{ $notificacion->message }}</td>
                    <td>{{ $notificacion->read_at }}</td>
                    <td>
                        <a href="{{ route('notificaciones.show', $notificacion->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('notificaciones.edit', $notificacion->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('notificaciones.destroy', $notificacion->id) }}" method="POST" style="display:inline;">
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
