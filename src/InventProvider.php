<?php

namespace Invent\LaravelComponents;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class InventProvider extends ServiceProvider
{

    protected array $commands =
        [
            \Invent\LaravelComponents\Console\Commands\AddChange::class,
            \Invent\LaravelComponents\Console\Commands\GerarManifestIcons::class,
            \Invent\LaravelComponents\Console\Commands\RevertLastVersion::class,
            \Invent\LaravelComponents\Console\Commands\VersionInfo::class,
            \Invent\LaravelComponents\Console\Commands\VersionSystem::class,
            \Invent\LaravelComponents\Console\Commands\InventLocalMod::class,
        ];


    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'invent');

        Blade::componentNamespace('Invent\\LaravelComponents\\Components', 'invent');
        Blade::component(\Invent\LaravelComponents\Components\Layouts\App::class, 'app');

        $router = $this->app['router'];

        // Registra o alias
        $router->aliasMiddleware('invent.dynamic_modal_errors', \Invent\LaravelComponents\Http\Middleware\DynamicModalErrorPropagation::class);

        $this->loadTranslationsFrom(__DIR__ . '/lang', 'invent');

        // Se quiser publicar as traduções
        $this->publishes([
            __DIR__ . '/lang' => resource_path('lang/vendor/invent'),
        ], 'invent-translations');

        $this->publishes([
            __DIR__ . '/config/invent.php' => config_path('invent.php'),
        ], 'invent-config');
        
        $this->publishes([
             __DIR__ . '/../resources/js'  => resource_path('vendor/invent/js'),
        ], 'invent-assets');

         $this->publishes([
             __DIR__ . '/../resources/js'  => resource_path('vendor/invent/js'),
        ], 'invent-public');
        



        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/invent.php',
            'invent'
        );
    }
}