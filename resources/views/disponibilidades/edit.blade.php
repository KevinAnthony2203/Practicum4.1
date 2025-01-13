<!DOCTYPE html>
<html>
<head>
    <title>Edit Disponibilidad</title>
</head>
<body>
    <h1>Edit Disponibilidad</h1>
    <form action="{{ route('disponibilidades.update', $disponibilidad->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="doctor_id">Doctor:</label>
        <select name="doctor_id" required>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ $doctor->id == $disponibilidad->doctor_id ? 'selected' : '' }}>
                    {{ $doctor->name }} {{ $doctor->last_name }}
                </option>
            @endforeach
        </select><br>
        <label for="date">Date:</label>
        <input type="date" name="date" value="{{ $disponibilidad->date }}" required><br>
        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" value="{{ $disponibilidad->start_time }}" required><br>
        <label for="end_time">End Time:</label>
        <input type="time" name="end_time" value="{{ $disponibilidad->end_time }}" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
