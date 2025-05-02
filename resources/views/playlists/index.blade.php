@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Mis Playlists</h1>
        <a href="{{ route('playlists.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
            Crear Nueva Playlist
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($playlists->isEmpty())
        <p class="text-gray-400">No tienes playlists. ¡Crea una ahora!</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($playlists as $playlist)
                <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-white mb-2">{{ $playlist->name }}</h2>
                    <p class="text-gray-400 mb-4">{{ $playlist->songs->count() }} canciones</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('playlists.show', $playlist) }}" class="text-indigo-400 hover:text-indigo-600">Ver</a>
                        <form action="{{ route('playlists.destroy', $playlist) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta playlist?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600">Eliminar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection