<!DOCTYPE html>
<html>
<head>
    <title>Disponibilidad Details</title>
</head>
<body>
    <h1>Disponibilidad Details</h1>
    <p><strong>Doctor:</strong> {{ $disponibilidad->doctor->name }} {{ $disponibilidad->doctor->last_name }}</p>
    <p><strong>Date:</strong> {{ $disponibilidad->date }}</p>
    <p><strong>Start Time:</strong> {{ $disponibilidad->start_time }}</p>
    <p><strong>End Time:</strong> {{ $disponibilidad->end_time }}</p>
    <a href="{{ route('disponibilidades.index') }}">Back to List</a>
</body>
</html>
