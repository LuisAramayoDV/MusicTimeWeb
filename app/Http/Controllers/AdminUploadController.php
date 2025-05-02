<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminUploadController extends Controller
{
    public function create()
    {
        return view('admin.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'genre_id' => 'required|exists:genres,id',
            'audio' => 'required|file|mimes:mp3,wav',
            'cover_image' => 'nullable|image',
        ]);

        $audioPath = $request->file('audio')->store('songs');
        $imagePath = $request->hasFile('cover_image')
            ? $request->file('cover_image')->store('covers')
            : null;

        Song::create([
            'title' => $request->title,
            'artist_id' => $request->artist_id,
            'genre_id' => $request->genre_id,
            'audio_path' => $audioPath,
            'cover_image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Canción subida correctamente.');
    }
}
