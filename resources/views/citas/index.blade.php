<!DOCTYPE html>
<html>
<head>
    <title>Citas</title>
</head>
<body>
    <h1>Citas</h1>
    <a href="{{ route('citas.create') }}">Create New Cita</a>
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
                <tr>
                    <td>{{ $cita->patient->name }} {{ $cita->patient->last_name }}</td>
                    <td>{{ $cita->doctor->name }} {{ $cita->doctor->last_name }}</td>
                    <td>{{ $cita->date }}</td>
                    <td>{{ $cita->time }}</td>
                    <td>{{ $cita->status }}</td>
                    <td>
                        <a href="{{ route('citas.show', $cita->id) }}">View</a>
                        <a href="{{ route('citas.edit', $cita->id) }}">Edit</a>
                        <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" style="display:inline;">
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