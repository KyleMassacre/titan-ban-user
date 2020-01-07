<?php

namespace KyleMassacre\BanUser\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use KyleMassacre\BanUser\Http\Middleware\PlayableNotBannedMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'KyleMassacre\BanUser\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        app('router')->aliasMiddleware('playable_not_banned', PlayableNotBannedMiddleware::class);
        app('router')->pushMiddlewareToGroup('web', PlayableNotBannedMiddleware::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapRoutes();
    }

    /**
     * @return void
     */
    protected function mapRoutes()
    {
        Route::group([
            'namespace' => $this->moduleNamespace,
            'middleware' => [
                'web'
            ]
        ], function () {

            include __DIR__.'../../Routes/routes.php';

        });
    }
}
