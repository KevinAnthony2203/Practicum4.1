<!DOCTYPE html>
<html>
<head>
    <title>Edit Patient</title>
</head>
<body>
    <h1>Edit Patient</h1>
    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $patient->name }}" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="{{ $patient->last_name }}" required><br>
        <label for="birth_date">Birth Date:</label>
        <input type="date" name="birth_date" value="{{ $patient->birth_date }}" required><br>
        <label for="age">Edad:</label>
        <input type="int" name="age" value="{{ $patient->edad }}" required><br>
        <label for="contacto">Contacto:</label>
        <input type="text" name="contacto" value="{{ $patient->contacto }}" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ $patient->email }}" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>