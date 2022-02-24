<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DataTableBlock extends Component
{
    public $dataTable = "";
    public string $dataTableHeader = "";
    public string $dataTableId = "";

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($dataTable, string $dataTableId, string $dataTableHeader, )
    {
        $this->dataTable = $dataTable;
        $this->dataTableId = $dataTableId;
        $this->dataTableHeader = $dataTableHeader;

    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.data-table-block');
    }
}
