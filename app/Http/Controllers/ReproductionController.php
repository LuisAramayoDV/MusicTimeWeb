<?php

namespace App\Http\Controllers;

use App\Models\Reproduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReproductionController extends Controller
{public function store(Request $request)
    {
        $request->validate(['song_id' => 'required|exists:songs,id']);
    
        Reproduction::create([
            'song_id' => $request->song_id,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);
    
        // Aquí podrías actualizar el contador
        $song = \App\Models\Song::find($request->song_id);
        $song->increment('plays_count');
    
        return response()->json(['message' => 'Reproducción registrada']);
    }
}
