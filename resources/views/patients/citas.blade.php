@extends('layouts.master')

@section('title', 'Citas Médicas')

@section('content')
<div class="container">
    <h1>Citas Médicas</h1>
    <ul>
        @foreach($citas as $cita)
            <li>{{ $cita->descripcion }} - {{ $cita->fecha }} a las {{ $cita->hora }}</li>
        @endforeach
    </ul>
</div>
@endsection
