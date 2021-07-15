@extends('layouts.master')

@section('title', session('lvl2_page_title'))


@section('content')
    <script>
        let role = "{{ $user->getRoleNames()[0] }}";
    </script>
    <div>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="frmUpdateUser">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="txtFullname">Full Name: </label>
                                            <input type="text" class="form-control" id="txtFullName" placeholder="Full Name"
                                                name="full_name" autocomplete="off" value="{{ $user->full_name ?? '' }}">
                                            <small id="txtFullNameInfo" class="form-text text-muted">To show in application
                                                left side panel.</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="txtUsername">Username: </label>
                                            <input type="text" class="form-control" id="txtUsername" placeholder="Username"
                                                name="username" autocomplete="off" value="{{ $user->username ?? '' }}">
                                            <small id="txtUserNameInfo" class="form-text text-muted">This will be used for
                                                logging in application.</small>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="dlRole" class="width_100P">Role:</label>

                                            <select name="role" class="form-control select2Role col-12" id="dlRole">
                                                <option></option>
                                            </select>


                                        </div>
                                        <div class="form-group col-md-6">


                                        </div>
                                    </div>

                                    <div class="form-row mb-2">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="true"
                                                    id="chkChangePassword" onClick="toggleChangePassword()">
                                                <label class="form-check-label" for="chkChangePassword">
                                                    Change Password
                                                </label>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">


                                        <div class="form-group col-md-6" id="blkCurrentPassword">
                                            <label for="txtPassword">Current Password: </label>
                                            <input type="password" class="form-control" id="txtCurrentPassword"
                                                name="current_password" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6" id="blkNewPassword">
                                            <label for="txtPassword">New Password: </label>
                                            <input type="password" class="form-control" id="txtPassword" name="password"
                                                autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6" id="blkConfirmPassword">
                                            <label for="txtConfirmedPassword">Confirmed New Password: </label>
                                            <input type="password" class="form-control" id="txtConfirmedPassword"
                                                name="confirmed_password" autocomplete="off">
                                        </div>
                                    </div>
                                    <input type="hidden" id="h_user_id" name="user_id" value="{{ $user->id }}" />




                                    <button type="button" class="btn btn-outline-success" onClick="goBackUserList()"> <i
                                            class="fa fa-arrow-left" aria-hidden="true"></i> Go Back User List</button>
                                    <button type="reset" class="btn btn-secondary" onClick="resetForm()">Reset Form</button>
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
        let resetForm;
        let frmUserCreateFormValidationStatus;

        $(document).ready(function() {

            $("#dlRole").append("<option value='" + role + "' selected>" + role + "</option>");

            $("#blkCurrentPassword").toggle();
            $("#blkNewPassword").toggle();
            $("#blkConfirmPassword").toggle();

            toggleChangePassword = () => {
                $("#blkCurrentPassword").toggle();
                $("#blkNewPassword").toggle();
                $("#blkConfirmPassword").toggle();
            }


            $("#frmUpdateUser").one('submit', function(e) {
                e.preventDefault();
                let dataToPost = $(this).serialize();
                // console.log(dataToPost);
                if (frmUserCreateFormValidationStatus.form()) {
                    axios({
                            url: "{{ route('user.updateById') }}",
                            method: "PUT",
                            data: dataToPost
                        })
                        .then(function(response) {
                            if (response.data.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updating user',
                                    text: 'The user has been updated successfully!',
                                    confirmButtonText: "OK"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location = "{{ route('user.showList') }}"
                                    }
                                });
                            }
                        })
                        .catch(error => {

                            Swal.fire({
                                    icon: 'error',
                                    title: 'Cannot create a user!',
                                    text: "Error message : " + error.response.data.message
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        let userId = $("#h_user_id").val();
                                        window.location = "{{ route('user.edit','') }}"+userId;
                                    }
                                });;
                        })
                }


            })

            resetForm = () => {
                $("#dlRole").val('').trigger('change');
            }



            goBackUserList = () => {
                window.location = "{{ route('user.showList') }}";
            }

            $("#dlRole").on("select2:close", function(e) {
                $(this).valid();
            })

            valiRules = {
                nameTitle: {
                    required: true,
                    maxlength: 512
                }
            }

            valiRulesMsg = {
                nameTitle: {
                    required: true,
                    maxlength: 512
                }
            }

            frmUserCreateFormValidationStatus = $("#frmUpdateUser").validate({
                rules: {
                    full_name: {
                        required: true,
                        maxlength: 512
                    },
                    username: {
                        required: true,
                        maxlength: 512,
                        username_exist_check: true
                    },
                    role: {
                        required: true
                    },
                    current_password: {
                        required: function(element) {
                            return $("#chkChangePassword").val() == true;
                        },
                        check_correct_current_password: function(element) {
                            return $("#chkChangePassword").val() == true;
                        }
                    },
                    password: {
                        required: function(element) {
                            return $("#chkChangePassword").val() == true;
                        },
                        minlength: 5,
                    },
                    confirmed_password: {
                        required: function(element) {
                            return $("#chkChangePassword").val() == true;
                        },
                        minlength: 5,
                        equalTo: "#txtPassword"
                    }
                },
                messages: {
                    full_name: {
                        required: "Please enter full name",
                        maxlength: "Max character is 512."
                    },
                    username: {
                        required: "Please enter username",
                        maxlength: "Max character is 512.",
                    },
                    role: {
                        required: "Please choose a role"
                    },
                    password: {
                        required: "Please enter password!",
                        minlength: "Please enter at least 5 characters password.",

                    },
                    confirmed_password: {
                        required: "Please enter confirmed password.",
                        minlength: "Please enter at least 5 characters password.",
                        equalTo: "Password and confirmed password do not match."
                    }
                }
            })

            $.validator.addMethod("username_exist_check", function(value, element) {
                let valid = null;
                $.ajax({
                    'async': false,
                    url: "{{ route('user.usernameUniqueCheck') }}",
                    type: "GET",
                    data: {
                        id: $("#h_user_id").val(),
                        username: $('#txtUsername').val()
                    },
                    success: function(resp) {
                        // console.log(resp.data.found);
                        if (resp.data.found) {
                            valid = false;
                        } else {
                            valid = true;
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }

                });

                return valid;


            }, "Username already existed!");


            $.validator.addMethod("check_correct_current_password", function(value, element) {
                let valid = null;
                $.ajax({
                    'async': false,
                    url: "{{ route('user.checkCurrentPassword') }}",
                    type: "GET",
                    data: {
                        id: $("#h_user_id").val(),
                        current_password: $('#txtCurrentPassword').val()
                    },
                    success: function(resp) {
                        // console.log(resp.data.found);
                        if (resp.data.same) {
                            valid = true;
                        } else {
                            valid = false;
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }

                });

                return valid;


            }, "Please enter correct current password.");

        })
    </script>

@endpush
