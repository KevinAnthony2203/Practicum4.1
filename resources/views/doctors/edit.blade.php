@extends('layouts.master')

@section('title', 'Editar Doctor')

@section('content')
    <h1>Edit Doctor</h1>
    <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="id">Id:</label>
        <input type="text" name="id" value="{{ $doctor->id }}" required><br>
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $doctor->name }}" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="{{ $doctor->last_name }}" required><br>
        <label for="specialty">Specialty:</label>
        <input type="text" name="specialty" value="{{ $doctor->specialty }}" required><br>
        <button type="submit">Update</button>
    </form>
@endsection
