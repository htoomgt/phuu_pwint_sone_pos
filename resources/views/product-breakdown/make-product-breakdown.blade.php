@extends('layouts.master')

@section('title',  session('lvl2_page_title'))


@section('content')
   <x-page-header />

   {{-- Main Content --}}
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" id="frmMakeProductBreakdown">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="dlProductFromBreakdown">Product From Breakdown: </label>
                                        <select name="ddlProductFromBreakdown" id="dlProductFromBreakdown" class="form-control select2Product col-12">
                                            <option></option>
                                        </select>
                                        <small id="txtProductNameInfo" class="form-text text-muted">
                                            {{-- helper text here  --}}
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="dlProductToBreakdown">Product To Breakdown: </label>
                                        <select
                                            name="dlProductToBreakdown"
                                            id="dlProductToBreakdown"
                                            class="form-control col-12"
                                            readonly
                                        >
                                            <option value=""></option>
                                        </select>
                                        <input type="hidden" name="hdnProductBreakdownMultiplier" id="hdnProductBreakdownMultiplier" />
                                            <small id="txtProductNameInfo" class="form-text text-muted">
                                                {{-- helper text here  --}}
                                            </small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="txtQuantityToBreakdown">Quantity to Breakdown: </label>
                                        <input type="number" class="form-control" id="txtQuantityToBreakdown" placeholder="Quantity To Breakdown"
                                            name="name" autocomplete="off" min="1">
                                            <small id="txtProductNameInfo" class="form-text text-muted">
                                                {{-- helper text here  --}}
                                            </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="txtQuantityToBreakdown">Total Quantity to add at child product: </label>

                                        <input class="form-control" type="text" id="txtTotalQuantityToAdd" name="txtTotalQuantityToAdd" readonly />


                                    </div>
                                </div>

                                <div class="col-md-7 offset-md-5">
                                    <a type="button" class="btn btn-outline-success" href="{{route('productBreakdown.showList')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back To Product Breakdown List</a>
                                    <button type="reset" class="btn btn-secondary" onClick="resetForm()">Reset Form</button>
                                    <button type="button" class="btn btn-primary" id="btnMakeProductBreakdown">Save Record</button>
                                </div>



                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   {{-- end main content --}}



@endsection


@push('page_js_script')
@include('common.DropdownLists')
@include('product-breakdown.js_load.make-product-breakdown-js')

@endpush
