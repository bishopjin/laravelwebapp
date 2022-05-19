<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FooterMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $developer;

    public function __construct($dev)
    {
        $this->developer = $dev;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.footermenu');
    }
}
