<!DOCTYPE html>
<html>
<head>
    <title>Edit Cita</title>
</head>
<body>
    <h1>Edit Cita</h1>
    <form action="{{ route('citas.update', $cita->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="patient_id">Patient:</label>
        <select name="patient_id" required>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}" {{ $patient->id == $cita->patient_id ? 'selected' : '' }}>
                    {{ $patient->name }} {{ $patient->last_name }}
                </option>
            @endforeach
        </select><br>
        <label for="doctor_id">Doctor:</label>
        <select name="doctor_id" required>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ $doctor->id == $cita->doctor_id ? 'selected' : '' }}>
                    {{ $doctor->name }} {{ $doctor->last_name }}
                </option>
            @endforeach
        </select><br>
        <label for="date">Date:</label>
        <input type="date" name="date" value="{{ $cita->date }}" required><br>
        <label for="time">Time:</label>
        <input type="time" name="time" value="{{ $cita->time }}" required><br>
        <label for="status">Status:</label>
        <input type="text" name="status" value="{{ $cita->status }}" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
