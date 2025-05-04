<?php

namespace App\Providers;

use App\Models\Playlist;
use App\Policies\PlaylistPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
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

        // Forzar HTTPS en entornos que no sean local
        if ($this->app->environment('production', 'staging')) {
            URL::forceScheme('https');
        }
    }
}