<!DOCTYPE html>
<html>
<head>
    <title>Notificaciones</title>
</head>
<body>
    <h1>Notificaciones</h1>
    <a href="{{ route('notificaciones.create') }}">Crea Nueva Notificación</a>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Type</th>
                <th>Message</th>
                <th>Read At</th>
                <th>Actions</th>
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
                        <a href="{{ route('notificaciones.show', $notificacion->id) }}">View</a>
                        <a href="{{ route('notificaciones.edit', $notificacion->id) }}">Edit</a>
                        <form action="{{ route('notificaciones.destroy', $notificacion->id) }}" method="POST" style="display:inline;">
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
