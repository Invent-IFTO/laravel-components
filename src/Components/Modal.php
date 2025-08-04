<?php

namespace Invent\LaravelComponents\Components;

use \JeroenNoten\LaravelAdminLte\View\Components\Tool\Modal as ModalAdminlte;

class Modal extends ModalAdminlte
{
    /**
     * The available modal sizes.
     *
     * @var array
     */
    protected $mSizes = ['sm', 'lg', 'xl', 'fullscreen'];

}
