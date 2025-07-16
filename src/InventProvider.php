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
    }

    public function register() {}
}