<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * La ruta a la que se redirige después del login.
     *
     * @var string|null
     */
    public const HOME = '/home';

    /**
     * Define tu lógica personalizada de redirección aquí.
     */
    protected function redirectTo(Request $request): string
    {
        if (auth()->check() && auth()->user()->isSuperAdmin()) {
            return route('superadmin.dashboard');
        }

        return self::HOME;
    }

    /**
     * Define tus rutas aquí.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
