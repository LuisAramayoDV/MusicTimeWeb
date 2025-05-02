<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::all();
        return view('admin.artists.index', compact('artists'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Artist::create($request->only('name'));
        return redirect()->back()->with('success', 'Artista creado correctamente.');
    }

    public function update(Request $request, Artist $artist)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $artist->update($request->only('name'));
        return redirect()->back()->with('success', 'Artista actualizado.');
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();
        return redirect()->back()->with('success', 'Artista eliminado.');
    }
}
