<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Reproduction;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    // Mostrar formulario para subir canción
    public function create()
    {
        $genres = Genre::all();
        return view('songs.create', compact('genres'));
    }

    // Guardar canción nueva
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'audio' => 'required|mimes:mp3,wav,ogg|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Crear o buscar artista
        $artist = Artist::firstOrCreate(['name' => $request->artist]);

        // Subir archivos
        $audioPath = $request->file('audio')->store('songs', 'public');
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('covers', 'public')
            : null;

        // Crear canción
        Song::create([
            'title' => $request->title,
            'artist_id' => $artist->id,
            'genre_id' => $request->genre_id,
            'audio_path' => $audioPath,
            'cover_image' => $imagePath,
        ]);

        return redirect('/home')->with('success', '¡Canción subida exitosamente!');
    }

    // Mostrar todas las canciones
    public function index()
    {
        $songs = Song::all();
        return view('songs.index', compact('songs'));
    }

    // Mostrar las canciones más escuchadas
    public function mostPlayed()
    {
        $songs = Song::orderBy('plays_count', 'desc')->take(10)->get();
        return view('songs.most_played', compact('songs'));
    }

    // Registrar reproducción de una canción
    public function play($id)
    {
        $song = Song::findOrFail($id);

        // Registrar reproducción
        Reproduction::create([
            'song_id' => $song->id,
            'user_id' => auth()->check() ? auth()->id() : null,
        ]);

        // Incrementar contador de reproducciones
        $song->increment('plays_count');

        return redirect()->back()->with('success', '¡Reproducción registrada!');
    }

    // Mostrar formulario para editar canción
    public function edit(Song $song)
    {
        $genres = Genre::all();
        return view('songs.edit', compact('song', 'genres'));
    }

    // Actualizar canción
    public function update(Request $request, Song $song)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'audio' => 'nullable|mimes:mp3,wav,ogg|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Actualizar artista
        $artist = Artist::firstOrCreate(['name' => $request->artist]);

        // Actualizar archivos si se proporcionan
        if ($request->hasFile('audio')) {
            // Eliminar archivo anterior
            if ($song->audio_path) {
                Storage::disk('public')->delete($song->audio_path);
            }
            $song->audio_path = $request->file('audio')->store('songs', 'public');
        }

        if ($request->hasFile('image')) {
            // Eliminar imagen anterior
            if ($song->cover_image) {
                Storage::disk('public')->delete($song->cover_image);
            }
            $song->cover_image = $request->file('image')->store('covers', 'public');
        }

        // Actualizar canción
        $song->update([
            'title' => $request->title,
            'artist_id' => $artist->id,
            'genre_id' => $request->genre_id,
            'audio_path' => $song->audio_path,
            'cover_image' => $song->cover_image,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', '¡Canción actualizada exitosamente!');
    }

    // Eliminar canción
    public function destroy(Song $song)
    {
        // Eliminar archivos asociados
        if ($song->audio_path) {
            Storage::disk('public')->delete($song->audio_path);
        }
        if ($song->cover_image) {
            Storage::disk('public')->delete($song->cover_image);
        }

        // Eliminar canción
        $song->delete();

        return redirect()->route('superadmin.dashboard')->with('success', '¡Canción eliminada exitosamente!');
    }
}