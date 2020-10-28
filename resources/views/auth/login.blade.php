@extends('layouts.appAuth')
@section('css')
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('public/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('public/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
@endsection
@section('content')

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <center><img src="{{asset('public/images/tbcerp.png')}}" /></center>
            <br>
            <small>Online ERP by Tech Bridge Consultancy</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in"  method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                    <div class="msg">Sign in to start your session</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input  id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons" style="color:#000">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 p-t-5">
                            {{--  <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>  --}}
                        </div>
                        <div class="col-xs-6">
                            <button class="btn btn-block bg-red waves-effect" type="submit">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            {{--  <a href="sign-up.html">Register Now!</a>  --}}
                        </div>
                        <div class="col-xs-6 align-right">
                            {{--  <a href="{{ route('password.request') }}">Forgot Password?</a>  --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Scripts -->
    
    <script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('public/plugins/node-waves/waves.js')}}"></script>

    <!-- Validation Plugin Js -->
    <script src="{{ asset('public/plugins/jquery-validation/jquery.validate.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('public/js/admin.js')}}"></script>
    <script src="{{ asset('public/js/pages/examples/sign-in.js')}}"></script>
       <script>
    setInterval(function(){ 
            $.ajax({
                      url: "http://crescent.cherryberry.website/ERP1/refreshToken",
                      type: "GET",
                      headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                   },
                     
                     
                      
                      success: function(data) {
                         //console.log(data);
                         $('input[name="_token"]').val(data);
                          $('meta[name="csrf-token"]').attr('content',data);
                      }

                    });
            }, 5000);
    </script>
@endsection