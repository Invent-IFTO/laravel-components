<?php

namespace Invent\LaravelComponents\Components;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */

    public array $alerts;
    public function __construct(Session $session)
    {

        $this->alerts = [];
        $monitor = ['success', 'error', 'info', 'warning'];
        foreach ($monitor as $type) {
            $msg = $session->pull($type);
            if ($msg) {
                $this->alerts[$type] = $msg;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('invent::components.alert');
    }
}
