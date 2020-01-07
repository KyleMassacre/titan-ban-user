<?php

namespace KyleMassacre\BanUser\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use KyleMassacre\BanUser\Support\BanUser;

class BanUserServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        app()->bind(BanUser::class, function() {
            return new BanUser();
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('banuser.php'),
        ], 'banuser.config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'banuser'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/vendor/banuser');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'banuser.views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/extensions/BanUser';
        }, \Config::get('view.paths')), [$sourcePath]), 'banuser');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/banuser');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'banuser');
        } else {
            $this->loadTranslationsFrom(__DIR__. '/../Resources/lang', 'banuser');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(__DIR__.'/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [BanUser::class];
    }
}
