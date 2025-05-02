<?php

namespace App\Providers;

use App\Models\Playlist;
use App\Policies\PlaylistPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Registrar la política de Playlist
        Gate::policy(Playlist::class, PlaylistPolicy::class);
    }
}