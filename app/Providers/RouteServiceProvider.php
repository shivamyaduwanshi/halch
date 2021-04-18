<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $namespaceUserApiController     = 'App\Http\Controllers\Api\User';

    protected $namespaceMarchantApiController = 'App\Http\Controllers\Api\Marchant';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapUserApiRoutes();

        $this->mapMarchantApiRoutes();

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "user api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapUserApiRoutes()
    {
        Route::prefix('api/user')
             ->middleware('api')
             ->namespace($this->namespaceUserApiController)
             ->group(base_path('routes/userapi.php'));
    }

     /**
     * Define the "user api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapMarchantApiRoutes()
    {
        Route::prefix('api/marchant')
             ->middleware('api')
             ->namespace($this->namespaceMarchantApiController)
             ->group(base_path('routes/marchantapi.php'));
    }


}
