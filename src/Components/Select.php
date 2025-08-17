<?php

namespace Invent\LaravelComponents\Components;


use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;
use \JeroenNoten\LaravelAdminLte\View\Components\Form\Select as AdminSelect;

class Select extends AdminSelect
{
    
    public $options;

    public $selected;


    public $config;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $name,
        $id = null,
        $label = null,
        $igroupSize = null,
        $labelClass = null,
        $fgroupClass = null,
        $igroupClass = null,
        $disableFeedback = null,
        $errorKey = null,
        $enableOldSupport = true,
        public $value = null,
        $options = [],
        $valueField = 'id',
        $labelField = 'value',
        $filter = null,
        public $placeholder = null,
        public null|string $dinamycSelectUrl = null,
        public null|string $controlSelectId = null,
        public bool $preloadSelect = true
    ) {
        $enableOldSupport = ($enableOldSupport == false) ? null : $enableOldSupport;
        parent::__construct(
            $name,
            $id,
            $label,
            $igroupSize,
            $labelClass,
            $fgroupClass,
            $igroupClass,
            $disableFeedback,
            $errorKey,
            $enableOldSupport,
        );

        if (is_array($options)) {
            $this->options = collect($options);
        } else if (is_string($options) && class_exists($options) && is_subclass_of($options, UnitEnum::class)) {
            $this->options = collect($options::cases())->pluck('value', 'value');
        } else if (is_string($options) && class_exists($options) && is_subclass_of($options, Model::class)) {
            $query = $options::query();
            if ($filter) {
                $query = $filter($query);
            }
            $this->options = $query->get()->pluck($labelField,$valueField);
        } else {
            throw new \InvalidArgumentException('Invalid options provided');
        }
        $this->selected = $this->value;

    }

    public function isSelected($value){
        if(is_array($this->selected)){
            return in_array($value,$this->selected);
        }
        return $this->selected == $value;
    }

    public function selectDinamic()
    {
        return isset($this->dinamycSelectUrl) && isset($this->controlSelectId);
    }
    public function preloadSelect()
    {
        return isset($this->dinamycSelectUrl) && isset($this->controlSelectId) && $this->preloadSelect;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('invent::components.select');
    }
}
