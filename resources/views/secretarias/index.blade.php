<!DOCTYPE html>
<html>
<head>
    <title>Secretarias</title>
</head>
<body>
    <h1>Secretarias</h1>
    <a href="{{ route('secretarias.create') }}">Create New Secretaria</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Last Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($secretarias as $secretaria)
                <tr>
                    <td>{{ $secretaria->name }}</td>
                    <td>{{ $secretaria->last_name }}</td>
                    <td>
                        <a href="{{ route('secretarias.show', $secretaria->id) }}">View</a>
                        <a href="{{ route('secretarias.edit', $secretaria->id) }}">Edit</a>
                        <form action="{{ route('secretarias.destroy', $secretaria->id) }}" method="POST" style="display:inline;">
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