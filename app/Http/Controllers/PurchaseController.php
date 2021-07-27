<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PurchaseController extends GenericController implements ResourceFunctions
{
    public function showListPage(Builder $builder)
    {
        $this->setPageTitle("Manage Product", "Product Purchase List");
        $statusUpdateUrl = route('productPurchase.statusUpdateById');
        $deleteUrl = route('productPurchase.deleteById');
        $dataTableId = "#dtProductPurchase";

        if (request()->ajax()) {
            $model = Purchase::query()
                ->selectRaw('purchases.*')
                ->with(['details'])
                ->leftJoin('users as cu', 'purchases.created_by', '=', 'cu.id')
                ->leftJoin('users as uu', 'purchases.updated_by', '=', 'uu.id');

            return DataTables::of($model)
                ->addColumn('actions', function (Purchase $purchase)  use ($deleteUrl, $dataTableId) {
                    $actions = '
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="' . route('productPurchase.edit', [$purchase->id]) . '"

                            >
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="far fa-list-alt"></i>
                        View Purchased Item(s)
                    </a>
                    <a class="dropdown-item" href="#" onclick = "dtDeleteRow(' . $purchase->id . ', `' . $deleteUrl . '`, `' . $dataTableId . '`)">
                        <i class="far fa-trash-alt"></i>
                        Delete
                    </a>
                  </div>
                </div>
            ';

                    return $actions;
                })
                ->addColumn('item_count', function (Purchase $purchase) {
                    return $purchase->details->count();
                })
                ->orderColumn('item_count', function ($query, $order) {
                    //$query->orderBy('item_count', $order);
                })
                ->addColumn('creator', function (Purchase $purchase) {
                    return $purchase->creator->full_name;
                })
                ->filterColumn('creator', function ($query, $keyword) {
                    return $query->where('cu.full_name', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('creator', function ($query, $order) {
                    $query->orderBy('cu.full_name', $order);
                })
                ->addColumn('updater', function (Purchase $product) {
                    return $product->updater->full_name;
                })
                ->filterColumn('updater', function ($query, $keyword) {
                    return $query->where('uu.full_name', 'LIKE', "%{$keyword}%");
                })
                ->orderColumn('updater', function ($query, $order) {
                    $query->orderBy('uu.full_name', $order);
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
            ['data' => 'received_date', 'title' => 'received_date'],
            ['data' => 'item_count', 'title' => 'Item Count'],
            ['data' => 'creator', 'title' => 'Created By'],
            ['data' => 'created_at', 'title' => 'Created At'],
            ['data' => 'updater', 'title' => 'Updated By'],
            ['data' => 'updated_at', 'title' => 'Updated At'],
        ])->parameters([
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
                ["width" => "10%", "targets" => 2],
                ["width" => "10%", "targets" => 3],
                ["width" => "10%", "targets" => 4],
                ["width" => "10%", "targets" => 5],
                ["width" => "10%", "targets" => 6],
                ["width" => "5%", "targets" => 7],

            ],

        ]);

        return view('product-purchase.product-purchase-show-list', compact('dataTable'));
    }

    public function create()
    {
        $this->setPageTitle("Manage Product", "Product Purchase Create");
        return view('product-purchase.product-purchase-make');
    }

    public function addNew(Request $request)
    {

        try {
            $productIds = $request->product_id;
            $productCodes = $request->product_code;
            $quantities = $request->quantity;
            $productMeasureUnits = $request->product_measure_unit;
            $purchaseOrderDate = $request->purchase_order_date;

            $purchaseOrderDate = date('Y-m-d', strtotime($purchaseOrderDate));
            $itemCount = count($productIds);

            // insert into purchase table
            $productPurchase = Purchase::create([
                'received_date' => $purchaseOrderDate,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);

            // compose and insert into purchase detail
            foreach ($productIds as $index => $productId) {

                PurchaseDetail::create([
                    'product_id' => $productId,
                    'purchase_id' => $productPurchase->id,
                    'product_code' => $productCodes[$index],
                    'measure_unit' => $productMeasureUnits[$index],
                    'quantity' => $quantities[$index],
                ]);
            }

            $this->setResponseInfo('success', 'Your product purchase has been recorded successfully!');

        } catch (\Throwable$th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }

        // return with json as normal
        return response()->json($this->response, $this->httpStatus);

    }

    public function getDataRowById(Request $request)
    {

    }

    /**
     * To edtit the specific product purchase
     * @param int $id
     * @return View
     * @author Htoo Maung Thait
     * @since 2021-07-25
     */
    public function edit($id):View
    {
        $productPurchase = Purchase::query()
            ->with(['details' => function($q){
                return $q->with(['product']);
            }])
            ->whereId($id)->first();




        $this->setPageTitle("Manage Product", "Product Purchase Edit");
        return view('product-purchase.product-purchase-edit', compact('productPurchase'));
    }

    /**
     * To update product purchase
     * @author Htoo Maung Thait
     * @param Request $request
     * @return JsonResponse
     */
    public function updateById(Request $request):JsonResponse
    {

        try {
            $purchaseId = $request->purchase_id;
            $productIds = $request->product_id;
            $productCodes = $request->product_code;
            $quantities = $request->quantity;
            $productMeasureUnits = $request->product_measure_unit;
            $purchaseOrderDate = $request->purchase_order_date;
            $responseStatusMsg = 'fail';

            $purchaseOrderDate = date('Y-m-d', strtotime($purchaseOrderDate));

            $status = Purchase::whereId($purchaseId)->update([
                'received_date' => $purchaseOrderDate,
                'updated_by' => Auth::user()->id
            ]);



            foreach ($productIds as $index => $productId) {

                // For deletion of item
                PurchaseDetail::query()->where('purchase_id', $purchaseId)
                    ->whereNotIn('product_id', $productIds)->delete();


                // Get purchase detail
                $purchaseDetail = PurchaseDetail::query()->where('purchase_id', $purchaseId)
                    ->where('product_id', $productId)
                    ->first();


                // Update quantities for found product
                if($purchaseDetail){
                    $purchaseDetail->quantity = $quantities[$index];
                    $purchaseDetail->save();
                    $responseStatusMsg = 'success';
                }
                // Add product for new update
                else{

                    $purchaseDetailNew = PurchaseDetail::create([
                        'product_id' => $productId,
                        'purchase_id' => $purchaseId,
                        'product_code' => $productCodes[$index],
                        'measure_unit' => $productMeasureUnits[$index],
                        'quantity' => $quantities[$index],
                    ]);

                    if($purchaseDetailNew){
                        $responseStatusMsg = 'success';
                    }

                }


            }



            $this->setResponseInfo($responseStatusMsg, 'Your product purchase has been updated successfully!');



        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }


        return response()->json($this->response, $this->httpStatus);
    }

    public function statusUpdateById(Request $request)
    {

    }

    /**
     * To delete product purchase and it details using delete on cascade
     * @author Htoo Maung Thait
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteById(Request $request):JsonResponse
    {
        try {
            $status = Purchase::whereId($request->id)->delete();

            if($status){
                $this->setResponseInfo('success', 'Your purchase has been deleted successfullye');
            }
            else{
                $this->setResponseInfo('fail');
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }
}
