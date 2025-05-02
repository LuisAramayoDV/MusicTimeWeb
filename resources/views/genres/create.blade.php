@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Género</h1>
    <form action="{{ route('genres.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre del Género</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="{{ route('superadmin.dashboard') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection