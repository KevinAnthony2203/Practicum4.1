@extends('layouts.master')

@section('title', 'Mi Historial Médico')

@section('content')
<main class="container">
    <header class="mb-4">
        <h1>Mi Historial Médico</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('patients.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Historial Médico</li>
            </ol>
        </nav>
    </header>

    <div class="row">
        <div class="col-md-8">
            <section class="card shadow-sm">
                <header class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Registros Médicos</h2>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light" id="filtro-todos">Todos</button>
                        <button type="button" class="btn btn-sm btn-light" id="filtro-consultas">Consultas</button>
                        <button type="button" class="btn btn-sm btn-light" id="filtro-examenes">Exámenes</button>
                    </div>
                </header>

                <div class="card-body">
                    @if($registros->isEmpty())
                    <p class="text-center text-muted my-4">No hay registros médicos disponibles.</p>
                    @else
                    <div class="timeline">
                        @foreach($registros as $registro)
                        <article class="timeline-item" data-tipo="{{ $registro->tipo }}">
                            <header class="timeline-header">
                                <time datetime="{{ $registro->fecha }}" class="text-muted">
                                    {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}
                                </time>
                            </header>
                            <div class="timeline-content">
                                <h3 class="h6">{{ $registro->tipo }}</h3>
                                <p>{{ $registro->descripcion }}</p>
                                <footer class="text-muted small">
                                    <span>Dr. {{ $registro->doctor->name }}</span>
                                    @if($registro->archivos_count > 0)
                                    <span class="ms-2">
                                        <i class="fas fa-paperclip"></i> {{ $registro->archivos_count }} archivo(s)
                                    </span>
                                    @endif
                                </footer>
                                @if($registro->archivos_count > 0)
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-outline-primary"
                                        onclick="verArchivos({{ $registro->id }})">
                                        Ver Archivos
                                    </button>
                                </div>
                                @endif
                            </div>
                        </article>
                        @endforeach
                    </div>

                    <footer class="d-flex justify-content-center mt-4">
                        {{ $registros->links() }}
                    </footer>
                    @endif
                </div>
            </section>
        </div>

        <aside class="col-md-4">
            <!-- Resumen de Salud -->
            <article class="card shadow-sm mb-4">
                <header class="card-header bg-info text-white">
                    <h2 class="h5 mb-0">Resumen de Salud</h2>
                </header>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Tipo de Sangre:</dt>
                        <dd class="col-sm-7">{{ $paciente->blood_type ?: 'No registrado' }}</dd>

                        <dt class="col-sm-5">Alergias:</dt>
                        <dd class="col-sm-7">{{ $paciente->allergies ?: 'Ninguna registrada' }}</dd>

                        <dt class="col-sm-5">Enfermedades:</dt>
                        <dd class="col-sm-7">{{ $paciente->chronic_diseases ?: 'Ninguna registrada' }}</dd>
                    </dl>
                </div>
            </article>

            <!-- Estadísticas -->
            <article class="card shadow-sm">
                <header class="card-header bg-success text-white">
                    <h2 class="h5 mb-0">Estadísticas</h2>
                </header>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-8">Total Consultas:</dt>
                        <dd class="col-sm-4">{{ $estadisticas['consultas'] }}</dd>

                        <dt class="col-sm-8">Total Exámenes:</dt>
                        <dd class="col-sm-4">{{ $estadisticas['examenes'] }}</dd>

                        <dt class="col-sm-8">Última Consulta:</dt>
                        <dd class="col-sm-4">
                            @if($estadisticas['ultima_consulta'])
                            <time datetime="{{ $estadisticas['ultima_consulta'] }}">
                                {{ \Carbon\Carbon::parse($estadisticas['ultima_consulta'])->format('d/m/Y') }}
                            </time>
                            @else
                            --
                            @endif
                        </dd>
                    </dl>
                </div>
            </article>
        </aside>
    </div>
</main>

<!-- Modal para Archivos -->
<dialog class="modal fade" id="archivosModal" tabindex="-1">
    <div class="modal-dialog">
        <article class="modal-content">
            <header class="modal-header">
                <h3 class="modal-title h5">Archivos Adjuntos</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </header>
            <div class="modal-body">
                <div id="lista-archivos"></div>
            </div>
        </article>
    </div>
</dialog>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtroTodos = document.getElementById('filtro-todos');
    const filtroConsultas = document.getElementById('filtro-consultas');
    const filtroExamenes = document.getElementById('filtro-examenes');
    const items = document.querySelectorAll('.timeline-item');

    function filtrarPor(tipo) {
        items.forEach(item => {
            if (tipo === 'todos' || item.dataset.tipo === tipo) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    filtroTodos.addEventListener('click', () => filtrarPor('todos'));
    filtroConsultas.addEventListener('click', () => filtrarPor('consulta'));
    filtroExamenes.addEventListener('click', () => filtrarPor('examen'));

    window.verArchivos = async function(registroId) {
        try {
            const response = await fetch(`/api/registros/${registroId}/archivos`);
            const archivos = await response.json();

            const listaArchivos = document.getElementById('lista-archivos');
            listaArchivos.innerHTML = archivos.map(archivo => `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>${archivo.nombre}</span>
                    <a href="/archivos/${archivo.id}/descargar" class="btn btn-sm btn-primary">
                        <i class="fas fa-download"></i> Descargar
                    </a>
                </div>
            `).join('') || '<p class="text-muted mb-0">No hay archivos disponibles.</p>';

            const modal = new bootstrap.Modal(document.getElementById('archivosModal'));
            modal.show();
        } catch (error) {
            console.error('Error al cargar archivos:', error);
        }
    };
});
</script>
@endpush
