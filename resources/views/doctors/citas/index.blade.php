@extends('layouts.master')

@section('title', 'Mis Citas')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mis Citas</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Citas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fecha y Hora</th>
                            <th>Paciente</th>
                            <th>Estado</th>
                            <th>Motivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($citas as $cita)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }}</td>
                            <td>{{ $cita->paciente->name }}</td>
                            <td>
                                <span class="badge badge-{{ $cita->estado === 'pendiente' ? 'warning' :
                                    ($cita->estado === 'completada' ? 'success' :
                                    ($cita->estado === 'cancelada' ? 'danger' : 'info')) }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </td>
                            <td>{{ $cita->motivo }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info"
                                            data-toggle="modal"
                                            data-target="#citaModal{{ $cita->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($cita->estado === 'pendiente')
                                    <button type="button" class="btn btn-sm btn-success"
                                            onclick="completarCita({{ $cita->id }})">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="cancelarCita({{ $cita->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay citas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $citas->links() }}
            </div>
        </div>
    </div>
</div>

@foreach($citas as $cita)
<!-- Modal de Detalles -->
<div class="modal fade" id="citaModal{{ $cita->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">Paciente:</dt>
                    <dd class="col-sm-8">{{ $cita->paciente->name }}</dd>

                    <dt class="col-sm-4">Fecha y Hora:</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }}</dd>

                    <dt class="col-sm-4">Estado:</dt>
                    <dd class="col-sm-8">
                        <span class="badge badge-{{ $cita->estado === 'pendiente' ? 'warning' :
                            ($cita->estado === 'completada' ? 'success' :
                            ($cita->estado === 'cancelada' ? 'danger' : 'info')) }}">
                            {{ ucfirst($cita->estado) }}
                        </span>
                    </dd>

                    <dt class="col-sm-4">Motivo:</dt>
                    <dd class="col-sm-8">{{ $cita->motivo }}</dd>

                    @if($cita->diagnostico)
                    <dt class="col-sm-4">Diagnóstico:</dt>
                    <dd class="col-sm-8">{{ $cita->diagnostico }}</dd>
                    @endif
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
function completarCita(id) {
    if (confirm('¿Está seguro de marcar esta cita como completada?')) {
        // Aquí iría la lógica para completar la cita
        alert('Funcionalidad en desarrollo');
    }
}

function cancelarCita(id) {
    if (confirm('¿Está seguro de cancelar esta cita?')) {
        // Aquí iría la lógica para cancelar la cita
        alert('Funcionalidad en desarrollo');
    }
}
</script>
@endpush
@endsection
