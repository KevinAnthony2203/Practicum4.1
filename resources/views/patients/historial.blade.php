@extends('layouts.master')

@section('title', 'Historial Médico')

@section('content')
<div class="container">
    <h1>Historial Médico</h1>
    <ul>
        @foreach($historials as $historial)
            <li>{{ $historial->descripcion }} - {{ $historial->fecha }}</li>
        @endforeach
    </ul>
</div>
@endsection
