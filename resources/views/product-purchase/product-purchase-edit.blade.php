@extends('layouts.master')


@section('title', session('lvl2_page_title'))

@php
    $purchaseDetails = $productPurchase->details;
    $productInputIndex = count($productPurchase->details) - 1;

@endphp
<script>
    let productInputIndex = "{{$productInputIndex}}";
</script>

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ session('lvl2_page_title') }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">{{ session('page_title') }}</li>
                    <li class="breadcrumb-item active">{{ session('lvl2_page_title') }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="frmProductPurchaseEdit">

                            @csrf
                            <div class="form-group col-md-4">
                                <label for="purchase_order_date" class="width_100P">Purchase Order Date:</label>

                                <input type="text" class="form-control datePicker" id="purchase_order_date"
                                    name="purchase_order_date"
                                    value="{{ date('d-m-Y'), strtotime($productPurchase->received_date) }}" />


                            </div>


                            <div id="input_area">
                                @foreach ($purchaseDetails as $index => $detail)
                                <div class="container-fluid mb-4"
                                    id="purchase_product_whole_block_{{$index}}">
                                    <div class="row">
                                        <div class="purchase_product_input_block col-10">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="product_id[{{$index}}]">Product Name:
                                                    </label>
                                                    <select name="product_id[{{$index}}]" class="form-control select2Product col-12" id="product_id_{{$index}}">
                                                        <option></option>
                                                        <option value="{{$detail->product_id}}" selected>{{$detail->product->name}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="product_code[{{$index}}]">Product
                                                        Code: </label>
                                                    <input type="text" class="form-control" id="product_code_{{$index}}" placeholder="Product Code" name="product_code[{{$index}}]"
                                                        autocomplete="off" readonly="true" value="{{$detail->product_code}}" >

                                                </div>
                                            </div>



                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="quantity[{{$index}}]">Quantity: </label>
                                                    <input type="number" class="form-control product-quantity" id="quantity[{{$index}}]" name="quantity[{{$index}}]" autocomplete="off" value="{{$detail->quantity}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="product_measure_unit_{{$index}}">Product Measure Unit: </label>
                                                    <input type="text" class="form-control" id="product_measure_unit_{{$index}}" placeholder="Product Measure Unit" name="product_measure_unit[{{$index}}]" autocomplete="off" readonly="true" value="{{$detail->measure_unit}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-default add-product" type="button">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                            @if($index > 0)
                                            <button class="btn btn-default remove-product" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Remove Product" productInputIndex="{{$index}}">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                @endforeach


                            </div>







                            <a type="button" class="btn btn-outline-success"
                                href="{{ route('productPurchase.showList') }}"> <i class="fa fa-arrow-left"
                                    aria-hidden="true"></i> Go Back To List</a>
                            <button type="button" class="btn btn-primary" id="btnProductPurchaseMake">Save
                                Record</button>

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

@include('common.SystemCommon')

@include('common.DropdownLists')

@include('product-purchase.js_load.product-purchase-edit-js');

@endpush
