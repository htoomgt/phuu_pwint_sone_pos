@extends('layouts.master')

@section('title', session('lvl2_page_title'))

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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <form action="" id="frmDataGrid">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group">
                                                <select name="products[]" multiple="multiple" class="form-control select2Product" id="products" style="width:100%;">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <input type="text" class="form-control datePicker" id="start_date"
                                                    name="start_date" placeholder="Enter start date" readonly="true">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <input type="text" class="form-control datePicker" id="end_date"
                                                    name="end_date" placeholder="Enter end date" readonly="true">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-primary" id="btnSearch">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                            <button class="btn btn-warning" id="btnExport">
                                                <i class="fas fa-file-download"></i> Export
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>



                </div>

            </div>
            
            <!-- /.row -->
            <div class="row mt-1">
                <div class="col-12" >
                    <div class="card" >
                        <div class="card-header" >
                            <h5 class="m-0">Sale And Profit List</h5>
                        </div>
                        <div class="card-body "  >
                            <div class="text-bold my-4 ml-0"  >
                                <span class="form-label-md mt-1"> Total Sale Amount : &nbsp;</span> 
                                <span id="total_sale_amount_label"> 0</span>
                            </div>
                            <div class="text-bold my-4 ml-0"  >
                                <span class="form-label-md mt-1"> Total Profit : &nbsp;</span> 
                                <span id="total_profit_label"> 0</span>
                            </div>
                            {{-- Datatable here --}}
                            {!! $dataTable->table(['id' => $dataTableId, 'class' => 'display table table-responsive table-striped collpase', 'style' => 'width:100%;']) !!}



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->

@endsection


@push('page_js_script')
    {{-- Datatable Script --}}
    {{-- {!! $dataTable->scripts() !!} --}}
    <script type="text/javascript">
        $(function() {
            window.LaravelDataTables = window.LaravelDataTables || {};
            // window.LaravelDataTables["{{$dataTableId}}"] = $("#{{$dataTableId}}").DataTable({
            let dataTableOfPage = $("#{{$dataTableId}}").DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url" : "{{route('report.saleAndProfitDaily')}}",
                    "data" : function(d){

                        d.products = $("#products").val();
                        d.start_date = $("#start_date").val();
                        d.end_date = $("#end_date").val();
                    }
                },
                "columns": [{
                    "name": "sale_date",
                    "data": "sale_date",
                    "title": "Date",
                    "orderable": true,
                    "searchable": true,                    
                }, {
                    "name": "item",
                    "data": "product_name",
                    "title": "Item",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "code",
                    "data": "product_code",
                    "title": "Code",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "category",
                    "data": "product_category",
                    "title": "Category",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "unit",
                    "data": "product_measure_unit",
                    "title": "Measure Unit",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "unit_price",
                    "data": "unit_price",
                    "title": "Unit Price",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "sale_quantity",
                    "data": "sale_quantity",
                    "title": "Sale Quantity",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "amount",
                    "data": "sale_amount",
                    "title": "Sale Amount",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "profit_per_unit",
                    "data": "profit_per_unit",
                    "title": "Profit Per Unit",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "profit",
                    "data": "profit",
                    "title": "Profit",
                    "orderable": true,
                    "searchable": true
                }],
                "paging": true,
                "searchDelay": 350,
                "responsive": true,
                "autoWidth": false,
                "searching": false,
                "deferLoading": 0,
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": []
            });

            // var table = $("#{{$dataTableId}}").DataTable();
            // let totalAmount = dataTableOfPage.column(7).data().sum();
            // console.log(table.column(4));

        });
    </script>

    @include('common.SystemCommon');
    @include('common.DropdownLists')
    @include('report.js_load.sale_and_profit_daily_js');

@endpush
