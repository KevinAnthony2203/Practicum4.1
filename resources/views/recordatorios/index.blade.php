<!DOCTYPE html>
<html>
<head>
    <title>Recordatorios</title>
</head>
<body>
    <h1>Recordatorios</h1>
    <a href="{{ route('recordatorios.create') }}">Create New Recordatorio</a>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Type</th>
                <th>Message</th>
                <th>Scheduled At</th>
                <th>Actions</th>
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
                        <a href="{{ route('recordatorios.show', $recordatorio->id) }}">View</a>
                        <a href="{{ route('recordatorios.edit', $recordatorio->id) }}">Edit</a>
                        <form action="{{ route('recordatorios.destroy', $recordatorio->id) }}" method="POST" style="display:inline;">
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
