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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class UserController extends GenericController implements ResourceFunctions
{
    /**
     * To show list page with datatable
     * @author Htoo Maung Thait
     * @return \Illuminate\View\View
     */
    public function showListPage(Builder $builder)
    {

        $authUser = User::find(Auth::user()->id);
        $authUserRole =  $authUser->getRoleNames()[0];


        $this->setPageTitle("Manage User", "User List");

        if (request()->ajax()){



            $orderDirection = request()->order[0]['dir'];
            $orderColumnIndex = request()->order[0]['column'];
            $searchValue = request()->search['value'] ?? '';
            // $limit = request('length');
            // $start = request('start');

            $model = User::query()
                        ->selectRaw('users.*');
                        $model->join('model_has_roles as mhr', 'users.id', '=', 'mhr.model_id');
                        $model->where('mhr.model_type', 'App\Models\User');
                        $model->join('roles as r', 'r.id', '=', 'mhr.role_id');
                        $model->selectRaw('r.name as role_name');
                        $model->join('users as uc', 'users.created_by', '=', 'uc.id');
                        $model->selectRaw('uc.full_name as creator_name');
                        $model->join('users as uu', 'users.updated_by', '=', 'uu.id');
                        $model->selectRaw('uu.full_name as updater_name');






            if($authUserRole != "super-admin"){
                $model->whereHas('roles', function($q){
                    $q->where('name', '<>', 'super-admin');
                });
            }


            //For join table column order
            switch ($orderColumnIndex) {
                case 5:
                    $model->orderBy('r.name', $orderDirection);
                    break;
                case 6:
                    $model->orderBy('uc.full_name', $orderDirection);
                    break;
                case 8:
                    $model->orderBy('uu.full_name', $orderDirection);
                    break;

            }

            // $model->offset($start)->limit($limit);




            return DataTables::of($model)
                ->addColumn('actions', function(User $user){
                    $actions = '
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bars"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="'.route('user.edit', [$user->id]).'"

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
                ->filterColumn('role', function ($query, $keyword){

                    $query->whereRaw("r.name LIKE '%".$keyword."%'");

                })
                ->filterColumn('creator', function ($query, $keyword){

                    $query->whereRaw("uc.full_name LIKE '%".$keyword."%'");

                })
                ->filterColumn('updater', function ($query, $keyword){

                    $query->whereRaw("uu.full_name LIKE '%".$keyword."%'");

                })
                ->rawColumns(['actions','status'])
                ->toJson();
        }

        $dataTable = $builder->columns([
            ['data' => 'id', 'title' => 'Id'],
            ['data' => 'actions', 'title' => 'Actions', 'searchable' => false, 'orderable' => false],
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

    /**
     * To show creat new user page
     * @author Htoo Maung Thait
     * @return View
     * @since 2021-07-15
     */
    public function create():View
    {
        $this->setPageTitle("Manage User", "Create User");
        return view('user.user-create');
    }

    /**
     * To add new record of user
     * @author Htoo Maung Thait
     * @param Request $request
     * @return JsonResponse
     */
    public function addNew(Request $request) : JsonResponse
    {
        try {
            $userDataToCreate =  $request->all();
            $userDataToCreate['password'] = Hash::make($request->password);
            $userDataToCreate['created_by'] = Auth::user()->id;
            $userDataToCreate['updated_by'] = Auth::user()->id;


            $user = User::create($userDataToCreate);

            $user->assignRole($request->role);

            if($user){
                $this->setResponseInfo('success');
            }
            else{
                $this->setResponseInfo('fail');
            }

        } catch (\Throwable $th) {
            $this->setResponseInfo('fail');
            Log::error($th->getMessage());
        }

        return response()
            ->json($this->response, $this->httpStatus);
    }


    public function getDataRowById(Request $request)
    {

    }

    /**
     * To show edit page of user
     * @author Htoo Maung Thait
     * @return View
     */
    public function edit(User $user): View
    {
        $this->setPageTitle("Manage User", "Update User");
        return view('user.user-edit', compact('user'));
    }

    /**
     * To update validated user's data
     * @author Htoo Maung Thait
     * @param Request $request
     * @return JsonResponse
     */
    public function updateById(Request $request): JsonResponse
    {
        try {
            $user = User::find($request->user_id);
            $userRole = $request->role;

            $columnsExcept = ['_token', 'role', 'current_password','password', 'confirmed_password', 'user_id', 'chk_change_password'];

            if($request->chk_change_password){
                $columnsExcept = array_diff($columnsExcept, "password");
            }

            $dataToUpdate = collect($request->all())->except($columnsExcept)->toArray();

            $status = User::whereId($request->user_id)->update($dataToUpdate);

            $userCurrentRoles = $user->getRoleNames();
            foreach($userCurrentRoles as $cRole){
                $user->removeRole($cRole);
            }
            $user->assignRole($userRole);

            if($status){
                $this->setResponseInfo('success');
            }
            else{
                $this->setResponseInfo('fail');
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail','','','',$th->getMessage());
            Log::error($th->getMessage());
        }

        return response()
            ->json($this->response, $this->httpStatus);
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

    /**
     * To check username existance at database table of users for unique purpose validation
     * @author Htoo Maung Thait
     * @return
     */
    public function usernameUniqueCheck(Request $request)
    {
        try {
            $userCount = User::query()
                ->where('id', '<>', $request->id)
                ->where('username', $request->username)
                ->count();


            if($userCount > 0){
                $this->setResponseInfo('success');
                $this->response['data'] = ['found' => true];
            }
            else{
                $this->setResponseInfo('success');
                $this->response['data'] = ['found' => false];
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail');
            $this->response['data'] = ['found' => false];
            $this->response['message'] = $th->getMessage();
            Log::error('message : '. $th->getMessage() );
        }

        return response()
            ->json($this->response, $this->httpStatus);
    }

    /**
     * To check user input current password for related user password value in hash
     * @author Htoo Maung Thait
     * @param Request $request
     * @return JsonResponse
     */
    public function checkCurrentPassword(Request $request): JsonResponse
    {
        try {
            $user = User::find($request->id);

            if(Hash::check($request->current_password, $user->password)){
                $this->setResponseInfo('success');
                $this->response['data'] = ['same' => true];
            }
            else{
                $this->setResponseInfo('success');
                $this->response['data'] = ['same' => false];
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail');
            $this->response['data'] = ['same' => false];
            Log::error('message : '. $th->getMessage() );
        }

        return response()
            ->json($this->response, $this->httpStatus);
    }


}
