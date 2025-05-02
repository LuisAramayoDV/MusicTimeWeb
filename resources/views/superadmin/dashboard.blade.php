@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bienvenido, SuperAdmin</h1>
    <p>Desde aquí puedes gestionar canciones y géneros.</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Gestión de canciones -->
    <h2>Canciones</h2>
    <a href="{{ route('songs.create') }}" class="btn btn-primary mb-3">Agregar Canción</a>
    @if ($songs->isEmpty())
        <p>No hay canciones disponibles.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Artista</th>
                    <th>Género</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($songs as $song)
                    <tr>
                        <td>{{ $song->title ?? 'Sin título' }}</td>
                        <td>{{ $song->artist->name ?? 'Sin artista' }}</td>
                        <td>{{ $song->genre->name ?? 'Sin género' }}</td>
                        <td>
                            <a href="{{ route('songs.edit', $song->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('songs.destroy', $song->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Gestión de géneros -->
    <h2>Géneros</h2>
    <form action="{{ route('genres.store') }}" method="POST" class="mb-3">
        @csrf
        <div class="form-group">
            <label for="name">Nuevo Género</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-2">Agregar Género</button>
    </form>

    @if ($genres->isEmpty())
        <p>No hay géneros disponibles.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genres as $genre)
                    <tr>
                        <td>{{ $genre->name }}</td>
                        <td>
                            <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection