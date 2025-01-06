<!DOCTYPE html>
<html>
<head>
    <title>Create Doctor</title>
</head>
<body>
    <h1>Create Doctor</h1>
    <form action="{{ route('doctors.store') }}" method="POST">
        @csrf
        <label for="id">Id:</label>
        <input type="text" name="id" required><br>
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br>
        <label for="specialty">Specialty:</label>
        <input type="text" name="specialty" required><br>
    </form>
</body>
</html>