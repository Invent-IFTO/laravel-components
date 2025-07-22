<?php

namespace Invent\LaravelComponents\Components;

use Closure;
use Illuminate\Contracts\View\View;
use JeroenNoten\LaravelAdminLte\View\Components\Form\Button;

class DynamicModal extends Button
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $url, public $method = "get", public $title = "", $label = null, $type = 'button', $theme = 'default', $icon = null)
    {
        parent::__construct($label, $type, $theme, $icon);
        if (empty($this->title)) {
            $this->title = $label;
        }
        if (old(key: 'dynamic_modal_url') && session()->has('errors')) {           
              session()->put('dynamic_modal_errors', session()->get('errors'));
             session()->put('dynamic_modal_old_input', session()->get('_old_input'));
        }else{
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
