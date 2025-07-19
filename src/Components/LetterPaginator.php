<?php

namespace Invent\LaravelComponents\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LetterPaginator extends Component
{
    /**
     * Create a new component instance.
     */

    public function __construct(public $selected = 'A')
    {
       
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('invent::components.letter-paginator');
    }
}
