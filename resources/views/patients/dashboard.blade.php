@extends('layouts.master')

@section('title', 'Dashboard del Paciente')

@section('content')
<main class="container">
    <header class="mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1>Mi Panel de Control</h1>
                <p class="lead mb-0">Bienvenido/a, {{ auth()->user()->name }}</p>
            </div>
            <div class="col-auto">
                <time datetime="{{ now() }}" class="text-muted">
                    {{ now()->format('l, d \d\e F \d\e Y') }}
                </time>
            </div>
        </div>
    </header>

    <div class="row g-4">
        <div class="col-md-8">
            <section class="row g-3">
                <!-- Próxima Cita -->
                <div class="col-12">
                    <article class="card shadow-sm">
                        <header class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h2 class="h5 mb-0">Próxima Cita</h2>
                            <a href="{{ route('patients.appointments.create') }}" class="btn btn-sm btn-light">
                                <i class="fas fa-plus"></i> Nueva Cita
                            </a>
                        </header>
                        <div class="card-body">
                            @if($proximaCita)
                            <dl class="row mb-0">
                                <dt class="col-sm-3">Fecha:</dt>
                                <dd class="col-sm-9">
                                    <time datetime="{{ $proximaCita->fecha }}">
                                        {{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d/m/Y') }}
                                    </time>
                                </dd>

                                <dt class="col-sm-3">Hora:</dt>
                                <dd class="col-sm-9">
                                    <time datetime="{{ $proximaCita->hora }}">
                                        {{ \Carbon\Carbon::parse($proximaCita->hora)->format('H:i') }}
                                    </time>
                                </dd>

                                <dt class="col-sm-3">Doctor:</dt>
                                <dd class="col-sm-9">Dr. {{ $proximaCita->doctor->name }}</dd>

                                <dt class="col-sm-3">Especialidad:</dt>
                                <dd class="col-sm-9">{{ $proximaCita->doctor->especialidad }}</dd>

                                <dt class="col-sm-3">Estado:</dt>
                                <dd class="col-sm-9">
                                    <span class="badge bg-{{ $proximaCita->estado_color }}">
                                        {{ $proximaCita->estado }}
                                    </span>
                                </dd>
                            </dl>
                            @else
                            <p class="text-center text-muted mb-0">No tienes citas programadas.</p>
                            @endif
                        </div>
                        @if(!$proximaCita)
                        <footer class="card-footer">
                            <div class="d-grid">
                                <a href="{{ route('patients.appointments.create') }}" class="btn btn-success">
                                    <i class="fas fa-calendar-plus"></i> Programar Cita
                                </a>
                            </div>
                        </footer>
                        @endif
                    </article>
                </div>

                <!-- Historial Médico Reciente -->
                <div class="col-12">
                    <article class="card shadow-sm">
                        <header class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                            <h2 class="h5 mb-0">Historial Médico Reciente</h2>
                            <a href="{{ route('patients.historial.index') }}" class="btn btn-sm btn-light">
                                Ver Todo
                            </a>
                        </header>
                        <div class="card-body">
                            @if($resultados->isEmpty())
                            <p class="text-center text-muted my-4">No hay registros médicos recientes.</p>
                            @else
                            <div class="timeline">
                                @foreach($resultados as $registro)
                                <article class="timeline-item">
                                    <header class="timeline-header">
                                        <time datetime="{{ $registro->fecha }}" class="text-muted">
                                            {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}
                                        </time>
                                    </header>
                                    <div class="timeline-content">
                                        <h3 class="h6">{{ $registro->tipo }}</h3>
                                        <p class="mb-0">{{ Str::limit($registro->descripcion, 150) }}</p>
                                    </div>
                                </article>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </article>
                </div>
            </section>
        </div>

        <aside class="col-md-4">
            <!-- Recordatorios -->
            <article class="card shadow-sm mb-4">
                <header class="card-header bg-warning">
                    <h2 class="h5 mb-0">Mis Recordatorios</h2>
                </header>
                <div class="card-body p-0">
                    @if($recordatorios->isEmpty())
                    <p class="text-muted p-3 mb-0">No tienes recordatorios pendientes.</p>
                    @else
                    <ul class="list-group list-group-flush">
                        @foreach($recordatorios as $recordatorio)
                        <li class="list-group-item">
                            <article>
                                <h3 class="h6 mb-1">{{ $recordatorio->titulo }}</h3>
                                <p class="mb-1">{{ $recordatorio->descripcion }}</p>
                                <footer class="text-muted small">
                                    <time datetime="{{ $recordatorio->fecha_hora }}">
                                        {{ \Carbon\Carbon::parse($recordatorio->fecha_hora)->format('d/m/Y H:i') }}
                                    </time>
                                </footer>
                            </article>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                @if(!$recordatorios->isEmpty())
                <footer class="card-footer">
                    <a href="{{ route('patients.recordatorios.index') }}" class="btn btn-sm btn-warning">
                        Ver Todos
                    </a>
                </footer>
                @endif
            </article>

            <!-- Información de Contacto -->
            <article class="card shadow-sm">
                <header class="card-header bg-info text-white">
                    <h2 class="h5 mb-0">Información de Contacto</h2>
                </header>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Teléfono:</dt>
                        <dd class="col-sm-8">{{ auth()->user()->telefono }}</dd>

                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ auth()->user()->email }}</dd>

                        <dt class="col-sm-4">Dirección:</dt>
                        <dd class="col-sm-8">{{ auth()->user()->direccion }}</dd>
                    </dl>
                    <hr>
                    <div class="d-grid">
                        <a href="{{ route('patients.profile.edit') }}" class="btn btn-outline-info">
                            <i class="fas fa-user-edit"></i> Actualizar Datos
                        </a>
                    </div>
                </div>
            </article>
        </aside>
    </div>
</main>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding: 1rem 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    height: 100%;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-left: 3rem;
    padding-bottom: 1.5rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-header {
    position: relative;
    margin-bottom: 0.5rem;
}

.timeline-header::before {
    content: '';
    position: absolute;
    left: -2rem;
    top: 0.25rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #6c757d;
}

.timeline-content {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.25rem;
}
</style>
@endpush
