<!DOCTYPE html>
<html>
<head>
    <title>Historial Details</title>
</head>
<body>
    <h1>Historial Details</h1>
    <p><strong>Patient:</strong> {{ $historial->patient->name }} {{ $historial->patient->last_name }}</p>
    <p><strong>Doctor:</strong> {{ $historial->doctor->name }} {{ $historial->doctor->last_name }}</p>
    <p><strong>Date:</strong> {{ $historial->date }}</p>
    <p><strong>Description:</strong> {{ $historial->description }}</p>
    <a href="{{ route('historials.index') }}">Back to List</a>
</body>
</html>