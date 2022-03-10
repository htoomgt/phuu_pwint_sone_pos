<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SystemSettingsController extends GenericController
{
    public function __construct()
    {
        parent::__construct();
    }

    /***
     * Display a listing of the system settings.
     * @param Builder $builder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Htoo Maung Thait
     * @since 2022-03-09
     *
     */
    public function showListPage(Builder $builder)
    {
        $this->setPageTitle("System Settings", "Show List");
        // $statusUpdateUrl = route('productMeasureUnit.statusUpdateById');
        $deleteUrl = route('system_settings.deleteById');
        $dataTableId = "dtSystemSetting";
        $dataTableIdSelector = "#".$dataTableId;

        if (request()->ajax()) {
            $model = SystemSetting::query();

            return DataTables::of($model)
            ->addColumn('actions', function(SystemSetting $systemSetting)use($deleteUrl, $dataTableIdSelector){
                $actions = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onClick="productMeasureUnitEdit('.$systemSetting->id.')"

                            >
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <a class="dropdown-item" href="#" onclick = "dtDeleteRow('.$systemSetting->id.', `'.$deleteUrl.'`, `'.$dataTableIdSelector.'`)">
                        <i class="far fa-trash-alt"></i>
                        Delete
                    </a>
                  </div>
                </div>
            ';



            return  $actions;
            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('Y-m-d');
            })
            ->editColumn('updated_at', function ($request) {
                return $request->created_at->format('Y-m-d');
            })
            ->rawColumns(['actions'])
            ->toJson();

        }

        $dataTable = $builder->columns([
            ['data' => 'id', 'title' => 'Id'],
            ['data' => 'actions', 'title' => 'Actions', 'searchable' => false, 'orderable' => false],
            ['data' => 'setting_name', 'title' => 'Setting Name'],
            ['data' => 'setting_value', 'title' => 'Setting Value'],
            ['data' => 'created_at', 'title' => 'Created At'],
            ['data' => 'updated_at', 'title' => 'Updated At'],
        ])
            ->parameters([
                "paging" => true,
                "searchDelay" => 350,
                "responsive" => true,
                "autoWidth" => false,
                "order" => [
                    [0, 'desc'],
                ],
                "columnDefs" => [
                    ["width" => "5%", "targets" => 0],
                    ["width" => "10%", "targets" => 1],
                    ["width" => "20%", "targets" => 2],
                    ["width" => "25%", "targets" => 3],
                    ["width" => "20%", "targets" => 4],
                    ["width" => "20%", "targets" => 5],

                ],

            ]);


        return view('system-settings.system-settings-show-list', compact(['dataTable', 'dataTableId']));
    }

    public function addSystemSetting()
    {

    }

    public function getSystemSettingById(Request $request)
    {

    }

    public function updateSystemSettingById(Request $request)
    {

    }

    public function deleteSystemSettingById(Request $request)
    {
        try {
            // get system settings Id
            $id = $request->id;

            // validate the id
            if($id == ""){
                $this->setResponseInfo('invalid','', ['id' => 'System Settingn Id is required'],'','');
            }

            if($this->validStatus){
                // delete System settings by Id
                $status = SystemSetting::where('id', $id)->delete();

                if($status){
                    $this->setResponseInfo('success', 'Your record has been deleted successfully', [], '', '');
                }
                else{
                    $this->setResponseInfo('error', '', [], '', 'Your record has not been deleted');
                }

            }
            else{
                return response()->json($this->response, $this->httpStatus);
            }





        } catch (\Throwable $th) {
            $errorMsg = 'Delete Error Message : '.$th->getMessage();
            Log::error($errorMsg);
            $this->setResponseInfo('error', '', [], '',$errorMsg);
        }

        // respond to client
        return response()->json($this->response, $this->httpStatus);

    }
}
