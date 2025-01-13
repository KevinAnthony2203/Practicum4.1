<!DOCTYPE html>
<html>
<head>
    <title>Create Patient</title>
</head>
<body>
    <h1>Create Patient</h1>
    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br>
        <label for="birth_date">Birth Date:</label>
        <input type="date" name="birth_date" required><br>
        <label for="age">Edad:</label>
        <input type="int" name="age" required><br>
        <label for="contacto">Contacto:</label>
        <input type="text" name="contacto" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <button type="submit">Create</button>
    </form>
</body>
</html>