<!DOCTYPE html>
<html>
<head>
    <title>Patient Details</title>
</head>
<body>
    <h1>Patient Details</h1>
    <p><strong>Name:</strong> {{ $patient->name }}</p>
    <p><strong>Last Name:</strong> {{ $patient->last_name }}</p>
    <p><strong>Birth Date:</strong> {{ $patient->birth_date }}</p>
    <p><strong>Edad:</strong> {{ $patient->edad }}</p>
    <p><strong>Contacto:</strong> {{ $patient->contacto }}</p>
    <p><strong>Email:</strong> {{ $patient->email }}</p>
    <a href="{{ route('patients.index') }}">Back to List</a>
</body>
</html>