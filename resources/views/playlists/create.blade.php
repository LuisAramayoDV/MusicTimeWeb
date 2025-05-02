@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white mb-6">Crear Nueva Playlist</h1>

    <form action="{{ route('playlists.store') }}" method="POST" class="bg-gray-800 rounded-lg p-6 max-w-md">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-300 font-medium mb-2">Nombre de la Playlist</label>
            <input type="text" name="name" id="name" class="w-full bg-gray-700 text-white rounded-lg p-2" required>
            @error('name')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
            Crear Playlist
        </button>
    </form>
</div>
@endsection