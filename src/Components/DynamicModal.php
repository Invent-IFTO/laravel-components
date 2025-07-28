<?php

namespace Invent\LaravelComponents\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DynamicModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if (old(key: 'dynamic_modal_url') && old('dynamic_modal_method') && session()->has('errors')) {
            session()->put('dynamic_modal_errors', session()->get('errors'));
            session()->put('dynamic_modal_old_input', session()->get('_old_input'));
        } else {
            session()->forget('dynamic_modal_errors');
            session()->forget('dynamic_modal_old_input');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('invent::components.dynamic-modal');
    }
}
