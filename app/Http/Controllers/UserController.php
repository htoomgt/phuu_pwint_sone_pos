<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ResourceFunctions;
use Illuminate\Http\Request;
use App\Http\Controllers\GenericController;
use Yajra\DataTables\Html\Builder;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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

            $model = User::query()->orderBy('id', 'DESC');

            return DataTables::of($model)
                ->addColumn('actions', function(User $user){
                    $actions = '
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bars"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#"
                                onclick="loadAddEditModal(`edit`,'.$user->id.')"
                                data-toggle="modal"
                                data-target="#teacher_add_edit"
                                >
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                        <a class="dropdown-item" href="#" onclick = "deleteUser('.$user->id.')">
                            <i class="far fa-trash-alt"></i>
                            Delete
                        </a>
                      </div>
                    </div>
                ';



                return  $actions;
                })
                ->addColumn('role', function($request){
                    $roles = $request->getRoleNames();
                    return Str::upper($roles[0]);
                })
                ->editColumn('status', function(User $user){
                    $displayStatus = '';
                    $statusAction = '';

                    if($user->status == 'active'){
                        $displayStatus = 'Active';
                        $statusAction = '
                            <a class="dropdown-item" href="#" onclick="changeStatus(`'.$user->id.'`, `inactive` )">
                                Inactive
                            </a>
                        ';
                    }
                    else{
                        $displayStatus = 'inactive';
                        $statusAction = '
                            <a class="dropdown-item" href="#" onclick="changeStatus(`'.$user->id.'`, `active` )">
                                Active
                            </a>
                        ';
                    }

                    $statusColorClass = $displayStatus == "Active" ?  "btn-success": "btn-secondary";

                    return '<div class="dropdown">
                          <button class="btn '.$statusColorClass.' dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            '.$displayStatus.'
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            '.$statusAction.'
                          </div>
                        </div>';
                })
                ->editColumn('created_at', function($request){
                    return $request->created_at->format('Y-m-d');
                })
                ->addColumn('creator', function($request){
                    return $request->creator->full_name ?? '-';
                })
                ->addColumn('updater', function($request){
                    return $request->updater->full_name ?? '-';
                })
                ->editColumn('updated_at', function($request){
                    return $request->created_at->format('Y-m-d');
                })
                ->rawColumns(['actions','status'])
                ->toJson();
        }

        $dataTable = $builder->columns([
            ['data' => 'id', 'title' => 'Id'],
            ['data' => 'actions', 'title' => 'Actions'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'full_name', 'title' => 'Fullname'],
            ['data' => 'username', 'title' => 'Username'],
            ['data' => 'role', 'title' => 'Role'],
            ['data' => 'creator', 'title' => 'Created By'],
            ['data' => 'created_at', 'title' => 'Created At' ],
            ['data' => 'updater', 'title' => 'Updated By'],
            ['data' => 'updated_at', 'title' => 'Updated At'],
        ])
            ->parameters([
                "paging" => true,
                "searchDelay" => 350,
                "responsive" => true,
                "autoWidth" => false,
                "order" => [
                    [0, 'desc']
                ],
                "columnDefs" => [
                    ["width" => "5%", "targets" => 0],
                    ["width" => "10%", "targets" => 1],
                    ["width" => "10%", "targets" => 2],
                    ["width" => "10%", "targets" => 3],
                    ["width" => "10%", "targets" => 4],
                    ["width" => "10%", "targets" => 5],
                    ["width" => "10%", "targets" => 6],
                    ["width" => "5%", "targets" => 7],
                    ["width" => "10%", "targets" => 8],
                    ["width" => "5%", "targets" => 9],

                ]

            ]);


        return view('user.user-show-list', compact('dataTable'));
    }

    public function create()
    {

    }

    public function addNew(Request $request)
    {

    }


    public function getDataRowById(Request $request)
    {

    }

    public function edit(User $user)
    {

    }

    public function updateById(Request $request)
    {

    }

    public function statusUpdateById(Request $request)
    {
        $userId = $request->userId;
        $statusToChange = $request->statusToChange;

        try {
            $user = User::find($userId);
            $user->status = $statusToChange;
            $status = $user->save();
            if($status){
                $this->setResponseInfo('success');
            }
            else{
                $this->setResponseInfo('fail');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->setResponseInfo('fail');
        }



        return response()
            ->json($this->response, $this->httpStatus);
    }

    public function deleteById(Request $request)
    {
        $id = $request->id;

        try {
            $user = User::find($id);

            $status = $user->delete();

            if ($status) {
                $this->setResponseInfo('success');
            } else {
                $this->setResponseInfo('fail');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->setResponseInfo('fail');
        }

        return response()
            ->json($this->response, $this->httpStatus);

    }
}
