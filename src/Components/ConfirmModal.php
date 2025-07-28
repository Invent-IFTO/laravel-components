<?php

namespace Invent\LaravelComponents\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ConfirmModal extends Component
{

    /**
     * Create a new component instance.
     */    
    public function __construct(){
      
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('invent::components.confirm-modal');
    }
}
