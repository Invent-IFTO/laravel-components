<?php

namespace Invent\LaravelComponents\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ButtonPost extends Component
{
    
    /**
     * Create a new component instance.
     */
    public function __construct(public string|null $action = null, public string $method = 'post', public bool $csrf = true, public array $hiddens = [], public string $theme = 'default')
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('invent::components.button-post');
    }
}
