<!DOCTYPE html>
<html>
<head>
    <title>Gerencia Details</title>
</head>
<body>
    <h1>Gerencia Details</h1>
    <p><strong>Name:</strong> {{ $gerencia->name }}</p>
    <p><strong>Last Name:</strong> {{ $gerencia->last_name }}</p>
    <p><strong>Position:</strong> {{ $gerencia->position }}</p>
    <a href="{{ route('gerencias.index') }}">Back to List</a>
</body>
</html>
