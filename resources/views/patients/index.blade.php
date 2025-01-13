@extends ('layouts.master')

@section ('title', 'Listado de Pacientes')

@section ('content')
    <h2>Listado de Pacientes</h2>
    <table class="table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de nacimiento</th>
                <th>Años</th>
                <th>Contacto</th>
                <th>Email</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            // Código en php para consulta base de datos de la tabla pacientes.
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->last_name }}</td>
                    <td>{{ $patient->birth_date }}</td>
                    <td>{{ $patient->age }}</td>
                    <td>{{ $patient->contacto }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>
                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
@endsection
