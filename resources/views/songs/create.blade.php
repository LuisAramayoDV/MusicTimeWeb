@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Subir Nueva Canción</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Título de la canción</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="artist" class="form-label">Artista</label>
            <input type="text" name="artist" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="genre_id" class="form-label">Género</label>
            <select name="genre_id" class="form-control" required>
                <option value="">Seleccione un género</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="audio" class="form-label">Archivo de Audio (MP3, WAV, OGG)</label>
            <input type="file" name="audio" class="form-control" accept=".mp3,.wav,.ogg" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Portada (opcional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Subir Canción</button>
    </form>
</div>
@endsection
