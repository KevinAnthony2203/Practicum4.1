@extends('layouts.master')

@section('title', 'Programar Nueva Cita')

@section('content')
<main class="container">
    <header class="mb-4">
        <h1>Programar Nueva Cita</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('citas.index') }}">Citas</a></li>
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
                    <form method="POST" action="{{ route('citas.store') }}" class="needs-validation" novalidate>
                        @csrf

                        <fieldset>
                            <legend class="h6">Información Básica</legend>

                            <div class="mb-3">
                                <label for="doctor_id" class="form-label">Médico</label>
                                <select id="doctor_id" name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un médico</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        Dr. {{ $doctor->name }} - {{ $doctor->especialidad }}
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
                                <label for="sintomas" class="form-label">Síntomas (opcional)</label>
                                <textarea id="sintomas" name="sintomas"
                                    class="form-control @error('sintomas') is-invalid @enderror"
                                    rows="3">{{ old('sintomas') }}</textarea>
                                @error('sintomas')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </fieldset>

                        <footer class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-plus"></i> Programar Cita
                            </button>
                            <a href="{{ route('citas.index') }}" class="btn btn-outline-secondary">
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
                            Seleccione primero el médico para ver las horas disponibles.
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-clock text-warning me-2"></i>
                            Las citas tienen una duración de 30 minutos.
                        </li>
                        <li>
                            <i class="fas fa-calendar-alt text-success me-2"></i>
                            Puede programar citas con hasta 30 días de anticipación.
                        </li>
                    </ul>
                </div>
            </article>
        </aside>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('fecha');
    const timeSelect = document.getElementById('hora');

    // Función para cargar las horas disponibles
    async function loadAvailableHours() {
        if (doctorSelect.value && dateInput.value) {
            try {
                const response = await fetch(`/api/disponibilidad/${doctorSelect.value}/${dateInput.value}`);
                const data = await response.json();

                timeSelect.innerHTML = '<option value="">Seleccione una hora</option>';
                data.forEach(hora => {
                    timeSelect.innerHTML += `<option value="${hora}">${hora}</option>`;
                });
            } catch (error) {
                console.error('Error al cargar las horas disponibles:', error);
            }
        }
    }

    doctorSelect.addEventListener('change', loadAvailableHours);
    dateInput.addEventListener('change', loadAvailableHours);
});
</script>
@endpush
