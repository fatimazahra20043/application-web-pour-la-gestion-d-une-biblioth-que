<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Enregistrer le middleware admin
        $router = $this->app['router'];
        $router->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
    }
}
