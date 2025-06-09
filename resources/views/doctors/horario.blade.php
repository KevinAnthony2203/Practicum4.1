@extends('layouts.master')

@section('title', 'Gestión de Horarios')

@section('content')
<main class="container">
    <header class="mb-4">
        <h1>Gestión de Horarios</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Horarios</li>
            </ol>
        </nav>
    </header>

    <div class="row">
        <div class="col-md-8">
            <section class="card shadow-sm">
                <header class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Calendario de Horarios</h2>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light" id="prev-week">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-light" id="next-week">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </header>

                <div class="card-body">
                    <div id="calendar-week" class="mb-4">
                        <!-- El calendario semanal se renderizará aquí -->
                    </div>

                    <template id="day-template">
                        <article class="day-column">
                            <header class="day-header">
                                <h3 class="day-name h6"></h3>
                                <time class="day-date small text-muted"></time>
                            </header>
                            <div class="time-slots">
                                <!-- Las franjas horarias se generarán dinámicamente -->
                            </div>
                        </article>
                    </template>
                </div>
            </section>
        </div>

        <aside class="col-md-4">
            <!-- Formulario de Horario -->
            <form id="horario-form" class="card shadow-sm mb-4" action="{{ route('doctor.horario.store') }}" method="POST">
                @csrf
                <header class="card-header bg-info text-white">
                    <h2 class="h5 mb-0">Configurar Horario</h2>
                </header>
                <div class="card-body">
                    <fieldset>
                        <legend class="h6">Información del Horario</legend>

                        <div class="mb-3">
                            <label for="dia" class="form-label">Fecha</label>
                            <input type="date" id="dia" name="dia" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                            <input type="time" id="hora_inicio" name="hora_inicio"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="hora_fin" class="form-label">Hora de Fin</label>
                            <input type="time" id="hora_fin" name="hora_fin"
                                class="form-control" required>
                        </div>
                    </fieldset>
                </div>
                <footer class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Horario
                    </button>
                </footer>
            </form>

            <!-- Leyenda -->
            <article class="card shadow-sm">
                <header class="card-header bg-secondary text-white">
                    <h2 class="h5 mb-0">Leyenda</h2>
                </header>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">
                            <span class="badge bg-success">D</span>
                        </dt>
                        <dd class="col-sm-9">Disponible</dd>

                        <dt class="col-sm-3">
                            <span class="badge bg-danger">R</span>
                        </dt>
                        <dd class="col-sm-9">Reservado</dd>

                        <dt class="col-sm-3">
                            <span class="badge bg-warning">P</span>
                        </dt>
                        <dd class="col-sm-9">Pendiente</dd>

                        <dt class="col-sm-3">
                            <span class="badge bg-info">B</span>
                        </dt>
                        <dd class="col-sm-9">Bloqueado</dd>
                    </dl>
                </div>
            </article>
        </aside>
    </div>
</main>
@endsection

@push('styles')
<style>
.day-column {
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    margin-bottom: 1rem;
}

.day-header {
    background-color: #f8f9fa;
    padding: 0.5rem;
    border-bottom: 1px solid #dee2e6;
    text-align: center;
}

.time-slots {
    padding: 0.5rem;
}

.time-slot {
    padding: 0.25rem;
    margin-bottom: 0.25rem;
    border-radius: 0.25rem;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

.time-slot:hover {
    background-color: rgba(0,0,0,0.05);
}

.time-slot.disponible {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
}

.time-slot.reservado {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
}

.time-slot.pendiente {
    background-color: #fff3cd;
    border: 1px solid #ffeeba;
}

.time-slot.bloqueado {
    background-color: #cce5ff;
    border: 1px solid #b8daff;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicialización del calendario
    const calendar = new Calendar('#calendar-week', {
        // Configuración del calendario
    });

    // Manejo del formulario
    const form = document.getElementById('horario-form');
    const diaInput = document.getElementById('dia');
    const horaInicioInput = document.getElementById('hora_inicio');
    const horaFinInput = document.getElementById('hora_fin');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Obtener los valores del formulario
        const formData = {
            dia: diaInput.value,
            activo: true,
            inicio: horaInicioInput.value,
            fin: horaFinInput.value
        };

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (data.success) {
                // Mostrar mensaje de éxito
                alert('Horario guardado exitosamente');
                // Recargar el calendario
                calendar.render();
            } else {
                // Mostrar mensaje de error
                alert(data.message || 'Error al guardar el horario');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al guardar el horario');
        }
    });

    // Navegación del calendario
    document.getElementById('prev-week').addEventListener('click', () => calendar.prevWeek());
    document.getElementById('next-week').addEventListener('click', () => calendar.nextWeek());
});

class Calendar {
    constructor(selector, config) {
        this.element = document.querySelector(selector);
        this.config = config;
        this.currentDate = new Date();
        this.render();
    }

    async render() {
        try {
            const response = await fetch(`/doctor/horario/semana/${this.currentDate.toISOString().split('T')[0]}`);
            const data = await response.json();

            if (data.success) {
                this.renderWeek(data.horarioSemanal);
            } else {
                console.error('Error al cargar el horario:', data.message);
            }
        } catch (error) {
            console.error('Error al cargar el horario:', error);
        }
    }

    renderWeek(horarioSemanal) {
        this.element.innerHTML = '';

        Object.entries(horarioSemanal).forEach(([dia, horario]) => {
            const dayElement = document.createElement('div');
            dayElement.className = 'day-column';

            dayElement.innerHTML = `
                <header class="day-header">
                    <h3 class="day-name h6">${dia}</h3>
                    <time class="day-date small text-muted">${horario.fecha}</time>
                </header>
                <div class="time-slots">
                    ${horario.activo ? `
                        <div class="time-slot disponible">
                            ${horario.inicio} - ${horario.fin}
                            ${horario.tiene_citas ? `<span class="badge bg-warning">${horario.citas_count} citas</span>` : ''}
                        </div>
                    ` : '<div class="time-slot">No disponible</div>'}
                </div>
            `;

            this.element.appendChild(dayElement);
        });
    }

    prevWeek() {
        this.currentDate.setDate(this.currentDate.getDate() - 7);
        this.render();
    }

    nextWeek() {
        this.currentDate.setDate(this.currentDate.getDate() + 7);
        this.render();
    }
}
</script>
@endpush
