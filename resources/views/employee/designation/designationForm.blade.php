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
@endsection

@section('content')
    <section class="content">
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li><a href="{{url('/designation')}}">Desigantion Defination List</a></li>
                        <li class="active">                
                                @if(isset($employeesAdvance))
                                    <a>Edit Employee Advance</a>
                                @else
                                    <a>Add Desigantion Defination</a>
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
                                @if(isset($employeesAdvance))
                                    Edit Employee Advance
                                @else
                                    Add Desigantion Defination
                                @endif
                            </h2>
                        </div>
                        <div class="body">

                                {{--  ADD Form  --}}
                                <form id="form_validation" action = "#" method = "POST">
                                    {{ csrf_field() }}
                                    <div class="form-group form-float">
                                        <div class="col-sm-12">
                                            <label class="form-label">Designation*</label>
                                            <select  id="designation" name="designation" class="form-control show-tick" required>
                                                <option value="0" selected="selected" disabled="disabled">Select Designation</option>
                                                <option value="0">Director Sales</option>
                                                <option value="0">Manager Sales</option>
                                                <option value="0">Manager Production</option>
                                                {{--  @foreach ($employee as $employee)    
                                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                @endforeach  --}}
                                            </select>
                                        </div>
                                    </div>
                                 
                                    <div class="col-sm-6">
                                        <label class="form-label">Basic Salary*</label>
                                        <input type="text" id="salary" name="salary" class="salary form-control" placeholder="" value="" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Medical Allowance*</label>
                                        <input type="text" name="medical" id="medical" class="medical form-control" placeholder=""  value="" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">House Rent*</label>
                                        <input type="text" name="rent" id="rent" class="rent form-control" placeholder=""  value="" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Travel Allowance*</label>
                                        <input type="text" name="travel" id="travel" class="travel form-control" placeholder=""  value="" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Tax*</label>
                                        <input type="text" name="tax" id="tax" class="tax form-control" placeholder=""  value="" required>
                                    </div>
                                    
                                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                </form>
                            
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

    $('#start').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
    $('#end').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
   
     $(document).ready(function() {
            $('#cnic').inputmask({mask: "99999-9999999-9"});
            $('#phone').inputmask({ mask: "+99-999-9999999"});
            $('#mobile').inputmask({ mask: "+99-999-9999999"});
        });

    </script>
@endsection