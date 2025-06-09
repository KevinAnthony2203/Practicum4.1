@extends('layouts.master')

@section('title', 'Detalles de la Cita')

@section('content')
<main class="container">
    <header class="mb-4">
        <h1>Detalles de la Cita</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('citas.index') }}">Citas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalles</li>
            </ol>
        </nav>
    </header>

    <section class="row">
        <div class="col-md-8">
            <article class="card shadow-sm">
                <header class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Información de la Cita</h2>
                    <span class="badge bg-{{ $cita->estado_color }}">{{ $cita->estado }}</span>
                </header>

                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Fecha:</dt>
                        <dd class="col-sm-9">
                            <time datetime="{{ $cita->fecha }}">
                                {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                            </time>
                        </dd>

                        <dt class="col-sm-3">Hora:</dt>
                        <dd class="col-sm-9">
                            <time datetime="{{ $cita->hora }}">
                                {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}
                            </time>
                        </dd>

                        <dt class="col-sm-3">Doctor:</dt>
                        <dd class="col-sm-9">Dr. {{ $cita->doctor->name }}</dd>

                        <dt class="col-sm-3">Especialidad:</dt>
                        <dd class="col-sm-9">{{ $cita->doctor->especialidad }}</dd>

                        <dt class="col-sm-3">Motivo:</dt>
                        <dd class="col-sm-9">{{ $cita->motivo }}</dd>

                        @if($cita->sintomas)
                        <dt class="col-sm-3">Síntomas:</dt>
                        <dd class="col-sm-9">{{ $cita->sintomas }}</dd>
                        @endif
                    </dl>

                    <footer class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            @if($cita->puede_cancelar)
                            <button type="button"
                                    class="btn btn-danger"
                                    onclick="confirmarCancelacion({{ $cita->id }})">
                                <i class="fas fa-times"></i> Cancelar Cita
                            </button>
                            @endif
                        </div>
                        <a href="{{ route('citas.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                    </footer>
                </div>
            </article>
        </div>

        <aside class="col-md-4">
            <article class="card shadow-sm mb-4">
                <header class="card-header bg-info text-white">
                    <h2 class="h5 mb-0">Información del Consultorio</h2>
                </header>
                <div class="card-body">
                    <address>
                        <strong>{{ $cita->doctor->consultorio }}</strong><br>
                        {{ $cita->doctor->direccion_consultorio }}<br>
                        <abbr title="Teléfono">Tel:</abbr> {{ $cita->doctor->telefono_consultorio }}
                    </address>

                    @if($cita->doctor->instrucciones_cita)
                    <hr>
                    <h3 class="h6">Instrucciones para la Cita:</h3>
                    <p class="mb-0">{{ $cita->doctor->instrucciones_cita }}</p>
                    @endif
                </div>
            </article>
        </aside>
    </section>
</main>
@endsection

@push('scripts')
<script>
function confirmarCancelacion(citaId) {
    if (confirm('¿Está seguro que desea cancelar esta cita? Esta acción no se puede deshacer.')) {
        // Aquí iría el código para cancelar la cita
    }
}
</script>
@endpush
