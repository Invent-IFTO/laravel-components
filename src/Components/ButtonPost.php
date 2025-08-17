<?php

namespace Invent\LaravelComponents\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Psy\Output\Theme;

class ButtonPost
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
        return view('invent::button-post');
    }
}
