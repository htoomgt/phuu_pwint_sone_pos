<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ResourceFunctions;
use Illuminate\Http\Request;
use App\Http\Controllers\GenericController;
use Yajra\DataTables\Html\Builder;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class UserController extends GenericController implements ResourceFunctions
{
    /**
     * To show list page with datatable
     * @author Htoo Maung Thait
     * @return \Illuminate\View\View
     */
    public function showListPage(Builder $builder)
    {

        $this->setPageTitle("Manage User", "User List");
        if (request()->ajax()){
            $model = User::query();

            return DataTables::of($model)
                ->toJson();
        }

        $dataTable = $builder->columns([
            ['data' => 'id', 'title' => 'Id'],
            // ['data' => 'actions', 'title' => 'Actions'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'full_name', 'title' => 'Fullname'],
            ['data' => 'username', 'title' => 'Username'],
            // ['data' => 'creator_name', 'title' => 'Created By'],
            ['data' => 'created_at', 'title' => 'Created At' ],
            // ['data' => 'updater_name', 'title' => 'Updated By'],
            ['data' => 'updated_at', 'title' => 'Updated At'],
        ])
            ->parameters([
                "paging" => true,
                "searchDelay" => 350,
                "order" => [
                    [0, 'desc']
                ],

            ]);


        return view('user.user-show-list', compact('dataTable'));
    }

    public function addNew(Request $request)
    {

    }

    public function getDataRowById(Request $request)
    {

    }

    public function updateById(Request $request)
    {

    }

    public function statusUpdateById(Request $request)
    {

    }

    public function deleteById(Request $request)
    {

    }
}
