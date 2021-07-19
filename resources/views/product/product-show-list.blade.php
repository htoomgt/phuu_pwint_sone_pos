@extends('layouts.master')

@section('title',  session('lvl2_page_title'))

@section('content')
    <!-- Content Header (Page header) -->
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
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <button id="btnAddNew" class="btn btn-outline-primary" href="#" data-toggle="modal" data-target="#mdlCreateProductCategory">
                        <i class="fa fa-plus"></i>
                        Add New
                    </button>


                </div>

            </div>
            <!-- /.row -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Product List Datatable</h5>
                        </div>
                        <div class="card-body " style="">
                            {{-- Datatable here --}}
                            {!! $dataTable->table(['id' => 'dtProduct', 'class' => 'display table table-responsive table-striped collpase',
                            'style' => 'width:100%;']) !!}



                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->



@endsection

@push('page_js_script')

{{-- Datatable Script --}}
{!! $dataTable->scripts() !!}


@endpush
