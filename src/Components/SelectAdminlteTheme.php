<?php

namespace Invent\LaravelComponents\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Invent\LaravelComponents\Enums\AdminlteThemes;
use JeroenNoten\LaravelAdminLte\View\Components\Form\InputGroupComponent;
use JeroenNoten\LaravelAdminLte\View\Components\Form\Traits\OldValueSupportTrait;


class SelectAdminlteTheme extends InputGroupComponent
{

    use OldValueSupportTrait;

    /**
     * Create a new component instance.
     */

    public $themes;


    public function __construct(
        $name,
        $themes = null,
        $id = null,
        $label = null,
        $igroupSize = null,
        $labelClass = null,
        $fgroupClass = null,
        $igroupClass = null,
        $disableFeedback = null,
        $errorKey = null,
        $enableOldSupport = true
    ) {
        parent::__construct(
            $name,
            $id,
            $label,
            $igroupSize,
            $labelClass,
            $fgroupClass,
            $igroupClass,
            $disableFeedback,
            $errorKey
        );

        $this->enableOldSupport = isset($enableOldSupport);
        $this->themes = $themes ?? array_column(AdminlteThemes::cases(),'value');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('invent::components.select-adminlte-theme');
    }
}
