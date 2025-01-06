<!DOCTYPE html>
<html>
<head>
    <title>Create Gerencia</title>
</head>
<body>
    <h1>Create Gerencia</h1>
    <form action="{{ route('gerencias.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br>
        <label for="position">Position:</label>
        <input type="text" name="position" required><br>
        <button type="submit">Create</button>
    </form>
</body>
</html>
