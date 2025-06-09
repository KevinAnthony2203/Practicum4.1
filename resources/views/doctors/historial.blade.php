@extends('layouts.master')

@section('title', 'Historial del Paciente')

@section('content')
<div class="container-fluid">
    <header class="mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1>Historial Médico</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Historial de {{ $paciente->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Información del Paciente</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $paciente->name }}</dd>

                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $paciente->email }}</dd>

                        @if($paciente->telefono)
                        <dt class="col-sm-4">Teléfono:</dt>
                        <dd class="col-sm-8">{{ $paciente->telefono }}</dd>
                        @endif

                        @if($paciente->fecha_nacimiento)
                        <dt class="col-sm-4">Edad:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">Historial de Consultas</h5>
                </div>
                <div class="card-body">
                    @if($citas->isEmpty())
                        <p class="text-muted">No hay consultas registradas para este paciente.</p>
                    @else
                        <div class="timeline">
                            @foreach($citas as $cita)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-{{ $cita->estado === 'completada' ? 'success' : 'warning' }}"></div>
                                <div class="timeline-content">
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-calendar-day me-2"></i>
                                                    {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }}
                                                </h6>
                                                <span class="badge bg-{{ $cita->estado === 'completada' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($cita->estado) }}
                                                </span>
                                            </div>
                                        </div>
                                        @if($cita->estado === 'completada')
                                        <div class="card-body">
                                            @if($cita->motivo)
                                            <p class="mb-2">
                                                <strong>Motivo de la consulta:</strong><br>
                                                {{ $cita->motivo }}
                                            </p>
                                            @endif

                                            @if($cita->notas)
                                            <p class="mb-0">
                                                <strong>Diagnóstico y notas:</strong><br>
                                                {{ $cita->notas }}
                                            </p>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #e9ecef;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 9px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}
</style>
@endsection
