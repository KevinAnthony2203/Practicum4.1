<!DOCTYPE html>
<html>
<head>
    <title>Doctor Details</title>
</head>
<body>
    <h1>Doctor Details</h1>
    <p><strong>Id:</strong> {{ $doctor->id }}</p>
    <p><strong>Name:</strong> {{ $doctor->name }}</p>
    <p><strong>Last Name:</strong> {{ $doctor->last_name }}</p>
    <p><strong>Specialty:</strong> {{ $doctor->specialty }}</p>
    <a href="{{ route('doctors.index') }}">Back to List</a>
</body>
</html>