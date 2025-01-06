<!DOCTYPE html>
<html>
<head>
    <title>Recordatorio Details</title>
</head>
<body>
    <h1>Recordatorio Details</h1>
    <p><strong>User:</strong> {{ $recordatorio->user->name }}</p>
    <p><strong>Type:</strong> {{ $recordatorio->type }}</p>
    <p><strong>Message:</strong> {{ $recordatorio->message }}</p>
    <p><strong>Scheduled At:</strong> {{ $recordatorio->scheduled_at }}</p>
    <a href="{{ route('recordatorios.index') }}">Back to List</a>
</body>
</html>
