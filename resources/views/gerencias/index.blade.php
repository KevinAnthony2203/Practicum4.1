@extends ('layouts.master')

<!DOCTYPE html>
<html>
<head>
    <title>Gerencias</title>
</head>
<body>
    <h2>Gerencias</h2>
    <a href="{{ route('gerencias.create') }}">Crear Nueva Gerencia</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Last Name</th>
                <th>Position</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gerencias as $gerencia)
                <tr>
                    <td>{{ $gerencia->name }}</td>
                    <td>{{ $gerencia->last_name }}</td>
                    <td>{{ $gerencia->position }}</td>
                    <td>
                        <a href="{{ route('gerencias.show', $gerencia->id) }}">View</a>
                        <a href="{{ route('gerencias.edit', $gerencia->id) }}">Edit</a>
                        <form action="{{ route('gerencias.destroy', $gerencia->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
