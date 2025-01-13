<!DOCTYPE html>
<html>
<head>
    <title>Edit Estadística</title>
</head>
<body>
    <h1>Edit Estadística</h1>
    <form action="{{ route('estadisticas.update', $estadistica->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="date">Date:</label>
        <input type="date" name="date" value="{{ $estadistica->date }}" required><br>
        <label for="citas_programadas">Citas Programadas:</label>
        <input type="number" name="citas_programadas" value="{{ $estadistica->citas_programadas }}" required><br>
        <label for="citas_canceladas">Citas Canceladas:</label>
        <input type="number" name="citas_canceladas" value="{{ $estadistica->citas_canceladas }}" required><br>
        <label for="citas_completadas">Citas Completadas:</label>
        <input type="number" name="citas_completadas" value="{{ $estadistica->citas_completadas }}" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
