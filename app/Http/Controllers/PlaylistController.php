<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Requiere autenticación para todas las acciones
    }

    // Listar todas las playlists del usuario autenticado
    public function index()
    {
        $playlists = Auth::user()->playlists;
        return view('playlists.index', compact('playlists'));
    }

    // Mostrar formulario para crear una nueva playlist
    public function create()
    {
        return view('playlists.create');
    }

    // Guardar una nueva playlist
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Auth::user()->playlists()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('playlists.index')->with('success', 'Playlist creada correctamente.');
    }

    // Mostrar una playlist específica con sus canciones
    public function show(Playlist $playlist)
    {
        $this->authorize('view', $playlist); // Solo el dueño puede ver la playlist
        $songs = Song::all(); // Para el formulario de agregar canciones
        return view('playlists.show', compact('playlist', 'songs'));
    }

    // Agregar una canción a una playlist
    public function addSong(Request $request, Playlist $playlist)
    {
        $this->authorize('update', $playlist); // Solo el dueño puede modificar

        $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);

        // Evitar duplicados
        if (!$playlist->songs()->where('song_id', $request->song_id)->exists()) {
            $playlist->songs()->attach($request->song_id);
            return redirect()->route('playlists.show', $playlist)->with('success', 'Canción añadida a la playlist.');
        }

        return redirect()->route('playlists.show', $playlist)->with('error', 'La canción ya está en la playlist.');
    }

    // Eliminar una canción de una playlist
    public function removeSong(Playlist $playlist, Song $song)
    {
        $this->authorize('update', $playlist); // Solo el dueño puede modificar

        $playlist->songs()->detach($song->id);
        return redirect()->route('playlists.show', $playlist)->with('success', 'Canción eliminada de la playlist.');
    }

    // Eliminar una playlist
    public function destroy(Playlist $playlist)
    {
        $this->authorize('delete', $playlist); // Solo el dueño puede eliminar

        $playlist->delete();
        return redirect()->route('playlists.index')->with('success', 'Playlist eliminada correctamente.');
    }
}