<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

interface ResourceFunctions
{
    public function showListPage(Builder $builder);

    public function addNew(Request $request);

    public function getDataRowById(Request $request);

    public function updateById(Request $request);

    public function statusUpdateById(Request $request);

    public function deleteById(Request $request);
}
