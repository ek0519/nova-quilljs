<?php

namespace Ek0519\Quilljs;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        $this->loadMigrationsFrom(__DIR__.'/migrations/2019_10_09_104240_add_trix_table');

        $this->publishes([
            __DIR__ . '/config/quilljs.php' => config_path('quilljs.php'),
        ]);

        $this->publishes([
            __DIR__ . '/migrations/' => database_path('migrations'),
        ], 'migrations');

        Nova::serving(function (ServingNova $event) {
            Nova::script('quilljs', __DIR__.'/../dist/js/field.js');
            Nova::style('quilljs', __DIR__.'/../dist/css/field.css');
        });

        
    }
    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
                ->prefix('nova-vendor/quilljs')
                ->namespace('Ek0519\Quilljs\Http\Controllers')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

}
