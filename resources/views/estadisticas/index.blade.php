<!DOCTYPE html>
<html>
<head>
    <title>Estadísticas</title>
</head>
<body>
    <h1>Estadísticas</h1>
    <a href="{{ route('estadisticas.create') }}">Create New Estadística</a>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Citas Programadas</th>
                <th>Citas Canceladas</th>
                <th>Citas Completadas</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estadisticas as $estadistica)
                <tr>
                    <td>{{ $estadistica->date }}</td>
                    <td>{{ $estadistica->citas_programadas }}</td>
                    <td>{{ $estadistica->citas_canceladas }}</td>
                    <td>{{ $estadistica->citas_completadas }}</td>
                    <td>
                        <a href="{{ route('estadisticas.show', $estadistica->id) }}">View</a>
                        <a href="{{ route('estadisticas.edit', $estadistica->id) }}">Edit</a>
                        <form action="{{ route('estadisticas.destroy', $estadistica->id) }}" method="POST" style="display:inline;">
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
