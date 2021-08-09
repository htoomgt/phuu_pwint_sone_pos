@extends('layouts.master')

@section('title',  session('lvl2_page_title'))


@section('content')
<div>

</div>
    {{-- Content Header (Page Header) --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{session('lvl2_page_title')}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">{{session('page_title')}}</li>
                        <li class="breadcrumb-item active">{{session('lvl2_page_title')}}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    {{-- /Content Header (Page Header) --}}

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="frmCreateProduct">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="txtProductName">Product Name: </label>
                                        <input type="text" class="form-control" id="txtProductName" placeholder="Product Name"
                                            name="name" autocomplete="off">
                                        <small id="txtProductNameInfo" class="form-text text-muted">To display in sale and report.</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="txtUsername">Myanmar Name: </label>
                                        <input type="text" class="form-control" id="txtMyanmarName" placeholder="မြန်မာနာမည်"
                                            name="myanmar_name" autocomplete="off">
                                        <small id="txtMyanmarNameInfo" class="form-text text-muted">To search and display for myanmar usage</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="txtProductCode">Product Code: </label>
                                        <input type="text" class="form-control" id="txtProductCode" placeholder="Product Code"
                                            name="product_code" autocomplete="off">
                                        <small id="txtProductCodeInfo" class="form-text text-muted">This will be used for
                                            code on products</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="dlCategory" class="width_100P">Product Category:</label>

                                        <select name="category_id" class="form-control select2ProductCategory col-12" id="dlCategory">
                                            <option></option>
                                        </select>


                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="dlProductUnit" class="width_100P">Product Unit:</label>

                                        <select name="measure_unit_id" class="form-control select2ProductMeasureUnit col-12" id="dlProductUnit">
                                            <option></option>
                                        </select>


                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="txtUsername">Reorder Level: </label>
                                        <input type="number" class="form-control" id="txtUsername" placeholder="reorder-level"
                                            name="reorder_level" autocomplete="off">
                                        <small id="txtUserNameInfo" class="form-text text-muted"> Product unit count margin to order from supplier</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <h5 class="col-12"> Cost and Price</h5>

                                    <div class="form-group col-md-6">
                                        <label for="txtExMillPrice">Ex-mill Price: </label>
                                        <input type="number" class="form-control" id="txtExMillPrice" placeholder="Ex-mill Price" value="0"
                                            name="ex_mill_price" autocomplete="off">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="txtTransportFee">Lorry Fee: </label>
                                        <input type="number" class="form-control" id="txtTransportFee" placeholder="Lorry Fee" value="0"
                                            name="transport_fee" autocomplete="off">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="txtUnloadFee">Unload Fee: </label>
                                        <input type="number" class="form-control" id="txtUnloadFee" placeholder="Unload Fee" value="0"
                                            name="unload_fee" autocomplete="off">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="txtUnitPrice">Unit Price: </label>
                                        <input type="double" class="form-control" id="txtUnitPrice" placeholder="Unit Price" value="0"
                                            name="unit_price" autocomplete="off" >

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="txtOriginalCost"> Original Cost : </label>
                                        <input type="double" class="form-control" id="txtOriginalCost" placeholder="Orignal Cost" value="0"
                                            name="original_cost" autocomplete="off" readonly="true">

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="txtProfitPerUnit"> Profit Per Unit: </label>
                                        <input type="double" class="form-control" id="txtProfitPerUnit" placeholder="Unit Price" value="0"
                                            name="profit_per_unit" autocomplete="off" readonly="true">

                                    </div>

                                </div>




                                <a type="button" class="btn btn-outline-success" href="{{route('product.showList')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back To Product List</a>
                                <button type="reset" class="btn btn-secondary" onClick="resetForm()">Reset Form</button>
                                <button type="button" class="btn btn-primary" id="btnCreateProduct">Save Record</button>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /Main content -->




@endsection


@push('page_js_script')
@include('common.DropdownLists')
@include('product.js_load.product-create-js')

@endpush
