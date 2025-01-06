<!DOCTYPE html>
<html>
<head>
    <title>Disponibilidades</title>
</head>
<body>
    <h1>Disponibilidades</h1>
    <a href="{{ route('disponibilidades.create') }}">Create New Disponibilidad</a>
    <table>
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($disponibilidades as $disponibilidad)
                <tr>
                    <td>{{ $disponibilidad->doctor->name }} {{ $disponibilidad->doctor->last_name }}</td>
                    <td>{{ $disponibilidad->date }}</td>
                    <td>{{ $disponibilidad->start_time }}</td>
                    <td>{{ $disponibilidad->end_time }}</td>
                    <td>
                        <a href="{{ route('disponibilidades.show', $disponibilidad->id) }}">View</a>
                        <a href="{{ route('disponibilidades.edit', $disponibilidad->id) }}">Edit</a>
                        <form action="{{ route('disponibilidades.destroy', $disponibilidad->id) }}" method="POST" style="display:inline;">
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
