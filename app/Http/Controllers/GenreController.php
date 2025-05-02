<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return view('superadmin.dashboard', compact('genres')); // Cambia a superadmin.dashboard
    }

    public function create()
    {
        return view('genres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
        ]);

        Genre::create($request->only('name'));
        return redirect()->route('superadmin.dashboard')->with('success', 'Género creado.');
    }

    public function show(Genre $genre)
    {
        $songs = $genre->songs()->with('artist')->get();
        return view('genres.show', compact('genre', 'songs'));
    }

    public function edit(Genre $genre)
    {
        return view('genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        $genre->update($request->only('name'));
        return redirect()->route('superadmin.dashboard')->with('success', 'Género actualizado.');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('superadmin.dashboard')->with('success', 'Género eliminado.');
    }
}