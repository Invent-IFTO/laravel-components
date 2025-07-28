<?php

namespace Invent\LaravelComponents\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class App extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('invent::components.layouts.app');
    }
}
