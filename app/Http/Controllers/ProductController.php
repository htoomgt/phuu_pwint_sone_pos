<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\ProductService;
use App\Repositories\ProductReadRepository;
use App\Repositories\ProductWriteRepository;
use App\Http\Controllers\Traits\ProductControllerTrait;
use App\Repositories\ProductCriteriaChangeLogWriteRepository;


class ProductController extends GenericController implements ResourceFunctions
{
    use ProductControllerTrait;

    /***
     * Single Responsibility Principle (SRP)
     * by using trait to separate the logic, using trait instead of using smaller class, because it is easier to maintain
     * by using GenericController to separate the logic
     * by only serving the product related function
     *
     * Open/Closed Principle (OCP)
     * by implementing ResourceFunction
     *
     * Liskov Substitution Principle (LSP)
     * by exntending the GenericController
     *
     * Interface Segregation Principle (ISP)
     * by using read / write dependency injection
     *
     * Dependency Inversion Principle (DIP)
     * by using constructor dependency injection
     *
     * Best Practices
     * - KISS
     * - DRY
     * - Skinny Controller, Fat Model with repository pattern and trait
     * - Business logic should be in service class
     * - validation with function at trait
     * - use eloquent than raw query
     * - mass assignment
     * - comment code with prefer / useful description
     * - function description or doc
     * - using config file
     * - use Ioc container or facades
     * - store date in standard foramt
     * -
     */

    private $productReadRepository;
    private $productWriteRepository;
    private $productCriteriaChangeLogWriteRepository;

    public function __construct(
        ProductReadRepository $productReadRepository,
        ProductWriteRepository $productWriteRepository,
        ProductCriteriaChangeLogWriteRepository $productCriteriaChangeLogWriteRepository
    ) {

        parent::__construct();
        $this->productReadRepository = $productReadRepository;
        $this->productWriteRepository = $productWriteRepository;
        $this->productCriteriaChangeLogWriteRepository = $productCriteriaChangeLogWriteRepository;
    }


    /**
     * To show product list view page
     * @return View
     * @since 2021-07-19
     * @author Htoo Maung Thait
     */
    public function showListPage(Builder $builder)
    {
        $this->setPageTitle("Manage Product", "Product List");
        $statusUpdateUrl = route('product.statusUpdateById');
        $deleteUrl = route('product.deleteById');
        $dataTableId = "#dtProduct";

        if (request()->ajax()) {

            $model = $this->productReadRepository->productShowList();

            return $this->getDataTableResponseData($model, $statusUpdateUrl, $deleteUrl, $dataTableId);
        }

        $dataTable = $this->getDataTableStructure($builder);

        return view('product.product-show-list', compact('dataTable'));
    }

    /**
     * To show product create view page
     * @return View
     * @since 2021-07-19
     * @author Htoo Maung Thait
     */
    public function create(): View
    {
        $this->setPageTitle("Manage Product", "Product Create");
        return view('product.product-create');
    }

    /**
     * To create new product
     * @param Request $request
     * @return JsonResponse
     * @since 2021-07-19
     * @author Htoo Maung Thait
     */
    public function addNew(Request $request): JsonResponse
    {

        $this->validateProductCreateRequest($request);

        try {

            $dataFormPost = $request->all();
            $authUserId = Auth::user()->id;

            $dataFormPost['created_by'] = $authUserId;
            $dataFormPost['updated_by'] = $authUserId;


            $product = $this->productWriteRepository->create($dataFormPost);

            if (!empty($product) && $product->id > 0) {
                $this->setResponseInfo('success', 'Your product has been created successfully');
            } else {
                $this->setResponseInfo('fail');
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }

    /**
     * To get the product data row by Id
     * @return JsonResponse
     * @since 2021-07-19
     * @author Htoo Maung Thait
     */
    public function getDataRowById(Request $request): JsonResponse
    {
        $this->validateProductFindById($request);

        try {

            $product = $this->productReadRepository->findById($request->id);



            if (!empty($product)) {
                $this->setResponseInfo('success');
                $this->response['data'] = $product;
            } else {
                $this->setResponseInfo('no-data');
                $this->response['data'] = [];
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            $this->response['data'] = [];
        }

        return response()->json($this->response, $this->httpStatus);
    }

    /**
     * To response view page for product edit
     * @return View
     * @since 2021-07-19
     * @author Htoo Maung Thait
     */
    public function edit(Product $product)
    {

        $product = $this->productReadRepository->findById($product->id);


        $this->setPageTitle("Manage Product", "Product Edit");
        return view('product.product-edit', compact('product'));
    }


    /**
     * To update product by Id
     * @param Request $request
     * @return JsonResponse
     * @since 2021-07-19
     * @author Htoo Maung Thait
     */
    public function updateById(Request $request): JsonResponse
    {
        $this->validateUpdateByIdRequest($request);

        try {
            $product = Product::find($request->id);

            // Product Criteria change log recording for changes
            (new ProductService)->productCriteriaChangeLogSaving($product, $request, $this->productCriteriaChangeLogWriteRepository);


            $columnsExcept = ['_token'];

            $dataToUpdate = collect($request->all())->except($columnsExcept)->toArray();


            $status = $this->productWriteRepository->updateById($dataToUpdate, $request->id);



            if ($status) {
                $this->setResponseInfo('success', 'Your product has been updated successfully!');
            } else {
                $this->setResponseInfo('fail');
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }

    /**
     * To update status by requested status
     * @param Request $request
     * @return JsonResponse
     * @since 2021-07-19
     * @author Htoo Maung Thait
     */
    public function statusUpdateById(Request $request): JsonResponse
    {

        $this->validateProductStatusUpdateRequest($request);

        try {


            $status = $this->productWriteRepository->updateById([
                'status' => $request->statusToChange
            ], $request->id);

            if ($status) {
                $this->setResponseInfo('success');
            } else {
                $this->setResponseInfo('fail');
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail');
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }

    /**
     * To delete product record by Id
     * @param Request $request
     * @return JsonResponse
     * @since 2021-07-19
     */
    public function deleteById(Request $request): JsonResponse
    {

        $this->validateProductDeleteRequest($request);

        try {

            $status = $this->productWriteRepository->deleteById($request->id);

            if ($status) {
                $this->setResponseInfo('success', 'Your product has been deleted successfully');
            } else {
                $this->setResponseInfo('fail');
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail');
            Log::error($th->getMessage());
        }

        return response()->json($this->response, $this->httpStatus);
    }

    /**
     * To get the child product row by parent product Id
     * @param Request $request
     * @return JsonResponse
     * @since 2022-01-02
     */
    public function getProductByParentProductId(Request $request)
    {

        $this->validateGetProductByParentId($request);


        try {

            $product = $this->productReadRepository->findByBreakdownParentId($request->id);


            if (!empty($product)) {
                $this->setResponseInfo('success');
                $this->response['data'] = $product;
            } else {
                $this->setResponseInfo('no-data');
                $this->response['data'] = [];
            }
        } catch (\Throwable $th) {
            $this->setResponseInfo('fail', '', '', '', $th->getMessage());
            $this->response['data'] = [];
        }

        return response()->json($this->response, $this->httpStatus);
    }
}
