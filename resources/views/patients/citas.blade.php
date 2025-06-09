@extends('layouts.master')

@section('title', 'Mis Citas')

@section('content')
<main class="container">
    <header class="mb-4">
        <h1>Mis Citas</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('patient.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Citas</li>
            </ol>
        </nav>
    </header>

    <div class="row">
        <div class="col-md-8">
            <section class="card shadow-sm">
                <header class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Historial de Citas</h2>
                    <a href="{{ route('citas.create') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus"></i> Nueva Cita
                    </a>
                </header>

                <div class="card-body">
                    @if($citas->isEmpty())
                    <p class="text-center text-muted my-4">No tienes citas registradas.</p>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Doctor</th>
                                    <th>Especialidad</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
        @foreach($citas as $cita)
                                <tr>
                                    <td>
                                        <time datetime="{{ $cita->fecha }}">
                                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                        </time>
                                    </td>
                                    <td>
                                        <time datetime="{{ $cita->hora }}">
                                            {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}
                                        </time>
                                    </td>
                                    <td>Dr. {{ $cita->doctor->name }}</td>
                                    <td>{{ $cita->doctor->especialidad }}</td>
                                    <td>
                                        <span class="badge bg-{{ $cita->estado_color }}">
                                            {{ $cita->estado }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('citas.show', $cita) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($cita->puede_cancelar)
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="cancelarCita({{ $cita->id }})">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
        @endforeach
                            </tbody>
                        </table>
                    </div>

                    <footer class="d-flex justify-content-center mt-4">
                        {{ $citas->links() }}
                    </footer>
                    @endif
                </div>
            </section>
        </div>

        <aside class="col-md-4">
            <!-- Próxima Cita -->
            <article class="card shadow-sm mb-4">
                <header class="card-header bg-success text-white">
                    <h2 class="h5 mb-0">Próxima Cita</h2>
                </header>
                <div class="card-body">
                    @if($proximaCita)
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Fecha:</dt>
                        <dd class="col-sm-8">
                            <time datetime="{{ $proximaCita->fecha }}">
                                {{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d/m/Y') }}
                            </time>
                        </dd>

                        <dt class="col-sm-4">Hora:</dt>
                        <dd class="col-sm-8">
                            <time datetime="{{ $proximaCita->hora }}">
                                {{ \Carbon\Carbon::parse($proximaCita->hora)->format('H:i') }}
                            </time>
                        </dd>

                        <dt class="col-sm-4">Doctor:</dt>
                        <dd class="col-sm-8">Dr. {{ $proximaCita->doctor->name }}</dd>

                        <dt class="col-sm-4">Especialidad:</dt>
                        <dd class="col-sm-8">{{ $proximaCita->doctor->especialidad }}</dd>
                    </dl>
                    @else
                    <p class="text-center text-muted mb-0">No tienes citas programadas.</p>
                    @endif
                </div>
                @if(!$proximaCita)
                <footer class="card-footer">
                    <div class="d-grid">
                        <a href="{{ route('citas.create') }}" class="btn btn-success">
                            <i class="fas fa-calendar-plus"></i> Programar Cita
                        </a>
                    </div>
                </footer>
                @endif
            </article>

            <!-- Estadísticas -->
            <article class="card shadow-sm">
                <header class="card-header bg-info text-white">
                    <h2 class="h5 mb-0">Estadísticas</h2>
                </header>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-8">Total Citas:</dt>
                        <dd class="col-sm-4">{{ $estadisticas['total'] }}</dd>

                        <dt class="col-sm-8">Citas Completadas:</dt>
                        <dd class="col-sm-4">{{ $estadisticas['completadas'] }}</dd>

                        <dt class="col-sm-8">Citas Canceladas:</dt>
                        <dd class="col-sm-4">{{ $estadisticas['canceladas'] }}</dd>

                        <dt class="col-sm-8">Citas Pendientes:</dt>
                        <dd class="col-sm-4">{{ $estadisticas['pendientes'] }}</dd>
                    </dl>
                </div>
            </article>
        </aside>
    </div>
</main>

<!-- Modal de Confirmación -->
<dialog class="modal fade" id="cancelarCitaModal" tabindex="-1">
    <div class="modal-dialog">
        <article class="modal-content">
            <header class="modal-header">
                <h3 class="modal-title h5">Cancelar Cita</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </header>
            <div class="modal-body">
                <p>¿Está seguro que desea cancelar esta cita?</p>
                <p class="text-muted small">
                    Nota: Las citas solo pueden ser canceladas con al menos 24 horas de anticipación.
                </p>
            </div>
            <footer class="modal-footer">
                <form id="cancelarCitaForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, mantener</button>
                    <button type="submit" class="btn btn-danger">Sí, cancelar</button>
                </form>
            </footer>
        </article>
</div>
</dialog>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cancelarCitaModal = new bootstrap.Modal(document.getElementById('cancelarCitaModal'));
    const cancelarCitaForm = document.getElementById('cancelarCitaForm');

    window.cancelarCita = function(id) {
        cancelarCitaForm.action = `/citas/${id}`;
        cancelarCitaModal.show();
    };

    cancelarCitaForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const response = await fetch(this.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.ok) {
                window.location.reload();
            } else {
                throw new Error('Error al cancelar la cita');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al cancelar la cita');
        }
    });
});
</script>
@endpush
