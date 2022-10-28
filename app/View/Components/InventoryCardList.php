<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InventoryCardList extends Component
{
    public $cardDisplayWidth;

    public $cardHeader;

    public $cardHeight;

    public $cardData;

    public $labelName;

    public $labelQty;

    public $dataIndex;

    public $url;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $cardDisplayWidth = 'col-md-4', 
        $cardHeader, 
        $cardHeight, 
        $cardData, 
        $labelName, 
        $labelQty = NULL, 
        $dataIndex,
        $url
    )
    {
        $this->cardDisplayWidth = $cardDisplayWidth;
        $this->cardHeader = $cardHeader;
        $this->cardHeight = $cardHeight;
        $this->cardData = $cardData;
        $this->labelName = $labelName;
        $this->labelQty = $labelQty;
        $this->dataIndex = $dataIndex;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inventory-card-list');
    }
}
