@extends('layouts.master')

@section('title', 'Mis Pacientes')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mis Pacientes</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Pacientes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="pacientesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Última Consulta</th>
                            <th>Diagnóstico</th>
                            <th>Estado</th>
                            <th>Próxima Cita</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se cargarán dinámicamente con JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar DataTable
    var table = $('#pacientesTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route("doctor.pacientes.data") }}',
            dataSrc: 'data'
        },
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'ultima_consulta' },
            { data: 'diagnostico' },
            { data: 'estado' },
            { data: 'proxima_cita' },
            {
                data: 'acciones',
                orderable: false,
                searchable: false
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });
});
</script>
@endpush
@endsection
