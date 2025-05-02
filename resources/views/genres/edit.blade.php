@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Género</h1>
    <form action="{{ route('genres.update', $genre->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="name">Nombre del Género</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $genre->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('superadmin.dashboard') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection