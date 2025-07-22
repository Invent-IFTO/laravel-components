<?php

namespace Invent\LaravelComponents;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class InventProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'invent');

        Blade::componentNamespace('Invent\\LaravelComponents\\Components', 'invent');
        $router = $this->app['router'];

        // Registra o alias
        $router->aliasMiddleware('invent.dynamic_modal_errors', \Invent\LaravelComponents\Http\Middleware\DynamicModalErrorPropagation::class);

        $this->loadTranslationsFrom(__DIR__ . '/lang', 'invent');

        // Se quiser publicar as traduções
        $this->publishes([
            __DIR__ . '/lang' => resource_path('lang/vendor/invent'),
        ], 'invent-translations');

    }

    public function register()
    {
    }
}