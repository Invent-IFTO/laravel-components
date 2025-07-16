<?php

namespace Invent\LaravelComponents\Components;

use Illuminate\View\Component;

class DynamicModal extends Component
{
    public $tipo;
    public $mensagem;

    public function __construct($tipo = 'info', $mensagem = '')
    {
        $this->tipo = $tipo;
        $this->mensagem = $mensagem;
    }

    public function render()
    {
        return view('invent::components.dynamic-modal');
    }
}