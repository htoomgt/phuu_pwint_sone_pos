<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class DropdownDataController extends GenericController
{
    public function getAllRoles(Request $request)
    {
        try {
            $roles = Role::query()
                ->where('name', 'LIKE', "%{$request->search}%")
                ->get();

            if($roles){
                $this->setResponseInfo('success');
                $this->response['data']  = $roles;
            }
            else{
                $this->setResponseInfo('no data');
                $this->response['data']  = [];
            }

        } catch (\Throwable $th) {
            $this->setResponseInfo('fail');
            Log::error($th->getMessage());
        }


        return response()
            ->json($this->response, $this->httpStatus);


    }
}
