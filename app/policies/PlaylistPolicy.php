<?php

namespace App\Policies;

use App\Models\Playlist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlaylistPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede ver la playlist.
     */
    public function view(User $user, Playlist $playlist)
    {
        return $user->id === $playlist->user_id;
    }

    /**
     * Determina si el usuario puede actualizar la playlist.
     */
    public function update(User $user, Playlist $playlist)
    {
        return $user->id === $playlist->user_id;
    }

    /**
     * Determina si el usuario puede eliminar la playlist.
     */
    public function delete(User $user, Playlist $playlist)
    {
        return $user->id === $playlist->user_id;
    }
}