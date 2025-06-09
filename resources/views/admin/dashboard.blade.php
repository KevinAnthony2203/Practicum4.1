@extends('layouts.master')

@section('title', 'Panel de Administración')

@section('content')
<main class="container-fluid">
    <header class="mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1>Panel de Administración</h1>
                <p class="lead">Bienvenido al panel de control administrativo</p>
            </div>
            <div class="col-auto">
                <time datetime="{{ now() }}" class="text-muted">
                    {{ now()->format('l, d \d\e F \d\e Y') }}
                </time>
            </div>
        </div>
    </header>

    <div class="row g-4">
        <!-- Estadísticas Generales -->
        <div class="col-12">
            <section class="row g-3">
                <div class="col-md-4">
                    <article class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <h2 class="card-title h5">Total Pacientes</h2>
                            <p class="display-4 mb-0">{{ $stats['total_pacientes'] }}</p>
                            <footer class="mt-2">
                                <small>
                                    <i class="fas fa-user-plus"></i>
                                    {{ $stats['nuevos_pacientes'] }} nuevos este mes
                                </small>
                            </footer>
                        </div>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="card bg-success text-white h-100">
                        <div class="card-body">
                            <h2 class="card-title h5">Total Doctores</h2>
                            <p class="display-4 mb-0">{{ $stats['total_doctores'] }}</p>
                            <footer class="mt-2">
                                <small>
                                    <i class="fas fa-user-md"></i>
                                    {{ $stats['especialidades'] }} especialidades
                                </small>
                            </footer>
                        </div>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="card bg-info text-white h-100">
                        <div class="card-body">
                            <h2 class="card-title h5">Citas Hoy</h2>
                            <p class="display-4 mb-0">{{ $stats['citas_hoy'] }}</p>
                            <footer class="mt-2">
                                <small>
                                    <i class="fas fa-calendar-check"></i>
                                    {{ $stats['citas_completadas'] }} completadas
                                </small>
                            </footer>
                        </div>
                    </article>
                </div>
            </section>
        </div>

        <!-- Gráficos y Tablas -->
        <div class="col-md-8">
            <section class="card shadow-sm">
                <header class="card-header bg-white">
                    <h2 class="h5 mb-0">Citas por Día</h2>
                </header>

                <div class="card-body">
                    <canvas id="citasChart" height="300"></canvas>
                </div>
            </section>
        </div>

        <div class="col-md-4">
            <!-- Actividad Reciente -->
            <section class="card shadow-sm mb-4">
                <header class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0">Actividad Reciente</h2>
                </header>
                <div class="card-body p-0">
                    @if($actividades->isEmpty())
                    <p class="text-muted p-3 mb-0">No hay actividades recientes.</p>
                    @else
                    <div class="list-group list-group-flush">
                        @foreach($actividades as $actividad)
                        <article class="list-group-item">
                            <h3 class="h6 mb-1">{{ $actividad->descripcion }}</h3>
                            <footer class="text-muted small">
                                <time datetime="{{ $actividad->created_at }}">
                                    {{ $actividad->created_at->diffForHumans() }}
                                </time>
                                por {{ $actividad->usuario->name }}
                            </footer>
                        </article>
                        @endforeach
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Citas
    const citasCtx = document.getElementById('citasChart').getContext('2d');
    new Chart(citasCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($charts['citas']['labels']) !!},
            datasets: [{
                label: 'Citas por Día',
                data: {!! json_encode($charts['citas']['data']) !!},
                borderColor: '#4e73df',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>
@endpush
