<!DOCTYPE html>
<html>
<head>
    <title>Edit Gerencia</title>
</head>
<body>
    <h1>Edit Gerencia</h1>
    <form action="{{ route('gerencias.update', $gerencia->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $gerencia->name }}" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="{{ $gerencia->last_name }}" required><br>
        <label for="position">Position:</label>
        <input type="text" name="position" value="{{ $gerencia->position }}" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
