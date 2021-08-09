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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Sale And Profit List</h5>
                        </div>
                        <div class="card-body " style="">
                            {{-- Datatable here --}}
                            {!! $dataTable->table(['id' => 'dtInventory', 'class' => 'display table table-responsive table-striped collpase', 'style' => 'width:100%;']) !!}



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
            window.LaravelDataTables["dtInventory"] = $("#dtInventory").DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url" : "{{route('report.saleAndProfit')}}",
                    "data" : function(d){
                        d.start_date = $("#start_date").val();
                        d.end_date = $("#end_date").val();
                    }
                },
                "columns": [{
                    "name": "name",
                    "data": "name",
                    "title": "Name",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "myanmar_name",
                    "data": "myanmar_name",
                    "title": "Myanmar Name",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "category",
                    "data": "category",
                    "title": "Category",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "product_code",
                    "data": "product_code",
                    "title": "Product Code",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "measure_unit",
                    "data": "measure_unit",
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
                    "name": "reorder_level",
                    "data": "reorder_level",
                    "title": "Reorder Level",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "ex_mill_price",
                    "data": "ex_mill_price",
                    "title": "Ex-mill Price",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "transport_fee",
                    "data": "transport_fee",
                    "title": "Transport fee",
                    "orderable": true,
                    "searchable": true
                }, {
                    "name": "unload_fee",
                    "data": "unload_fee",
                    "title": "Unload fee",
                    "orderable": true,
                    "searchable": true
                }],
                "paging": true,
                "searchDelay": 350,
                "responsive": false,
                "autoWidth": false,
                "searching": false,
                "deferLoading": 0,
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": []
            });
        });
    </script>
    @include('common.SystemCommon')
    @include('report.js_load.sale_and_profit_js');

@endpush
