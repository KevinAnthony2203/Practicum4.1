@extends('layouts.master')

@section('title', 'Dashboard del Paciente')

@section('content')
<div class="container">
    <h1>Bienvenido, Paciente</h1>

    <!-- Contenido del dashboard del paciente -->
    <div class="row">
        <!-- Información del Paciente -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Información del Paciente
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Apellido:</strong> {{ Auth::user()->last_name }}</p>
                    <p><strong>Fecha de Nacimiento:</strong> {{ Auth::user()->birth_date }}</p>
                    <p><strong>Edad:</strong> {{ Auth::user()->age }}</p>
                    <p><strong>Contacto:</strong> {{ Auth::user()->contacto }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Citas Médicas -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Citas Médicas
                </div>
                <div class="card-body">
                    <!-- Aquí puedes listar las citas médicas del paciente -->
                    <ul>
                        <li>Cita con el Dr. Ejemplo - 10/10/2023 a las 10:00 AM</li>
                        <li>Cita con el Dr. Ejemplo - 15/10/2023 a las 2:00 PM</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Historial Médico -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Historial Médico
                </div>
                <div class="card-body">
                    <!-- Aquí puedes mostrar el historial médico del paciente -->
                    <p>Historial médico del paciente...</p>
                </div>
            </div>
        </div>

        <!-- Recordatorios -->
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    Recordatorios
                </div>
                <div class="card-body">
                    <!-- Aquí puedes listar los recordatorios del paciente -->
                    <ul>
                        <li>Recordatorio: Tomar medicamento a las 8:00 AM</li>
                        <li>Recordatorio: Asistir a la cita médica a las 10:00 AM</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
