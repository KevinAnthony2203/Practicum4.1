@extends('layouts.master')

@section('title', 'Programar Nueva Cita')

@section('content')
<main class="container">
    <header class="mb-4">
        <h1>Programar Nueva Cita</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('secretaria.dashboard') }}">Dashboard Secretaría</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nueva Cita</li>
            </ol>
        </nav>
    </header>

    <section class="row">
        <div class="col-md-8">
            <article class="card shadow-sm">
                <header class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0">Detalles de la Cita</h2>
                </header>

                <div class="card-body">
                    <form method="POST" action="{{ route('secretaria.citas.store') }}" class="needs-validation" novalidate>
                        @csrf

                        <fieldset>
                            <legend class="h6">Información Básica</legend>

                            <div class="mb-3">
                                <label for="patient_id" class="form-label">Paciente</label>
                                <select id="patient_id" name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un paciente</option>
                                    @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" {{ old('patient_id') == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->name }} {{ $paciente->last_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="doctor_id" class="form-label">Médico</label>
                                <select id="doctor_id" name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un médico</option>
                                    @foreach($doctores as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        Dr. {{ $doctor->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha de la Cita</label>
                                <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                                    id="fecha" name="fecha"
                                    value="{{ old('fecha') }}"
                                    min="{{ date('Y-m-d') }}"
                                    required>
                                @error('fecha')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="hora" class="form-label">Hora</label>
                                <select id="hora" name="hora" class="form-select @error('hora') is-invalid @enderror" required>
                                    <option value="">Seleccione una hora</option>
                                    <!-- Las horas se cargarán dinámicamente via JavaScript -->
                                </select>
                                @error('hora')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="h6">Detalles Adicionales</legend>

                            <div class="mb-3">
                                <label for="motivo" class="form-label">Motivo de la Consulta</label>
                                <textarea id="motivo" name="motivo"
                                    class="form-control @error('motivo') is-invalid @enderror"
                                    rows="3" required>{{ old('motivo') }}</textarea>
                                @error('motivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notas" class="form-label">Notas (opcional)</label>
                                <textarea id="notas" name="notas"
                                    class="form-control @error('notas') is-invalid @enderror"
                                    rows="3">{{ old('notas') }}</textarea>
                                @error('notas')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </fieldset>

                        <footer class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-plus"></i> Programar Cita
                            </button>
                            <a href="{{ route('secretaria.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </footer>
                    </form>
                </div>
            </article>
        </div>

        <aside class="col-md-4">
            <article class="card shadow-sm mb-4">
                <header class="card-header bg-info text-white">
                    <h2 class="h5 mb-0">Información Importante</h2>
                </header>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            Seleccione primero el médico y la fecha para ver las horas disponibles.
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-clock text-warning me-2"></i>
                            Las citas tienen una duración definida por cada médico.
                        </li>
                    </ul>
                </div>
            </article>

            {{-- Aquí podrías agregar un resumen del horario del médico seleccionado --}}
            <article class="card shadow-sm">
                <header class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">Horario del Médico Seleccionado</h5>
                </header>
                <div class="card-body" id="horarioMedico">
                    <p class="text-muted">Seleccione un médico y una fecha.</p>
                </div>
            </article>
        </aside>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const patientSelect = document.getElementById('patient_id');
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('fecha');
    const timeSelect = document.getElementById('hora');
    const horarioMedicoDiv = document.getElementById('horarioMedico');

    // Función para cargar las horas disponibles
    async function loadAvailableHours() {
        // Limpiar horas anteriores
        timeSelect.innerHTML = '<option value="">Seleccione una hora</option>';
        horarioMedicoDiv.innerHTML = '<p class="text-muted">Cargando horario...</p>';

        if (doctorSelect.value && dateInput.value) {
            try {
                // Cargar horario del médico para la fecha seleccionada
                const horarioResponse = await fetch(`/api/doctor/${doctorSelect.value}/horario/${dateInput.value}`);
                const horarioData = await horarioResponse.json();

                if (horarioData.disponible) {
                     horarioMedicoDiv.innerHTML = `
                         <p>Disponible de <strong>${horarioData.hora_inicio}</strong> a <strong>${horarioData.hora_fin}</strong></p>
                         <p class="text-muted">Duración de cita: ${horarioData.duracion_cita} min, Intervalo: ${horarioData.tiempo_entre_citas} min</p>
                     `;

                    // Cargar horas disponibles
                    const disponibilidadResponse = await fetch(`/api/disponibilidad/${doctorSelect.value}/${dateInput.value}`);
                    const disponibilidadData = await disponibilidadResponse.json();

                    if (disponibilidadData.length > 0) {
                        disponibilidadData.forEach(hora => {
                            timeSelect.innerHTML += `<option value="${hora}">${hora}</option>`;
                        });
                    } else {
                         timeSelect.innerHTML = '<option value="">No hay horas disponibles para este día</option>';
                    }

                } else {
                    horarioMedicoDiv.innerHTML = '<p class="text-muted">El médico no tiene horario definido para esta fecha o está inactivo.</p>';
                    timeSelect.innerHTML = '<option value="">Médico no disponible en esta fecha</option>';
                }

            } catch (error) {
                console.error('Error al cargar información de disponibilidad:', error);
                horarioMedicoDiv.innerHTML = '<p class="text-danger">Error al cargar horario.</p>';
                timeSelect.innerHTML = '<option value="">Error al cargar horas</option>';
            }
        } else {
             horarioMedicoDiv.innerHTML = '<p class="text-muted">Seleccione un médico y una fecha.</p>';
             timeSelect.innerHTML = '<option value="">Seleccione médico y fecha</option>';
        }
    }

    // Event Listeners
    doctorSelect.addEventListener('change', loadAvailableHours);
    dateInput.addEventListener('change', loadAvailableHours);

    // Cargar horas al cargar la página si ya hay valores seleccionados (ej. después de un error de validación)
    if (doctorSelect.value && dateInput.value) {
        loadAvailableHours();
    }
});
</script>
@endpush
