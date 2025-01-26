@extends('layouts.master')

@section('title', 'Recordatorios')

@section('content')
<div class="container">
    <h1>Recordatorios</h1>
    <ul>
        @foreach($recordatorios as $recordatorio)
            <li>{{ $recordatorio->descripcion }} - {{ $recordatorio->fecha }}</li>
        @endforeach
    </ul>
</div>
@endsection
