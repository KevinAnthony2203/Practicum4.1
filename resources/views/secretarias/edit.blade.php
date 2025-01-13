<!DOCTYPE html>
<html>
<head>
    <title>Edit Secretaria</title>
</head>
<body>
    <h1>Edit Secretaria</h1>
    <form action="{{ route('secretarias.update', $secretaria->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $secretaria->name }}" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="{{ $secretaria->last_name }}" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
