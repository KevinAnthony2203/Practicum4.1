@extends('layouts.master')

@section('title', 'Mis Citas')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Mis Citas Médicas</h6>
                    <div class="btn-group">
                        <a href="{{ route('patients.dashboard') }}" class="btn btn-secondary btn-sm me-2">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <a href="{{ route('patients.appointments.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nueva Cita
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Doctor</th>
                                    <th>Motivo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($appointment->fecha)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->hora)->format('H:i') }}</td>
                                        <td>{{ $appointment->doctor->name }}</td>
                                        <td>{{ $appointment->motivo }}</td>
                                        <td>
                                            <span class="badge bg-{{ $appointment->estado === 'pendiente' ? 'warning' : ($appointment->estado === 'confirmada' ? 'success' : 'danger') }}">
                                                {{ ucfirst($appointment->estado) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($appointment->fecha >= today())
                                                <button type="button" class="btn btn-danger btn-sm" onclick="cancelarCita({{ $appointment->id }})">
                                                    <i class="fas fa-times"></i> Cancelar
                                                </button>
                                            @else
                                                <span class="text-muted">Cita pasada</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No tienes citas programadas</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function cancelarCita(citaId) {
    if (confirm('¿Estás seguro de que deseas cancelar esta cita?')) {
        fetch(`{{ url('pacientes/citas') }}/${citaId}/cancelar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                alert(data.message);
                // Recargar la página para mostrar los cambios
                window.location.reload();
            } else {
                // Mostrar mensaje de error
                alert(data.message || 'Hubo un error al cancelar la cita');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al cancelar la cita');
        });
    }
}
</script>
@endpush
@endsection
