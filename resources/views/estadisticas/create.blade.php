<!DOCTYPE html>
<html>
<head>
    <title>Create Estadística</title>
</head>
<body>
    <h1>Create Estadística</h1>
    <form action="{{ route('estadisticas.store') }}" method="POST">
        @csrf
        <label for="date">Date:</label>
        <input type="date" name="date" required><br>
        <label for="citas_programadas">Citas Programadas:</label>
        <input type="number" name="citas_programadas" required><br>
        <label for="citas_canceladas">Citas Canceladas:</label>
        <input type="number" name="citas_canceladas" required><br>
        <label for="citas_completadas">Citas Completadas:</label>
        <input type="number" name="citas_completadas" required><br>
        <button type="submit">Create</button>
    </form>
</body>
</html>