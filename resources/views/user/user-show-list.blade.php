@extends('layouts.master')

@section('title', session('lvl2_page_title'))

@section('content')
{{-- Content --}}
<div>
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
                    <a class="btn btn-outline-primary">
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
                            <h5 class="m-0">User List Datatable</h5>
                        </div>
                        <div class="card-body " style="">
                            {{-- Datatable here --}}
                            {!! $dataTable->table(['id' => 'user-datatable', 'class' => 'display table table-responsive table-striped collpase',
                            'style' => 'width:100%;']) !!}



                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

</div>
{{-- /Content --}}
@endsection

@push('page_js_script')
{!! $dataTable->scripts() !!}

<script>
    let changeStatus = 0;
    let deleteUser;


    $(document).ready(function(){
        changeStatus = (id=0, statusToChange = "") => {
            let dataToPost = {
                userId : id,
                statusToChange : statusToChange,
                _token : $("meta[name='csrf-token']").attr("content")
            }

            axios({
                method : 'PATCH',
                url : "{{route('user.statusUpdateById')}}",
                data: dataToPost
            }).then(function(response){
                // console.log(response.data);
                $("#user-datatable").DataTable().ajax.reload();
            }).catch(function(response){
                console.log(response.data);
            })

        }
    })


</script>
@endpush


