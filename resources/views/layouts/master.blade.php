<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hospital Isidro Ayora')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hospital</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('patients.index') }}">Pacientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('doctors.index') }}">Doctores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('secretarias.index') }}">Secretarías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gerencias.index') }}">Gerencias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('disponibilidades.index') }}">Disponibilidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('citas.index') }}">Citas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('estadisticas.index') }}">Estadísticas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('historials.index') }}">Historiales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notificaciones.index') }}">Notificaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('recordatorios.index') }}">Recordatorios</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        @yield('content')
    </div>
    <footer class="bg-light text-center text-lg-start mt-4 py-3">
        <div class="text-center text-muted">
            &copy; {{ date('Y') }} Hospital Isidro Ayora.
            <br>
            <p>Autor: Kevin Anthony Mosquera</p>
        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
