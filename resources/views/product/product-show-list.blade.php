@extends('layouts.master')

@section('title',  session('lvl2_page_title'))

@section('content')
     <!-- Content Header (Page header) -->
     <x-page-header />
     <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <a id="btnAddNew" class="btn btn-outline-primary" href="{{route('product.create')}}">
                        <i class="fa fa-plus"></i>
                        Add New
                    </a>


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
