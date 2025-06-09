<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hospital Isidro Ayora')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @if(env('APP_ENV') === 'local')
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @else
        <!-- Fallback para producción -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
    @endif

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* Estilos para el layout con sidebar */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            display: flex;
            flex: 1;
        }

        /* Estilos del sidebar */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed {
            width: 60px;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #333;
            transition: all 0.3s ease;
        }

        .sidebar-nav .nav-link:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }

        .sidebar-nav .nav-link.active {
            background-color: #e9ecef;
            color: #0d6efd;
            font-weight: 600;
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            padding: 20px;
            transition: all 0.3s ease;
        }

        @auth
        .main-content {
            margin-left: 260px;
        }

        .main-content-expanded {
            margin-left: 60px;
        }
        @endauth

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        @auth
            @include('layouts.sidebar')
        @endauth

        <div class="main-content">
            <header>
                <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                    <div class="container-fluid">
                        @auth
                        <button class="btn btn-link text-light d-lg-none me-2" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        @endauth
                        <a class="navbar-brand" href="#">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT6fqKFRJ92vL42UElzb1mo5MUFAtVmiu_jHQ&s"
                                 alt="Logo Hospital"
                                 height="30"
                                 class="d-inline-block align-text-top">
                            Hospital Isidro Ayora
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            @auth
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                                @csrf
                                                <button type="submit" class="btn btn-link text-danger p-0">
                                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            @endauth
                        </div>
                    </div>
                </nav>
            </header>

            @yield('content')

            <footer class="bg-light text-center text-lg-start mt-4 py-3">
                <div class="container">
                    <section class="text-center text-muted">
                        <p>&copy; {{ date('Y') }} Hospital Isidro Ayora.</p>
                        <p>Autor: Kevin Anthony Mosquera</p>
                    </section>
                </div>
            </footer>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Cerrar sidebar en móvil al hacer clic fuera
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });

            // Manejar redimensionamiento de ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
    @endauth
    @stack('scripts')
</body>
</html>
