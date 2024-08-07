<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HousingCardMobile extends Component
{
    public $housing;

    public function __construct($housing)
    {
        $this->housing = $housing;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.housing-card-mobile');
    }
}
