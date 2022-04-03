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
                            <h5 class="m-0">Inventory List</h5>
                        </div>
                        <div class="card-body " style="">
                            
                            {{-- Datatable here --}}
                            {{-- {!! $dataTable->table(['id' => $dataTableId, 'class' => 'display table table-responsive table-striped collpase', 'style' => 'width:100%;']) !!} --}}



                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- Main Content end --}}

@endsection 

@push('page_js_script')
    <script>

    </script>

    @include('common.SystemCommon');
    @include('common.DropdownLists');
    @include('report.js_load.inventory_js');

@endpush