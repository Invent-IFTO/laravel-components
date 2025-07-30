<?php

namespace Invent\LaravelComponents\Components;

use Closure;
use Illuminate\Contracts\View\View;
use JeroenNoten\LaravelAdminLte\View\Components\Form\Input;

class PreviewFaIcons extends Input
{
    /**
     * Create a new component instance.
     */

     public function __construct(
        $name, $id = null, $label = null, $igroupSize = null, $labelClass = null,
        $fgroupClass = null, $igroupClass = null, $disableFeedback = null,
        $errorKey = null, $enableOldSupport = null){
            parent::__construct($name,$id,$label,$igroupSize,$labelClass,$fgroupClass,$igroupClass,$disableFeedback, $errorKey, $enableOldSupport);
        }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('invent::components.preview-fa-icons');
    }
}
