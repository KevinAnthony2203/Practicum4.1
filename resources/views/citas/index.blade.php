@extends('layouts.master')

@section('title', 'Mis Citas')

@section('content')
<main class="container">
    <header class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Mis Citas</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Citas</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('citas.create') }}" class="btn btn-primary">
            <i class="fas fa-calendar-plus"></i> Nueva Cita
        </a>
    </header>

    <section class="row">
        <div class="col-12">
            <article class="card shadow-sm">
                <header class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0">Listado de Citas</h2>
                        <div class="btn-group" role="group" aria-label="Filtros de citas">
                            <button type="button" class="btn btn-outline-primary active">Todas</button>
                            <button type="button" class="btn btn-outline-primary">Pendientes</button>
                            <button type="button" class="btn btn-outline-primary">Completadas</button>
                        </div>
                    </div>
                </header>

                <div class="card-body">
                    @if($citas->isEmpty())
                        <p class="text-center text-muted my-5">No hay citas programadas.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Hora</th>
                                        <th scope="col">Doctor</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acciones</th>
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
                                        <td>
                                            <span class="badge bg-{{ $cita->estado_color }}">
                                                {{ $cita->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Acciones de cita">
                                                <a href="{{ route('citas.show', $cita) }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($cita->puede_cancelar)
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Cancelar cita"
                                                        onclick="confirmarCancelacion({{ $cita->id }})">
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
            </article>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
function confirmarCancelacion(citaId) {
    if (confirm('¿Está seguro que desea cancelar esta cita?')) {
        // Aquí iría el código para cancelar la cita
    }
}
</script>
@endpush
