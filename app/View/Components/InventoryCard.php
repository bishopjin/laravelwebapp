<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InventoryCard extends Component
{
    public $linkAdd;

    public $linkView;

    public $count;

    public $role;

    public $cardLabel;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($linkView = null, $linkAdd = null, $count, $role, $cardLabel)
    {
        $this->linkView = $linkView;
        $this->linkAdd = $linkAdd;
        $this->count = $count;
        $this->role = $role;
        $this->cardLabel = $cardLabel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inventory-card');
    }
}
