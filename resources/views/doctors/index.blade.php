@extends ('layouts.master')

@section ('title', 'Listado de Doctores')

@section ('content')
    <h2>Listado de Doctores</h2>
    <table class="table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Especialidad</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            // Código en php para consulta base de datos de la tabla doctores.
            @foreach($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->id }}</td>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->last_name }}</td>
                    <td>{{ $doctor->specialty }}</td>
                    <td>
                        <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display:inline;">
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
