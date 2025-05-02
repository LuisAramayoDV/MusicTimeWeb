<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Genre;

class SuperAdminController extends Controller
{
    public function superAdminDashboard()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Acceso no autorizado');
        }

        $songs = Song::all();
        $genres = Genre::all();
        return view('superadmin.dashboard', compact('songs', 'genres'));
    }
}