@extends('layouts.app')

@section('css')


     <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Core Css -->
    <link href="{{asset('public/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

    <!-- Waves Effect Css -->
    <link href="{{asset('public/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('public/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="{{asset('public/plugins/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="{{asset('public/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('public/css/themes/all-themes.css')}}" rel="stylesheet" />

@endsection

@section('content')

@if (isset($record))
    <section class="content">
        <div class="container-fluid">
          
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Update Journal</h2>
                          <!--   <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul> -->
                        </div>
                        <div class="body">
                            <form id="form_validation" name = "form" action = "{{ url('/updateJournal') }}" method="POST">
                                 {{ csrf_field() }}
                                <div class="col-sm-6"> 
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="hidden"  name="journal_id" value='{{$record->id}}'> 
                                            <input type="text" class="form-control" id="journal_name" value='{{$record->name}}' name="journal_name" required>
                                            <label class="form-label">Name</label>
                                        </div>
                                @if ($errors->has('journal_name'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('journal_name') }}
                                    </span>
                                @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line"> 
                                            <input type="text" class="form-control" id="voucher_prefix" value='{{$record->voucherPrefix}}' name="voucher_prefix" required>
                                            <label class="form-label">Voucher Prefix</label>
                                        </div>
                                @if ($errors->has('voucher_prefix'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('voucher_prefix') }}
                                    </span>
                                @endif
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           
    </section>

@else

   <section class="content">
        <div class="container-fluid">
          
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Add New Journal</h2>
                         
                        </div>
                        <div class="body">
                            <form id="addn" name = "form" action = "{{ url('/insertJournal') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="journal_name"  name="journal_name" required>
                                            <label class="form-label">Name</label>
                                        </div>
                                @if ($errors->has('journal_name'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('journal_name') }}
                                    </span>
                                @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line"> 
                                            <input type="text" class="form-control" id="voucher_prefix"  name="voucher_prefix" required>
                                            <label class="form-label">Voucher Prefix</label>
                                        </div>
                                @if ($errors->has('voucher_prefix'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('voucher_prefix') }}
                                    </span>
                                @endif
                                    </div>
                                </div>
                          
                         <br>
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           
    </section> 
@endif
    
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

    <!-- JQuery Steps Plugin Js -->
    <script src="{{asset('public/plugins/jquery-steps/jquery.steps.js')}}"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="{{asset('public/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

@endsection