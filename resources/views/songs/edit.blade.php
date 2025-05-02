@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Canción</h1>
    <form action="{{ route('songs.update', $song->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $song->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="artist">Artista</label>
            <input type="text" name="artist" id="artist" class="form-control @error('artist') is-invalid @enderror" value="{{ old('artist', $song->artist->name) }}" required>
            @error('artist')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="genre_id">Género</label>
            <select name="genre_id" id="genre_id" class="form-control @error('genre_id') is-invalid @enderror" required>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}" {{ old('genre_id', $song->genre_id) == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>
            @error('genre_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="audio">Archivo de audio (dejar en blanco para mantener el actual)</label>
            <input type="file" name="audio" id="audio" class="form-control @error('audio') is-invalid @enderror" accept=".mp3,.wav,.ogg">
            @error('audio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Portada (dejar en blanco para mantener la actual)</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection