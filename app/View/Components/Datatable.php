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

    public $newTableData;

    public $tableName;

    public $tableHeader;

    public $dataKey;

    public $hasRowNumber;

    public $hasEditButton; 

    public $hasAddButton;

    public $hasDeleteButton;

    public $hasViewButton;

    public $addLink;

    public $editLink;

    public $deleteLink;

    public $viewLink;

    public $deepRelation;

    public $rootRelationKey;

    public function __construct(
        $data, 
        $newTableData = NULL,
        $title, 
        $header, 
        $tData, 
        $hasRowNumber = false, 
        $hasEditButton = false, 
        $hasAddButton = false, 
        $hasDeleteButton = false,
        $hasViewButton = false,
        $addLink = NULL,
        $editLink = NULL,
        $deleteLink = NULL,
        $viewLink = NULL,
        $deepRelation = false,
        $rootRelationKey = NULL
    )
    {
        $this->tableData = $data;
        $this->newTableData = $newTableData;
        $this->tableName = $title;
        $this->tableHeader = $header;
        $this->dataKey = $tData;
        $this->hasRowNumber = $hasRowNumber;
        $this->hasEditButton = $hasEditButton;
        $this->hasAddButton = $hasAddButton;
        $this->hasDeleteButton = $hasDeleteButton;
        $this->hasViewButton = $hasViewButton;
        $this->addLink = $addLink;
        $this->editLink = $editLink;
        $this->deleteLink = $deleteLink;
        $this->viewLink = $viewLink;
        $this->deepRelation = $deepRelation;
        $this->rootRelationKey = $rootRelationKey;
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
