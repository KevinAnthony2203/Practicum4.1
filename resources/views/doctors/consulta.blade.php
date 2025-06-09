@extends('layouts.master')

@section('title', 'Consulta Médica')

@section('content')
<div class="container-fluid">
    <header class="mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1>Consulta Médica</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Consulta con {{ $cita->paciente->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <a href="{{ route('doctor.historial', $cita->patient_id) }}" class="btn btn-outline-info">
                        <i class="fas fa-history"></i> Ver Historial
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Información de la Cita</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Paciente:</dt>
                        <dd class="col-sm-8">{{ $cita->paciente->name }}</dd>

                        <dt class="col-sm-4">Fecha:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y') }}</dd>

                        <dt class="col-sm-4">Hora:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('H:i') }}</dd>

                        @if($cita->motivo)
                        <dt class="col-sm-4">Motivo:</dt>
                        <dd class="col-sm-8">{{ $cita->motivo }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">Signos Vitales</h5>
                </div>
                <div class="card-body">
                    <form id="signosVitalesForm">
                        <div class="mb-3">
                            <label for="presion_arterial" class="form-label">Presión Arterial</label>
                            <input type="text" class="form-control" id="presion_arterial" name="presion_arterial">
                        </div>
                        <div class="mb-3">
                            <label for="frecuencia_cardiaca" class="form-label">Frecuencia Cardíaca</label>
                            <input type="number" class="form-control" id="frecuencia_cardiaca" name="frecuencia_cardiaca">
                        </div>
                        <div class="mb-3">
                            <label for="temperatura" class="form-label">Temperatura</label>
                            <input type="number" step="0.1" class="form-control" id="temperatura" name="temperatura">
                        </div>
                        <div class="mb-3">
                            <label for="peso" class="form-label">Peso (kg)</label>
                            <input type="number" step="0.1" class="form-control" id="peso" name="peso">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Registro de Consulta</h5>
                </div>
                <div class="card-body">
                    <form id="consultaForm" action="{{ route('doctor.consulta.guardar', $cita->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="sintomas" class="form-label">Síntomas y Motivo de Consulta</label>
                            <textarea class="form-control" id="sintomas" name="sintomas" rows="3" required>{{ $cita->motivo }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="diagnostico" class="form-label">Diagnóstico</label>
                            <textarea class="form-control" id="diagnostico" name="diagnostico" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tratamiento" class="form-label">Tratamiento</label>
                            <textarea class="form-control" id="tratamiento" name="tratamiento" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="notas" class="form-label">Notas Adicionales</label>
                            <textarea class="form-control" id="notas" name="notas" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" onclick="history.back()">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Guardar Consulta
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
    const consultaForm = document.getElementById('consultaForm');

    consultaForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Aquí puedes agregar validación adicional si es necesario

        if (confirm('¿Está seguro de guardar la consulta?')) {
            this.submit();
        }
    });
});
</script>
@endpush
@endsection
