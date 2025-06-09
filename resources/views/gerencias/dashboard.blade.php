@extends('layouts.app')

@section('content')
<main class="container-fluid">
    <header>
        <h1 class="mb-4">Panel Gerencial</h1>
    </header>

    <!-- Filtros de Fecha -->
    <section class="card shadow mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-center">
                <div class="col-auto">
                    <label class="col-form-label">Período:</label>
                </div>
                <div class="col-auto">
                    <select class="form-select" id="periodoFiltro">
                        <option value="hoy">Hoy</option>
                        <option value="semana">Esta Semana</option>
                        <option value="mes" selected>Este Mes</option>
                        <option value="año">Este Año</option>
                        <option value="personalizado">Personalizado</option>
                    </select>
                </div>
                <div class="col-auto fecha-personalizada d-none">
                    <input type="date" class="form-control" id="fechaInicio">
                </div>
                <div class="col-auto fecha-personalizada d-none">
                    <input type="date" class="form-control" id="fechaFin">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Aplicar</button>
                </div>
            </form>
        </div>
    </section>

    <section class="row">
        <!-- KPIs Principales -->
        <article class="col-xl-3 col-md-6 mb-4">
            <section class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <article class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h2 class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pacientes
                            </h2>
                            <p class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPacientes ?? 0 }}</p>
                            <p class="text-xs text-success mt-2">
                                <i class="fas fa-arrow-up"></i>
                                {{ $crecimientoPacientes ?? '0' }}% vs mes anterior
                            </p>
                        </div>
                        <aside class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </aside>
                    </article>
                </div>
            </section>
        </article>

        <article class="col-xl-3 col-md-6 mb-4">
            <section class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <article class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h2 class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ingresos Totales
                            </h2>
                            <p class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($ingresosTotales ?? 0, 2) }}</p>
                            <p class="text-xs text-success mt-2">
                                <i class="fas fa-arrow-up"></i>
                                {{ $crecimientoIngresos ?? '0' }}% vs mes anterior
                            </p>
                        </div>
                        <aside class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </aside>
                    </article>
                </div>
            </section>
        </article>

        <article class="col-xl-3 col-md-6 mb-4">
            <section class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <article class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h2 class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Satisfacción Pacientes
                            </h2>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <p class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $satisfaccionPacientes ?? 0 }}%</p>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: {{ $satisfaccionPacientes ?? 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <aside class="col-auto">
                            <i class="fas fa-smile fa-2x text-gray-300"></i>
                        </aside>
                    </article>
                </div>
            </section>
        </article>

        <article class="col-xl-3 col-md-6 mb-4">
            <section class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <article class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h2 class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Tiempo Promedio Consulta
                            </h2>
                            <p class="h5 mb-0 font-weight-bold text-gray-800">{{ $tiempoPromedioConsulta ?? '0' }} min</p>
                        </div>
                        <aside class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </aside>
                    </article>
                </div>
            </section>
        </article>
    </section>

    <section class="row">
        <!-- Gráfico de Ingresos -->
        <article class="col-xl-8 col-lg-7">
            <section class="card shadow mb-4">
                <header class="card-header py-3">
                    <h2 class="h6 m-0 font-weight-bold text-primary">Análisis de Ingresos</h2>
                </header>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="ingresosChart"></canvas>
                    </div>
                </div>
            </section>
        </article>

        <!-- Distribución de Pacientes -->
        <article class="col-xl-4 col-lg-5">
            <section class="card shadow mb-4">
                <header class="card-header py-3">
                    <h2 class="h6 m-0 font-weight-bold text-primary">Distribución por Especialidad</h2>
                </header>
                <div class="card-body">
                    <div class="chart-pie pt-4">
                        <canvas id="especialidadesChart"></canvas>
                    </div>
                </div>
            </section>
        </article>
    </section>

    <section class="row">
        <!-- Métricas de Rendimiento -->
        <article class="col-12">
            <section class="card shadow mb-4">
                <header class="card-header py-3">
                    <h2 class="h6 m-0 font-weight-bold text-primary">Métricas de Rendimiento por Médico</h2>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="medicosTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Médico</th>
                                    <th>Especialidad</th>
                                    <th>Pacientes Atendidos</th>
                                    <th>Satisfacción</th>
                                    <th>Tiempo Promedio</th>
                                    <th>Ingresos Generados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los datos se cargarán vía AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </article>
    </section>

    <section class="row">
        <!-- Tendencias y Predicciones -->
        <article class="col-xl-6 col-lg-6">
            <section class="card shadow mb-4">
                <header class="card-header py-3">
                    <h2 class="h6 m-0 font-weight-bold text-primary">Tendencias de Crecimiento</h2>
                </header>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="tendenciasChart"></canvas>
                    </div>
                </div>
            </section>
        </article>

        <!-- Análisis de Satisfacción -->
        <article class="col-xl-6 col-lg-6">
            <section class="card shadow mb-4">
                <header class="card-header py-3">
                    <h2 class="h6 m-0 font-weight-bold text-primary">Análisis de Satisfacción</h2>
                </header>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="satisfaccionChart"></canvas>
                    </div>
                </div>
            </section>
        </article>
    </section>
</main>

@push('styles')
<link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración de filtros de fecha
    $('#periodoFiltro').change(function() {
        if ($(this).val() === 'personalizado') {
            $('.fecha-personalizada').removeClass('d-none');
        } else {
            $('.fecha-personalizada').addClass('d-none');
        }
    });

    // Gráfico de Ingresos
    var ctxIngresos = document.getElementById('ingresosChart').getContext('2d');
    new Chart(ctxIngresos, {
        type: 'line',
        data: {
            labels: {!! json_encode($ingresosLabels ?? []) !!},
            datasets: [{
                label: 'Ingresos',
                data: {!! json_encode($ingresosData ?? []) !!},
                borderColor: '#4e73df',
                tension: 0.1
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Especialidades
    var ctxEspecialidades = document.getElementById('especialidadesChart').getContext('2d');
    new Chart(ctxEspecialidades, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($especialidadesLabels ?? []) !!},
            datasets: [{
                data: {!! json_encode($especialidadesData ?? []) !!},
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
            }]
        },
        options: {
            maintainAspectRatio: false
        }
    });

    // Gráfico de Tendencias
    var ctxTendencias = document.getElementById('tendenciasChart').getContext('2d');
    new Chart(ctxTendencias, {
        type: 'line',
        data: {
            labels: {!! json_encode($tendenciasLabels ?? []) !!},
            datasets: [{
                label: 'Pacientes',
                data: {!! json_encode($tendenciasPacientes ?? []) !!},
                borderColor: '#4e73df'
            }, {
                label: 'Ingresos',
                data: {!! json_encode($tendenciasIngresos ?? []) !!},
                borderColor: '#1cc88a'
            }]
        },
        options: {
            maintainAspectRatio: false
        }
    });

    // Gráfico de Satisfacción
    var ctxSatisfaccion = document.getElementById('satisfaccionChart').getContext('2d');
    new Chart(ctxSatisfaccion, {
        type: 'bar',
        data: {
            labels: {!! json_encode($satisfaccionLabels ?? []) !!},
            datasets: [{
                label: 'Satisfacción',
                data: {!! json_encode($satisfaccionData ?? []) !!},
                backgroundColor: '#36b9cc'
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Inicializar DataTable
    $('#medicosTable').DataTable({
        ajax: '{{ route("gerencia.medicos.metricas") }}',
        columns: [
            {data: 'medico'},
            {data: 'especialidad'},
            {data: 'pacientes_atendidos'},
            {data: 'satisfaccion'},
            {data: 'tiempo_promedio'},
            {data: 'ingresos'}
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
        }
    });
});
</script>
@endpush
@endsection
