@extends('layouts.master')

@section('title', 'Editar Perfil')

@section('content')
<main class="container">
    <header class="mb-4">
        <h1>Editar Perfil</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('patient.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar Perfil</li>
            </ol>
        </nav>
    </header>

    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="{{ route('patient.profile.update') }}" class="card shadow-sm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <header class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0">Información Personal</h2>
                </header>

                <div class="card-body">
                    <fieldset>
                        <legend class="h6">Datos Básicos</legend>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $patient->user->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="dni" class="form-label">Cédula</label>
                                <input type="text" class="form-control @error('dni') is-invalid @enderror"
                                    id="dni" name="dni" value="{{ old('dni', $patient->dni) }}" required>
                                @error('dni')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $patient->user->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $patient->phone) }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="h6">Información Médica</legend>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="blood_type" class="form-label">Tipo de Sangre</label>
                                <select class="form-select @error('blood_type') is-invalid @enderror"
                                    id="blood_type" name="blood_type">
                                    <option value="">Seleccione un tipo</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                    <option value="{{ $type }}" {{ old('blood_type', $patient->blood_type) == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('blood_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="birth_date" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                    id="birth_date" name="birth_date"
                                    value="{{ old('birth_date', $patient->birth_date?->format('Y-m-d')) }}">
                                @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="allergies" class="form-label">Alergias</label>
                            <textarea class="form-control @error('allergies') is-invalid @enderror"
                                id="allergies" name="allergies" rows="3">{{ old('allergies', $patient->allergies) }}</textarea>
                            <div class="form-text">Indique sus alergias conocidas, separadas por comas.</div>
                            @error('allergies')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="chronic_diseases" class="form-label">Enfermedades Crónicas</label>
                            <textarea class="form-control @error('chronic_diseases') is-invalid @enderror"
                                id="chronic_diseases" name="chronic_diseases" rows="3">{{ old('chronic_diseases', $patient->chronic_diseases) }}</textarea>
                            @error('chronic_diseases')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="h6">Contacto de Emergencia</legend>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="emergency_contact_name" class="form-label">Nombre del Contacto</label>
                                <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                    id="emergency_contact_name" name="emergency_contact_name"
                                    value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}">
                                @error('emergency_contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="emergency_contact_phone" class="form-label">Teléfono del Contacto</label>
                                <input type="tel" class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                    id="emergency_contact_phone" name="emergency_contact_phone"
                                    value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}">
                                @error('emergency_contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                </div>

                <footer class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                        <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </footer>
            </form>
        </div>

        <aside class="col-md-4">
            <article class="card shadow-sm mb-4">
                <header class="card-header bg-info text-white">
                    <h2 class="h5 mb-0">Foto de Perfil</h2>
                </header>
                <div class="card-body text-center">
                    <figure class="mb-3">
                        <img src="{{ $patient->profile_photo_url }}"
                            alt="Foto de perfil actual"
                            class="img-thumbnail rounded-circle"
                            style="width: 150px; height: 150px; object-fit: cover;">
                    </figure>
                    <form action="{{ route('patient.profile.photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="photo" class="form-label">Cambiar foto</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                id="photo" name="photo" accept="image/*">
                            @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-info text-white">
                            <i class="fas fa-upload"></i> Subir Foto
                        </button>
                    </form>
                </div>
            </article>

            <article class="card shadow-sm">
                <header class="card-header bg-warning">
                    <h2 class="h5 mb-0">Cambiar Contraseña</h2>
                </header>
                <div class="card-body">
                    <form action="{{ route('patient.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password" required>
                            @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control"
                                id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key"></i> Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </article>
        </aside>
    </div>
</main>
@endsection
