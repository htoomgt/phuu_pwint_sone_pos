<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Phuu Pwint Sone POS</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}" />
    <link rel="stylesheet" href="{{asset('css/login_page.css')}}" />


</head>
<body>
    <div class="container d-flex
        justify-content-center
        align-items-center" role="main">
        <div class="card" id="login-card">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-10 text-center offset-1 login-card-header">
                        <h3> Phuu Pwint Sone Grocery <br/> Point of Sale <br/>System</h3>
                    </div>
                    <div class="row card-body">
                        <div class="col-12 info-text">
                            Please login here to access the system.
                        </div>
                        <div class="col-12 mt-3">
                            <form action="{{route('login.authenticate')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="txtUsername">Username :</label>
                                    <input type="text" class="form-control" id="txtUsername"  name="username" />
                                    @error('username')
                                        <small id="username_error_msg" class="text-danger"> {{$message}}</small>
                                    @enderror

                                </div>
                                <div class="form-group">
                                  <label for="txtPassword">Password:</label>
                                  <input type="password" class="form-control" id="txtPassword" name="password" />
                                  @error('password')
                                    <small id="password_error_msg" class="text-danger"> {{$message}}</small>
                                  @enderror
                                </div>
                                <div class="form-group d-flex
                                justify-content-end" >
                                    <button type="submit" class="btn btn-success" id="btn-login">Login</button>
                                </div>

                                <div class="form-group d-flex justify-content-center">
                                    @if (Session::has('login_status'))
                                        <div id="login-error"> {{ session('login_status') }}</div>
                                    @endif

                                </div>


                              </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="{{asset('js/app.js')}}"></script>
