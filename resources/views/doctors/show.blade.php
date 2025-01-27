@extends('layouts.master')

@section('title', 'Detalles del Doctor')

@section('content')
    <h1>Detalles del Doctor</h1>
    <p><strong>Id:</strong> {{ $doctor->id }}</p>
    <p><strong>Name:</strong> {{ $doctor->name }}</p>
    <p><strong>Last Name:</strong> {{ $doctor->last_name }}</p>
    <p><strong>Specialty:</strong> {{ $doctor->specialty }}</p>
    <a href="{{ route('doctors.index') }}">Back to List</a>
@endsection
