<?php

namespace Invent\LaravelComponents\Components;

use Closure;
use Illuminate\Contracts\View\View;
use JeroenNoten\LaravelAdminLte\View\Components\Form\Button;

class ButtonConfirmModal extends Button
{

    public $title, $confirmLabel, $confirmTheme, $message, $placeholder, $feedback;

    /**
     * Create a new component instance.
     */    
    public function __construct(
        public $url, 
        public $method = "get", 
        $title = null, 
        $label = "", 
        $theme = 'info', 
        $icon = 'fas fa-check-square',
        $message = null,
        public $input = null,
        $confirmLabel = null,
        public $confirmIcon = 'fas fa-check',
        $confirmTheme = null,
        )
    {
        parent::__construct($label, 'button', $theme, $icon);
        $this->title = $title ?? __('invent::components.confirm-modal.request')."?";
        $this->confirmLabel = $confirmLabel ?? __('invent::components.confirm-modal.confirm');
        $this->confirmTheme = $confirmTheme ?? $theme;
        $this->message = $message ?? __('invent::components.confirm-modal.message');
        if($this->input){
            $this->message = $message ?? __('invent::components.confirm-modal.input',['attribute'=> $this->input]);
            $this->placeholder = __('invent::components.confirm-modal.placeholder');
            $this->feedback = __('invent::components.confirm-modal.invalid feedback');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('invent::components.button-confirm-modal');
    }
}
