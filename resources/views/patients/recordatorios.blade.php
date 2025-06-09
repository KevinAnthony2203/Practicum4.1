@extends('layouts.master')

@section('title', 'Mis Recordatorios')

@section('content')
<main class="container">
    <header class="mb-4">
        <h1>Mis Recordatorios</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('patients.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Recordatorios</li>
            </ol>
        </nav>
    </header>

    <div class="row">
        <div class="col-md-8">
            <section class="card shadow-sm">
                <header class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Lista de Recordatorios</h2>
                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#recordatorioModal">
                        <i class="fas fa-plus"></i> Nuevo Recordatorio
                    </button>
                </header>

                <div class="card-body">
                    @if($recordatorios->isEmpty())
                    <p class="text-center text-muted my-4">No tienes recordatorios configurados.</p>
                    @else
                    <div class="list-group">
                        @foreach($recordatorios as $recordatorio)
                        <article class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h3 class="h6 mb-1">{{ $recordatorio->titulo }}</h3>
                                    <p class="mb-1">{{ $recordatorio->mensaje }}</p>
                                    <footer class="text-muted small">
                                        <time datetime="{{ $recordatorio->fecha_hora }}">
                                            {{ \Carbon\Carbon::parse($recordatorio->fecha_hora)->format('d/m/Y H:i') }}
                                        </time>
                                        <span class="ms-2">
                                            <i class="fas fa-bell"></i>
                                            {{ $recordatorio->tipo }}
                                        </span>
                                    </footer>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="editarRecordatorio({{ $recordatorio->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="eliminarRecordatorio({{ $recordatorio->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    <footer class="d-flex justify-content-center mt-4">
                        {{ $recordatorios->links() }}
                    </footer>
                    @endif
                </div>
            </section>
        </div>

        <aside class="col-md-4">
            <!-- Próximos Recordatorios -->
            <article class="card shadow-sm mb-4">
                <header class="card-header bg-warning">
                    <h2 class="h5 mb-0">Próximos Recordatorios</h2>
                </header>
                <div class="card-body p-0">
                    @if($proximosRecordatorios->isEmpty())
                    <p class="text-muted p-3 mb-0">No hay recordatorios próximos.</p>
                    @else
                    <ul class="list-group list-group-flush">
                        @foreach($proximosRecordatorios as $recordatorio)
                        <li class="list-group-item">
                            <h3 class="h6 mb-1">{{ $recordatorio->titulo }}</h3>
                            <p class="mb-1">{{ $recordatorio->mensaje }}</p>
                            <footer class="text-muted small">
                                <time datetime="{{ $recordatorio->fecha_hora }}">
                                    {{ \Carbon\Carbon::parse($recordatorio->fecha_hora)->format('d/m/Y H:i') }}
                                </time>
                            </footer>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </article>

            <!-- Configuración de Notificaciones -->
            <article class="card shadow-sm">
                <header class="card-header bg-info text-white">
                    <h2 class="h5 mb-0">Configuración de Notificaciones</h2>
                </header>
                <div class="card-body">
                    <form action="{{ route('patients.recordatorios.configuracion') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="notificaciones_email"
                                    name="notificaciones_email" {{ $config->notificaciones_email ? 'checked' : '' }}>
                                <label class="form-check-label" for="notificaciones_email">
                                    Notificaciones por Email
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="notificaciones_sms"
                                    name="notificaciones_sms" {{ $config->notificaciones_sms ? 'checked' : '' }}>
                                <label class="form-check-label" for="notificaciones_sms">
                                    Notificaciones por SMS
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tiempo_anticipacion" class="form-label">
                                Tiempo de Anticipación
                            </label>
                            <select class="form-select" id="tiempo_anticipacion" name="tiempo_anticipacion">
                                <option value="15" {{ $config->tiempo_anticipacion == 15 ? 'selected' : '' }}>15 minutos</option>
                                <option value="30" {{ $config->tiempo_anticipacion == 30 ? 'selected' : '' }}>30 minutos</option>
                                <option value="60" {{ $config->tiempo_anticipacion == 60 ? 'selected' : '' }}>1 hora</option>
                                <option value="120" {{ $config->tiempo_anticipacion == 120 ? 'selected' : '' }}>2 horas</option>
                                <option value="1440" {{ $config->tiempo_anticipacion == 1440 ? 'selected' : '' }}>1 día</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-info text-white">
                                <i class="fas fa-save"></i> Guardar Configuración
                            </button>
                        </div>
                    </form>
                </div>
            </article>
        </aside>
    </div>
</main>

<!-- Modal Nuevo/Editar Recordatorio -->
<dialog class="modal fade" id="recordatorioModal" tabindex="-1">
    <div class="modal-dialog">
        <article class="modal-content">
            <header class="modal-header">
                <h3 class="modal-title h5" id="recordatorioModalLabel">Nuevo Recordatorio</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </header>
            <form id="recordatorioForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>

                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_hora" class="form-label">Fecha y Hora</label>
                        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Recordatorio</label>
                        <select class="form-select" id="tipo" name="tipo" required>
                            <option value="medicamento">Medicamento</option>
                            <option value="cita">Cita Médica</option>
                            <option value="examen">Examen Médico</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                </div>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </footer>
            </form>
        </article>
    </div>
</dialog>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const recordatorioModal = new bootstrap.Modal(document.getElementById('recordatorioModal'));
    const recordatorioForm = document.getElementById('recordatorioForm');

    recordatorioForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const response = await fetch('/recordatorios', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.ok) {
                window.location.reload();
            } else {
                throw new Error('Error al guardar el recordatorio');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al guardar el recordatorio');
        }
    });

    window.editarRecordatorio = async function(id) {
        try {
            const response = await fetch(`/recordatorios/${id}`);
            const recordatorio = await response.json();

            document.getElementById('titulo').value = recordatorio.titulo;
            document.getElementById('mensaje').value = recordatorio.mensaje;
            document.getElementById('fecha_hora').value = recordatorio.fecha_hora;
            document.getElementById('tipo').value = recordatorio.tipo;

            document.getElementById('recordatorioModalLabel').textContent = 'Editar Recordatorio';
            recordatorioForm.setAttribute('action', `/recordatorios/${id}`);
            recordatorioModal.show();
        } catch (error) {
            console.error('Error:', error);
            alert('Error al cargar el recordatorio');
        }
    };

    window.eliminarRecordatorio = async function(id) {
        if (confirm('¿Está seguro de eliminar este recordatorio?')) {
            try {
                const response = await fetch(`/recordatorios/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    throw new Error('Error al eliminar el recordatorio');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al eliminar el recordatorio');
            }
        }
    };
});
</script>
@endpush
