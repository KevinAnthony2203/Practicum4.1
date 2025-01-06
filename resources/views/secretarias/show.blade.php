<!DOCTYPE html>
<html>
<head>
    <title>Secretaria Details</title>
</head>
<body>
    <h1>Secretaria Details</h1>
    <p><strong>Name:</strong> {{ $secretaria->name }}</p>
    <p><strong>Last Name:</strong> {{ $secretaria->last_name }}</p>
    <a href="{{ route('secretarias.index') }}">Back to List</a>
</body>
</html>