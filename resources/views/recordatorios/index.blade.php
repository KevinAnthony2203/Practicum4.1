@extends('layouts.master')

@section('title', 'Recordatorios')

@section('content')
<h1>Recordatorios</h1>
<table class="table">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Tipo</th>
            <th>Mensaje</th>
            <th>Programado para</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recordatorios as $recordatorio)
            <tr>
                <td>{{ $recordatorio->user->name }}</td>
                <td>{{ $recordatorio->type }}</td>
                <td>{{ $recordatorio->message }}</td>
                <td>{{ $recordatorio->scheduled_at }}</td>
                <td>
                    <a href="{{ route('recordatorios.show', $recordatorio->id) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('recordatorios.edit', $recordatorio->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('recordatorios.destroy', $recordatorio->id) }}" method="POST" style="display:inline;">
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
