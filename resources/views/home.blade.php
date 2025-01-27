@extends('layouts.master')

@section('title', 'Página de Inicio')

@section('content')
<div class="jumbotron text-center">
    <h1 class="display-4">Bienvenido al sitio web del Hospital Isidro Ayora</h1>
    <p class="lead"> Gestion de Pacientes y Doctores</p>
    <hr class="my-4">
</div>
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/slider1.jpg') }}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Imagen 1</h5>
                <p>Descripción de la imagen 1.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/slider2.jpg') }}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Imagen 2</h5>
                <p>Descripción de la imagen 2.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/slider3.jpg') }}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Imagen 3</h5>
                <p>Descripción de la imagen 3.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Paciente</h5>
                    <p class="card-text">Acceso para pacientes.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Administrador</h5>
                    <p class="card-text">Acceso para administradores.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Personal</h5>
                    <p class="card-text">Acceso para personal.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

