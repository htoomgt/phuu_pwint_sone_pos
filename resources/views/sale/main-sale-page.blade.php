@extends('layouts.master')

@section('title', session('page_title'))

@section('content')
    {{-- Content --}}
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ session('page_title') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">{{ session('page_title') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <form action="" id="frmSaleVoucher">
                    {{-- header action --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">


                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class=" col-md-4">
                                                <button class="btn btn-outline-primary">
                                                    <i class="fa fa-plus-circle"></i> &nbsp;
                                                    New Vouncher
                                                </button>

                                                <button class="btn btn-outline-danger">
                                                    <i class="fa fa-trash"></i> &nbsp;
                                                    Remove Vouncher
                                                </button>
                                            </div>
                                            <label for="voucherTotal"
                                                class="col-md-1 form-label col-form-label-md mt-1">Total
                                                :</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" readonly value="0" id="total_amount"
                                                    name="total" />
                                            </div>

                                            <div class="col-md-4">
                                                <h4> pagination </h4>
                                            </div>

                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>


                    </div>
                    {{-- header action end --}}

                    {{-- item add/edit --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="card pos-item-card">
                                <div class="card-body">
                                    <div class="container-fluid">
                                        {{-- voucher info action row --}}

                                        <div class="row">
                                            <div class="col-3">
                                                <label for="voucher_datetime">Voucher Datetime</label>
                                                <input type="datetime-local" class="form-control"
                                                    placeholder="Voucher Datetime" id="voucher_datetime"
                                                    name="sale_datetime" />
                                            </div>
                                            <div class="col-2">
                                                <label for="voucher_datetime">Customer Name</label>
                                                <input type="text" class="form-control" placeholder="Customer Name"
                                                    id="customer_name" name="customer_name">
                                            </div>
                                            <div class="col-2">
                                                <label for="voucher_datetime">Customer Phone</label>
                                                <input type="text" class="form-control" placeholder="Customer Phone"
                                                    id="customer_phone" name="customer_phone">
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-outline-secondary" id="btnAddItem">
                                                    <i class="fa fa-plus-circle"></i> &nbsp;
                                                    Item
                                                </button>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-outline-secondary" id="btnPay">
                                                    <i class="fas fa-money-bill"></i> &nbsp;
                                                    Payment
                                                </button>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-outline-secondary" id="btnPrint">
                                                    <i class="fas fa-print"></i> &nbsp;
                                                    Print
                                                </button>
                                            </div>


                                        </div>
                                        {{-- voucher info action row end --}}

                                        <div class="row">
                                            <div class="col-12 mt-4 table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th widht="30%"> Product </th>
                                                            <th widht="5%"> Unit</th>
                                                            <th widht="5%"> Unit Price</th>
                                                            <th widht="15%"> Quantity</th>
                                                            <th widht="15%"> Amount</th>
                                                            <th> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="voucher_items">
                                                        <tr id="item_row_0">
                                                            <td>
                                                                <select name="product_id[0]" id="product_id_0"
                                                                    class="select2ProductAllByName" style="width:100%;">
                                                                    <option></option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="unit[0]"
                                                                    id="unit_0" readonly />

                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="unit_price[0]"
                                                                    id="unit_price_0" readonly />
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control input_quantity"
                                                                    name="quantity[0]" id="quantity_0" value="" min="1" />
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control" name="amount[0]"
                                                                    id="amount_0" value="0" readonly />

                                                            </td>
                                                            <td>

                                                            </td>
                                                        </tr>


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- item add/edit end --}}
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    {{-- /Content --}}

@endsection

@push('page_js_script')
    @include('common.DropdownLists')
    @include('sale.js_load.main-sale-page-js')
@endpush
