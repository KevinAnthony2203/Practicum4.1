@extends('layouts.master')

@section('title', 'Editar Usuario')

@section('content')
<main class="container">
    <header class="mb-4">
        <h1>Editar Usuario</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Administración</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar Usuario</li>
            </ol>
        </nav>
    </header>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="card shadow-sm">
                @csrf
                @method('PUT')

                <header class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0">Información del Usuario</h2>
                </header>

                <div class="card-body">
                    <fieldset>
                        <legend class="h6">Datos Básicos</legend>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="h6">Cambiar Contraseña</legend>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                <div class="form-text">
                                    Dejar en blanco para mantener la contraseña actual.
                                </div>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control"
                                    id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="h6">Rol del Usuario</legend>

                        <div class="mb-3">
                            <label for="role" class="form-label">Seleccione un Rol</label>
                            <select class="form-select @error('role') is-invalid @enderror"
                                id="role" name="role" required>
                                <option value="">Seleccione un rol</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                                @endforeach
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="specialtyField" class="mb-3" style="display: none;">
                            <label for="specialty" class="form-label">Especialidad Médica</label>
                            <select class="form-select @error('specialty') is-invalid @enderror"
                                id="specialty" name="specialty">
                                <option value="">Seleccione una especialidad</option>
                                @foreach($specialties as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('specialty', $doctorSpecialty) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                            @error('specialty')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="h6">Estado</legend>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input"
                                    id="active" name="active" value="1"
                                    {{ old('active', $user->email_verified_at ? true : false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">
                                    Usuario Activo
                                </label>
                            </div>
                            <div class="form-text">
                                Los usuarios inactivos no podrán acceder al sistema.
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input"
                                    id="force_password_change" name="force_password_change" value="1"
                                    {{ old('force_password_change', false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="force_password_change">
                                    Forzar Cambio de Contraseña
                                </label>
                            </div>
                            <div class="form-text">
                                El usuario deberá cambiar su contraseña en el próximo inicio de sesión.
                            </div>
                        </div>
                    </fieldset>

                    <div class="alert alert-info">
                        <h6 class="alert-heading">Información Adicional</h6>
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Creado:</dt>
                            <dd class="col-sm-8">
                                <time datetime="{{ $user->created_at }}">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </time>
                            </dd>

                            <dt class="col-sm-4">Estado:</dt>
                            <dd class="col-sm-8">
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Verificado</span>
                                @else
                                    <span class="badge bg-warning">Pendiente</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>

                <footer class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </footer>
            </form>
        </div>
    </div>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const specialtyField = document.getElementById('specialtyField');
    const specialtySelect = document.getElementById('specialty');

    function toggleSpecialtyField() {
        if (roleSelect.value === 'doctor') {
            specialtyField.style.display = 'block';
            specialtySelect.required = true;
        } else {
            specialtyField.style.display = 'none';
            specialtySelect.required = false;
        }
    }

    roleSelect.addEventListener('change', toggleSpecialtyField);
    toggleSpecialtyField(); // Para manejar el estado inicial
});
</script>
@endpush
@endsection
