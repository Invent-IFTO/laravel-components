<?php

namespace Invent\LaravelComponents\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DynamicModalErrorPropagation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('dynamic_modal_errors')) {
            session()->now('errors', value: session()->get('dynamic_modal_errors'));
            view()->share('errors', session()->get('dynamic_modal_errors'));
            session()->forget('dynamic_modal_errors');
            session()->now('_old_input', session()->get('dynamic_modal_old_input'));
            session()->forget('dynamic_modal_old_input');
        }
        return $next($request);
    }
}
