<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Datatable extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $tableData;

    public $tableName;

    public $tableHeader;

    public $dataKey;

    public function __construct($data, $title, $header, $tData)
    {
        $this->tableData = $data;
        $this->tableName = $title;
        $this->tableHeader = $header;
        $this->dataKey = $tData;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.datatable');
    }
}
