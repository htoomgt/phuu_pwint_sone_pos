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
                                        <label for="voucherTotal" class="col-md-1 form-label col-form-label-md mt-1">Total
                                            :</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" readonly value="400,000" />
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- item add/edit end --}}
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    {{-- /Content --}}

@endsection
