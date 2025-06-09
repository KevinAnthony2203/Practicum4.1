@extends('layouts.master')

@section('title', 'Programar Nueva Cita')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Programar Nueva Cita</h6>
                    <a href="{{ route('patients.appointments.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('patients.appointments.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="doctor_id" class="form-label">Doctor</label>
                            <select class="form-select @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id" required>
                                <option value="">Seleccionar Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                                id="fecha" name="fecha" value="{{ old('fecha') }}"
                                min="{{ date('Y-m-d') }}" required>
                            @error('fecha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <select class="form-select @error('hora') is-invalid @enderror"
                                id="hora" name="hora" required disabled>
                                <option value="">Seleccione una hora disponible</option>
                            </select>
                            @error('hora')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo de la Consulta</label>
                            <textarea class="form-control @error('motivo') is-invalid @enderror"
                                id="motivo" name="motivo" rows="3" required>{{ old('motivo') }}</textarea>
                            @error('motivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-check"></i> Programar Cita
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor_id');
    const fechaInput = document.getElementById('fecha');
    const horaSelect = document.getElementById('hora');

    // Establecer la fecha mínima como hoy
    const today = new Date().toISOString().split('T')[0];
    fechaInput.min = today;

    // Función para cargar los horarios disponibles
    function cargarHorariosDisponibles() {
        const doctorId = doctorSelect.value;
        const fecha = fechaInput.value;

        if (!doctorId || !fecha) {
            horaSelect.disabled = true;
            return;
        }

        // Hacer la petición AJAX para obtener los horarios disponibles
        fetch(`{{ route('patients.appointments.disponibilidad', ['doctor' => ':doctor', 'fecha' => ':fecha']) }}`
            .replace(':doctor', doctorId)
            .replace(':fecha', fecha))
            .then(response => response.json())
            .then(horas => {
                horaSelect.innerHTML = '<option value="">Seleccione una hora disponible</option>';

                if (horas.length === 0) {
                    horaSelect.innerHTML += '<option value="" disabled>No hay horarios disponibles para esta fecha</option>';
                } else {
                    horas.forEach(hora => {
                        horaSelect.innerHTML += `<option value="${hora}">${hora}</option>`;
                    });
                }

                horaSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                horaSelect.disabled = true;
            });
    }

    // Eventos para cargar horarios cuando cambie el doctor o la fecha
    doctorSelect.addEventListener('change', cargarHorariosDisponibles);
    fechaInput.addEventListener('change', cargarHorariosDisponibles);
});
</script>
@endpush
@endsection
