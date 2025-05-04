<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ReproductionController;

// Ruta principal (home)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas de autenticación
Auth::routes();

// Ruta de home después del login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rutas de login y registro (personalizadas, aunque Auth::routes() ya las incluye)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.submit');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Playlist
    Route::post('/playlist/add/{song}', [PlaylistController::class, 'addSong'])->name('playlists.add');
    Route::get('/playlist', [PlaylistController::class, 'index'])->name('playlists.index');

    // Superadmin
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'superAdminDashboard'])->name('superadmin.dashboard');

    // Recurso para canciones, excluyendo show
    Route::resource('songs', SongController::class)->except(['show']);

    // Recurso completo para géneros
    Route::resource('genres', GenreController::class);
});

// Rutas públicas
Route::get('/songs/most-played', [SongController::class, 'mostPlayed'])->name('songs.mostPlayed');
Route::post('/songs/{id}/play', [SongController::class, 'play'])->name('songs.play');
Route::post('/reproductions', [ReproductionController::class, 'store'])->name('reproductions.store');

// Playlists
Route::resource('playlists', PlaylistController::class);
Route::post('playlists/{playlist}/songs', [PlaylistController::class, 'addSong'])->name('playlists.songs.store');
Route::delete('playlists/{playlist}/songs/{song}', [PlaylistController::class, 'removeSong'])->name('playlists.songs.destroy');