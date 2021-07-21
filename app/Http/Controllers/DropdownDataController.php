<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductMeasureUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class DropdownDataController extends GenericController
{
    /**
     * To list all user role with name search
     * @author Htoo Maung Thait
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllRoles(Request $request):JsonResponse
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

    /**
     * To list all product categories  with name search
     * @author Htoo Maung Thait
     * @param Request $request
     * @return JsonResponse
     * @since 2021-07-20
     */
    public function getAllProductCategories(Request $request):JsonResponse
    {
        try {
            $productCategory = ProductCategory::query()
                        ->where('name', 'LIKe', "%{$request->search}%")
                        ->get();
            if($productCategory->count() > 0)
            {
                $this->setResponseInfo('success', 'Your product categories can be searched!');
                $this->response['data'] = $productCategory;
            }
            else{
                $this->setResponseInfo('no data', '', '', 'Product categories cannot be search!');
                $this->response['data'] = [];
            }


        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            $this->response['data'] = [];
        }

        return response()->json($this->response, $this->httpStatus);
    }

    /**
     * To list all product measure units  with name search
     * @author Htoo Maung Thait
     * @param Request $request
     * @return JsonResponse
     * @since 2021-07-20
     */
    public function getProductMeasureUnits(Request $request)
    {
        try {
            $productCategory = ProductMeasureUnit::query()
                        ->where('name', 'LIKe', "%{$request->search}%")
                        ->get();
            if($productCategory->count() > 0)
            {
                $this->setResponseInfo('success', 'Your product measure unit can be searched!');
                $this->response['data'] = $productCategory;
            }
            else{
                $this->setResponseInfo('no data', '', '', 'Product measure unit cannot be search!');
                $this->response['data'] = [];
            }


        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            $this->response['data'] = [];
        }

        return response()->json($this->response, $this->httpStatus);
    }

    /**
     * To list all products with name search
     * @author Htoo Maung Thait
     * @param Request $request
     * @return JsonResponse
     * @since 2021-07-21
     */
    public function getAllProducts(Request $request)
    {
        try {
            $productCategory = Product::query()
                        ->where('name', 'LIKe', "%{$request->search}%")
                        ->get();
            if($productCategory->count() > 0)
            {
                $this->setResponseInfo('success', 'Your products can be searched!');
                $this->response['data'] = $productCategory;
            }
            else{
                $this->setResponseInfo('no data', '', '', 'Product cannot be search!');
                $this->response['data'] = [];
            }


        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            $this->response['data'] = [];
        }

        return response()->json($this->response, $this->httpStatus);
    }

}
