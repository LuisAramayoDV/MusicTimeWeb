@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Subir Nueva Canción</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Título de la canción</label>
            <input type="text" name="title" id="title" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required value="{{ old('title') }}">
            @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="artist" class="block text-gray-700 text-sm font-bold mb-2">Artista</label>
            <input type="text" name="artist" id="artist" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required value="{{ old('artist') }}">
            @error('artist')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="genre_id" class="block text-gray-700 text-sm font-bold mb-2">Género</label>
            <select name="genre_id" id="genre_id" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">Seleccione un género</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>
            @error('genre_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="audio" class="block text-gray-700 text-sm font-bold mb-2">Archivo de Audio (MP3, WAV, OGG)</label>
            <input type="file" name="audio" id="audio" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" accept=".mp3,.wav,.ogg" required>
            @error('audio')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Portada (opcional)</label>
            <input type="file" name="image" id="image" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
            @error('image')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Subir Canción</button>
    </form>
</div>
@endsection