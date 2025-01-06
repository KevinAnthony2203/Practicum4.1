<!DOCTYPE html>
<html>
<head>
    <title>Cita Details</title>
</head>
<body>
    <h1>Cita Details</h1>
    <p><strong>Patient:</strong> {{ $cita->patient->name }} {{ $cita->patient->last_name }}</p>
    <p><strong>Doctor:</strong> {{ $cita->doctor->name }} {{ $cita->doctor->last_name }}</p>
    <p><strong>Date:</strong> {{ $cita->date }}</p>
    <p><strong>Time:</strong> {{ $cita->time }}</p>
    <p><strong>Status:</strong> {{ $cita->status }}</p>
    <a href="{{ route('citas.index') }}">Back to List</a>
</body>
</html>