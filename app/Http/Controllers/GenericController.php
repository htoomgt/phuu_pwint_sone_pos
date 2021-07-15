<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GenericController extends Controller
{
    protected  $response;

    protected $httpStatus;

    protected $validStatus;

    public function __construct()
    {
        $this->response['status'] = 'unknown';
        $this->response['messages'] = [];
        $this->response['data'] = [];
        $this->httpStatus = 0;
        $this->validStatus = false;
    }

    protected function setPageTitle($pageTitle = "", $lvl2PageTitle = "")
    {
        session()->put('page_title', $pageTitle);
        session()->put('lvl2_page_title', $lvl2PageTitle);
    }

    protected function setResponseInfo(
        $result_status = 'success',
        $custom_request_success_msg = 'Your request has been proceeded successfully!',
        $custom_invalid_msg = [],
        $custom_no_data_msg = 'No record is founded!',
        $custom_request_fail_msg = 'Your request cannot be done!'
    )
    {
        if($result_status == 'success'){
            $this->response['status'] = 'success';
            $this->httpStatus = Response::HTTP_OK;
            $this->response['messages'] = array_merge($this->response['messages'], ['request_msg'=>$custom_request_success_msg]);
        }
        elseif($result_status == 'invalid')
        {
            $this->response['status'] = 'invalid';
            $this->httpStatus = Response::HTTP_UNPROCESSABLE_ENTITY ;
            $this->response['messages'] = array_merge($this->response['messages'], $custom_invalid_msg);
        }
        elseif($result_status == 'no data')
        {
            $this->response['status'] = 'no data';
            $this->httpStatus = Response::HTTP_OK ;
            $this->response['messages'] = array_merge($this->response['messages'], $custom_no_data_msg);
        }
        else{
            $this->response['status'] = 'fail';
            $this->httpStatus = Response::HTTP_SERVICE_UNAVAILABLE;
            $this->response['messages'] = array_merge($this->response['messages'], ['request_msg' => $custom_request_fail_msg]);
        }
    }
}
