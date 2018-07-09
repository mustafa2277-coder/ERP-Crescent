@extends('layouts.app')

@section('css')
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('public/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('public/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="{{ asset('public/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />
    
     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{asset('public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />

    <!--WaitMe Css-->
    <link href="{{asset('public/plugins/waitme/waitMe.css')}}" rel="stylesheet" />

     <!-- Bootstrap Select Css -->
    <link href="{{asset('public/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('public/css/themes/all-themes.css') }}" rel="stylesheet" />
    <style>
        .form-control{
            border: 1px solid #ccc !important; 
            padding-left: 12px !important;
        }
   
    </style>
@endsection

@section('content')
    <section class="content">
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li><a href="{{url('/userList')}}">User List</a></li>
                        <li class="active">                
                                @if(isset($userDetail))
                                    <a>Edit User</a>
                                @else
                                    <a>Add User</a>
                                @endif
                        </li>
                    </ol>
            </div>
    
        <div class="container-fluid">
            {{--  <div class="block-header">
            </div>  --}}
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="header">
                            <h2>
                                @if(isset($userDetail))
                                    Edit User
                                @else
                                    Add User
                                @endif
                            </h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($userDetail))
                            <form id="form_validation" class="form-horizontal" action = "{{ url('/addUser') }}" method = "POST">
                                {{ csrf_field() }}
                                <input id="id" type="hidden" class="form-control" name="id" value="{{$userDetail[0]->id}}" required>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Name</label>
        
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" value="{{$userDetail[0]->name}}" required autofocus>
        
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
        
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
        
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{$userDetail[0]->email}}" required>
        
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
                                        <label for="role" class="col-md-4 control-label">Role</label>
            
                                        <div class="col-md-6">
                                            <select  id="role" name="role" class=""  required>
                                                    <option value="0" selected="selected" disabled="disabled">Select Project</option>
                                                    @foreach ($roles as $role)    
                                                    <option value="{{$role->id}}" {{ $role->id == $userDetail[0]->role_id ? "selected":"" }}>{{$role->display_name}}</option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('role'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('role') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>
        
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required>
        
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
        
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
        
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Register
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @else
                            {{--  ADD Form  --}}
                            <form id="form_validation" class="form-horizontal" action = "{{ url('/addUser') }}" method = "POST">
                                {{ csrf_field() }}
                                <input id="id" type="hidden" class="form-control" name="id" value="{{$userDetail[0]->id}}" required>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Name</label>
        
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
        
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
        
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
        
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
                                        <label for="role" class="col-md-4 control-label">Role</label>
            
                                        <div class="col-md-6">
                                            <select  id="role" name="role" class=""  required>
                                                    <option value="0" selected="selected" disabled="disabled">Select Project</option>
                                                    @foreach ($roles as $role)    
                                                    <option value="{{$role->id}}">{{$role->display_name}}</option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('role'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('role') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>
        
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required>
        
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
        
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
        
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Register
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Validation -->
        </div>
    </section>
@endsection

@section('js')
     <!-- Jquery Core Js -->
    <script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{asset('public/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Select Plugin Js -->
    <script src="{{asset('public/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{asset('public/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="{{asset('public/plugins/jquery-validation/jquery.validate.js')}}"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="{{asset('public/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>

     <!-- Autosize Plugin Js -->
    <script src="{{asset('public/plugins/autosize/autosize.js')}}"></script>

    <!-- Moment Plugin Js -->
    <script src="{{asset('public/plugins/momentjs/moment.js')}}"></script>

     <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{asset('public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    
    <!-- Input Mask  Plugin Js -->
    <script src="{{asset('public/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
    
    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <script src="{{asset('public/js/pages/forms/form-validation.js')}}"></script>

    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

     <script type="text/javascript">

    $('#aDate').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
    $('#end').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
   
     $(document).ready(function() {
            $('#cnic').inputmask({mask: "99999-9999999-9"});
            $('#phone').inputmask({ mask: "+99-999-9999999"});
            $('#mobile').inputmask({ mask: "+99-999-9999999"});
        });

    </script>
@endsection