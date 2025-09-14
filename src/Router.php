<?php

namespace Invent\LaravelComponents;

use Illuminate\Support\Facades\Route;
use Invent\LaravelComponents\Http\Controllers\Api\WebhookController;

class Router
{
    /**
     * Registra as rotas de webhook para o pacote.
     *
     * @param  array  $options
     * @return void
     */
    public static function webhooks(array $options = [])
    {
        // Define um prefixo padrão que pode ser sobrescrito pelas opções
        $prefix = $options['prefix'] ?? '';
        $prefix_name = $prefix ? trim($prefix, '.') : '';
        $name = $options['name'] ?? 'webhook';
        $uri = $options['uri'] ?? '/webhook';

        Route::group(['prefix' => $prefix, 'as' => "$prefix_name"], function () use ($name, $uri) {
            Route::post($uri, [WebhookController::class, 'index'])->name($name);
        });
    }
}