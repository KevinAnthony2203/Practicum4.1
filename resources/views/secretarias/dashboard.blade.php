@extends('layouts.master')

@section('title', 'Dashboard Secretaria')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Panel de Secretaría</h2>

    <div class="row">
        <!-- Estadísticas Rápidas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Citas Hoy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $citasHoy ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pacientes Registrados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPacientes ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Médicos Disponibles</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $medicosDisponibles ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Citas Pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $citasPendientes ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Calendario de Citas -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Calendario de Citas</h6>
                    <div class="dropdown no-arrow">
                        <a href="{{ route('secretaria.citas.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus fa-sm"></i> Nueva Cita
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Lista de Citas de Hoy -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Citas de Hoy</h6>
                </div>
                <div class="card-body">
                    <div class="citas-hoy-list" style="max-height: 400px; overflow-y: auto;">
                        @forelse($citasDelDia ?? [] as $cita)
                        <div class="cita-item p-2 mb-2 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-{{ $cita->estado_color }}">{{ $cita->hora }}</span>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <h6 class="mb-1">{{ $cita->paciente->name }}</h6>
                            <p class="mb-1 text-muted">Dr. {{ $cita->doctor->name }}</p>
                            <small>{{ $cita->motivo }}</small>
                        </div>
                        @empty
                        <p class="text-center text-muted my-3">No hay citas programadas para hoy</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gestión de Pacientes -->
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Gestión de Pacientes</h6>
                    <a href="{{ route('secretaria.pacientes.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus fa-sm"></i> Nuevo Paciente
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="pacientesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Cédula</th>
                                    <th>Teléfono</th>
                                    <th>Última Cita</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los datos se cargarán vía AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Estilos para los eventos según su estado */
    .event-pendiente {
        background-color: #ffc107 !important;
        border-color: #e0a800 !important;
    }
    .event-confirmada {
        background-color: #28a745 !important;
        border-color: #1e7e34 !important;
    }
    .event-cancelada {
        background-color: #dc3545 !important;
        border-color: #bd2130 !important;
    }
    .event-completada {
        background-color: #17a2b8 !important;
        border-color: #138496 !important;
    }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Calendario
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'timeGridWeek',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día'
        },
        minTime: '07:00:00',
        maxTime: '20:00:00',
        allDaySlot: false,
        slotDuration: '00:30:00',
        height: 700,
        contentHeight: 700,
        aspectRatio: 1.8,
        nowIndicator: true,
        events: {
            url: '{{ route("secretaria.citas.eventos") }}',
            failure: function() {
                console.error('Error al cargar los eventos del calendario');
            }
        },
        eventRender: function(info) {
            // Agregar clase según el estado de la cita
            if (info.event.extendedProps && info.event.extendedProps.estado) {
                info.el.classList.add('event-' + info.event.extendedProps.estado);
            }
        },
        eventClick: function(info) {
            // Mostrar detalles de la cita
            console.log('Evento clickeado:', info.event);
        }
    });
    calendar.render();

    // Inicializar DataTable
    $('#pacientesTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route("secretaria.pacientes.data") }}',
            error: function (xhr, error, thrown) {
                console.error('Error en la carga de datos:', error);
                alert('Error al cargar los datos de pacientes. Por favor, recarga la página.');
            }
        },
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'identificacion'},
            {data: 'contacto'},
            {data: 'ultima_cita'},
            {
                data: 'estado',
                render: function(data) {
                    return data;
                }
            },
            {
                data: 'actions',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return data;
                }
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
        }
    });
});
</script>
@endpush
@endsection
