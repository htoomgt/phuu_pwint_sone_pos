@extends('layouts.master')

@section('title', session('lvl2_page_title'))

@section('content')
    <!-- Content Header (Page header) -->
    <x-page-header />
    <!-- /.content-header -->

    {{-- Main Content start  --}}
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
                            <h5 class="m-0">Inventory List</h5>
                        </div>
                        <div class="card-body " style="">
                            
                            {{-- Datatable here --}}
                            {!! $dataTable->table(['id' => $dataTableId, 'class' => 'display table table-responsive table-striped collpase', 'style' => 'width:100%;']) !!}



                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- Main Content end --}}

@endsection 

@push('page_js_script')
<script type="text/javascript">
    $(function() {
        window.LaravelDataTables = window.LaravelDataTables || {};
        // window.LaravelDataTables["{{$dataTableId}}"] = $("#{{$dataTableId}}").DataTable({
        let dataTableOfPage = $("#{{$dataTableId}}").DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url" : "{{route('report.inventory')}}",
                "data" : function(d){

                    d.products = $("#products").val();                    
                }
            },
            "columns": [
                {
                "name": "product_id",
                "data": "product_id",
                "title": "Item Id",
                "orderable": false,
                "searchable": false
            },    
                {
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
                "name": "balance",
                "data": "balance",
                "title": "Balance",
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
    @include('common.DropdownLists');
    @include('report.js_load.inventory_js');

@endpush