@extends('layouts.master')

@section('title', 'Crear Nuevo Usuario')

@section('content')
<main class="container">
    <header class="mb-4">
        <h1>Crear Nuevo Usuario</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Administración</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear Usuario</li>
            </ol>
        </nav>
    </header>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ route('admin.users.store') }}" class="card shadow-sm">
                @csrf

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
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="identificacion" class="form-label">Identificación</label>
                                <input type="text" class="form-control @error('identificacion') is-invalid @enderror"
                                    id="identificacion" name="identificacion" value="{{ old('identificacion') }}">
                                @error('identificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="addressField">
                            <div class="col-md-12">
                                <label for="address" class="form-label">Dirección</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address') }}">
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control"
                                    id="password_confirmation" name="password_confirmation" required>
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
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
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
                                <option value="{{ $value }}" {{ old('specialty') == $value ? 'selected' : '' }}>
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
                                    {{ old('active', true) ? 'checked' : '' }}>
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
                                    id="send_welcome_email" name="send_welcome_email" value="1"
                                    {{ old('send_welcome_email', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="send_welcome_email">
                                    Enviar Email de Bienvenida
                                </label>
                            </div>
                            <div class="form-text">
                                Se enviará un correo con las credenciales de acceso.
                            </div>
                        </div>
                    </fieldset>
                </div>

                <footer class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Crear Usuario
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
    const addressField = document.getElementById('address');
    const phoneField = document.getElementById('phone');
    const identificacionField = document.getElementById('identificacion');

    function toggleFields() {
        const selectedRole = roleSelect.value;

        // Ocultar todos los campos opcionales
        specialtyField.style.display = 'none';
        specialtySelect.required = false;
        addressField.required = false;
        phoneField.required = false;
        identificacionField.required = false;

        // Mostrar campos según el rol
        if (selectedRole === 'doctor') {
            specialtyField.style.display = 'block';
            specialtySelect.required = true;
            identificacionField.required = true;
        } else if (selectedRole === 'patient') {
            addressField.required = true;
            phoneField.required = true;
            identificacionField.required = true;
        }
    }

    roleSelect.addEventListener('change', toggleFields);
    toggleFields(); // Para manejar el estado inicial
});
</script>
@endpush
@endsection
