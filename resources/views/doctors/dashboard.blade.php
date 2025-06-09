@extends('layouts.master')

@section('title', 'Dashboard del Doctor')

@section('content')
<main class="container-fluid">
    <header class="mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1>Dashboard Médico</h1>
                <p class="lead">Bienvenido, Dr. {{ auth()->user()->name }}</p>
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
                <!-- Resumen de Citas -->
                <div class="col-md-6">
                    <article class="card h-100 shadow-sm">
                        <header class="card-header bg-primary text-white">
                            <h2 class="h5 mb-0">Citas de Hoy</h2>
                        </header>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="display-4 me-3">{{ $citasHoy }}</div>
                                <div class="text-muted">citas programadas</div>
                            </div>
                            <dl class="row mb-0">
                                <dt class="col-sm-6">Pendientes:</dt>
                                <dd class="col-sm-6">{{ $citasPendientes }}</dd>
                                <dt class="col-sm-6">Completadas:</dt>
                                <dd class="col-sm-6">{{ $citasCompletadas }}</dd>
                            </dl>
                        </div>
                        <footer class="card-footer">
                            <a href="{{ route('doctor.citas') }}" class="btn btn-sm btn-primary">
                                Ver todas las citas
                            </a>
                        </footer>
                    </article>
                </div>

                <!-- Próxima Cita -->
                <div class="col-md-6">
                    <article class="card h-100 shadow-sm">
                        <header class="card-header bg-info text-white">
                            <h2 class="h5 mb-0">Próxima Cita</h2>
                        </header>
                        <div class="card-body">
                            @if($proximaCita)
                            <dl>
                                <dt>Paciente:</dt>
                                <dd>{{ $proximaCita->paciente->nombre }}</dd>
                                <dt>Hora:</dt>
                                <dd>
                                    <time datetime="{{ $proximaCita->hora }}">
                                        {{ \Carbon\Carbon::parse($proximaCita->hora)->format('H:i') }}
                                    </time>
                                </dd>
                                <dt>Motivo:</dt>
                                <dd>{{ Str::limit($proximaCita->motivo, 50) }}</dd>
                            </dl>
                            <a href="{{ route('citas.show', $proximaCita) }}" class="btn btn-sm btn-info text-white">
                                Ver detalles
                            </a>
                            @else
                            <p class="text-muted mb-0">No hay citas programadas próximamente.</p>
                            @endif
                        </div>
                    </article>
                </div>

                <!-- Estadísticas Rápidas -->
                <div class="col-12">
                    <article class="card shadow-sm">
                        <header class="card-header bg-success text-white">
                            <h2 class="h5 mb-0">Estadísticas del Mes</h2>
                        </header>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-sm-3">
                                    <div class="text-center">
                                        <div class="h3 mb-0">{{ $estadisticas['pacientes_atendidos'] }}</div>
                                        <small class="text-muted">Pacientes Atendidos</small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="text-center">
                                        <div class="h3 mb-0">{{ $estadisticas['citas_completadas'] }}</div>
                                        <small class="text-muted">Citas Completadas</small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="text-center">
                                        <div class="h3 mb-0">{{ $estadisticas['tiempo_promedio'] }}min</div>
                                        <small class="text-muted">Tiempo Promedio</small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="text-center">
                                        <div class="h3 mb-0">{{ $estadisticas['satisfaccion'] }}%</div>
                                        <small class="text-muted">Satisfacción</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </section>
        </div>

        <aside class="col-md-4">
            <!-- Notificaciones -->
            <article class="card shadow-sm mb-4">
                <header class="card-header bg-warning">
                    <h2 class="h5 mb-0">Notificaciones</h2>
                </header>
                <div class="card-body p-0">
                    @if($notificaciones->isEmpty())
                    <p class="text-muted p-3 mb-0">No hay notificaciones nuevas.</p>
                    @else
                    <ul class="list-group list-group-flush">
                        @foreach($notificaciones as $notificacion)
                        <li class="list-group-item">
                            <article>
                                <h3 class="h6 mb-1">{{ ucfirst($notificacion->type) }}</h3>
                                <p class="mb-1">{{ $notificacion->message }}</p>
                                <footer class="text-muted small">
                                    <time datetime="{{ $notificacion->created_at }}">
                                        {{ $notificacion->created_at->diffForHumans() }}
                                    </time>
                                </footer>
                            </article>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                @if(!$notificaciones->isEmpty())
                <footer class="card-footer">
                    <a href="{{ route('notificaciones.index') }}" class="btn btn-sm btn-warning">
                        Ver todas
                    </a>
                </footer>
                @endif
            </article>

            <!-- Horario del Día -->
            <article class="card shadow-sm">
                <header class="card-header bg-secondary text-white">
                    <h2 class="h5 mb-0">Horario de Hoy</h2>
                </header>
                <div class="card-body">
                    @if($horarioHoy->isEmpty())
                        <p class="text-muted">No hay horario configurado para hoy</p>
                    @else
                        @foreach($horarioHoy as $horario)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <i class="fas fa-clock text-{{ $horario['estado_color'] }}"></i>
                                {{ $horario['hora_inicio'] }} - {{ $horario['hora_fin'] }}
                            </div>
                            <span class="badge bg-{{ $horario['estado_color'] }}">{{ $horario['estado'] }}</span>
                        </div>
                        @endforeach
                    @endif
                </div>
                <footer class="card-footer">
                    <a href="{{ route('doctor.horario') }}" class="btn btn-sm btn-secondary">
                        Gestionar Horarios
                    </a>
                </footer>
            </article>
        </aside>
    </div>
</main>
@endsection

@push('scripts')
<script>
// Aquí irían los scripts necesarios para el dashboard
</script>
@endpush
