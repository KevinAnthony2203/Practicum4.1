@extends('layouts.master')

@section('title', 'Página de Inicio')

@section('content')
<main class="container">
    <header class="hero text-center py-5">
        <h1 class="display-4">Bienvenido al sitio web del Hospital Isidro Ayora</h1>
        <p class="lead">Gestión de Pacientes y Doctores</p>
        <hr class="my-4">
    </header>

    <section class="carousel-section">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" aria-label="Presentación de imágenes del hospital">
            <nav class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Diapositiva 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Diapositiva 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Diapositiva 3"></button>
            </nav>
            <div class="carousel-inner">
                <figure class="carousel-item active">
                    <img src="{{ asset('images/slider1.jpg') }}" class="d-block w-100" alt="Hospital Isidro Ayora - Vista Principal">
                    <figcaption class="carousel-caption d-none d-md-block">
                        <h2 class="h5">Instalaciones Modernas</h2>
                        <p>Contamos con la mejor infraestructura para su atención.</p>
                    </figcaption>
                </figure>
                <figure class="carousel-item">
                    <img src="{{ asset('images/slider2.jpg') }}" class="d-block w-100" alt="Personal Médico del Hospital">
                    <figcaption class="carousel-caption d-none d-md-block">
                        <h2 class="h5">Personal Calificado</h2>
                        <p>Nuestro equipo médico está altamente capacitado.</p>
                    </figcaption>
                </figure>
                <figure class="carousel-item">
                    <img src="{{ asset('images/slider3.jpg') }}" class="d-block w-100" alt="Equipamiento Médico Moderno">
                    <figcaption class="carousel-caption d-none d-md-block">
                        <h2 class="h5">Tecnología de Punta</h2>
                        <p>Equipamiento médico de última generación.</p>
                    </figcaption>
                </figure>
            </div>
            <nav class="carousel-controls">
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </nav>
        </div>
    </section>

    <section class="access-section mt-5">
        <h2 class="text-center mb-4">Accesos al Sistema</h2>
        <div class="row justify-content-center">
            <article class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="h5 card-title">Pacientes</h3>
                        <p class="card-text">Acceso para pacientes del hospital.</p>
                        <a href="{{ route('login') }}?tipo=paciente" class="btn btn-primary btn-lg" role="button">
                            Acceso Pacientes
                        </a>
                    </div>
                </div>
            </article>
            <article class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="h5 card-title">Personal del Hospital</h3>
                        <p class="card-text">Acceso para médicos, secretarias, gerencia y administradores.</p>
                        <a href="{{ route('login') }}?tipo=personal" class="btn btn-success btn-lg" role="button">
                            Acceso Personal
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </section>
</main>
@endsection
