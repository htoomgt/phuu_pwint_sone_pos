@extends('layouts.master')

@section('title', session('lvl2_page_title'))

@section('content')
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="frmCreateUser">
                                @csrf
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="txtFullname">Full Name: </label>
                                    <input type="text" class="form-control" id="txtFullName" placeholder="Full Name"  name="full_name" autocomplete="off">
                                    <small id="txtFullNameInfo" class="form-text text-muted">To show in application left side panel.</small>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="txtUsername">Username: </label>
                                    <input type="text" class="form-control" id="txtUsername" placeholder="Username"  name="username" autocomplete="off">
                                    <small id="txtUserNameInfo" class="form-text text-muted">This will be used for logging in application.</small>
                                  </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="dlRole" class="width_100P" >Role:</label>

                                        <select name="role"  class="form-control select2Role col-12" id="dlRole" >
                                            <option></option>
                                        </select>


                                    </div>
                                    <div class="form-group col-md-6">


                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="txtPassword">Password: </label>
                                        <input type="password" class="form-control" id="txtPassword"   name="password" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="txtConfirmedPassword">Confirmed Password: </label>
                                        <input type="password" class="form-control" id="txtConfirmedPassword"   name="confirmed_password" autocomplete="off">
                                    </div>
                                </div>



                                <button type="submit" class="btn btn-primary">Save Record</button>
                              </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /Main content -->
</div>
@endsection

@push('page_js_script')

@include('common.DropdownLists')

<script>
    $(document).ready(function(){
        $("#frmCreateUser").one('submit', function(e){
            e.preventDefault();
            let dataToPost = $(this).serialize();
            // console.log(dataToPost);

            axios({
                url : "{{route('user.addNew')}}",
                method : "POST",
                data : dataToPost
            })
            .then(function(response){
                if(response.data.status == "success"){
                    Swal.fire({
                        icon : 'success',
                        title : 'Create a new user',
                        text : 'A new user has been created successfully!',
                        confirmButtonText : "OK"
                    }).then((result) => {
                        if(result.isConfirmed){
                            window.location = "{{route('user.showList')}}"
                        }
                    });
                }
            })
            .catch(function(error){
                Swa.fire({
                    icon : 'error',
                    title : 'Cannot create a user!',
                    text : "Error message : " + error.data.message
                })
            })
        })

    })
</script>

@endpush

