<!DOCTYPE html>
<html>
<head>
    <title>Create Secretaria</title>
</head>
<body>
    <h1>Create Secretaria</h1>
    <form action="{{ route('secretarias.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br>
        <button type="submit">Create</button>
    </form>
</body>
</html>