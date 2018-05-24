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
                        <li><a href="{{url('/employeeSalaryList')}}">Employee Advance List</a></li>
                        <li class="active">                
                                @if(isset($employeesSalary))
                                    <a>Edit Employee Salary</a>
                                @else
                                    <a>Add Employee Salary</a>
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
                                @if(isset($employeesSalary))
                                    Edit Employee Salary
                                @else
                                    Add Employee Salary
                                @endif
                            </h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($employeesSalary))
                                <form id="form_validation" action = "{{ url('/editEmployeeSalary') }}" method = "POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$employeesSalary->id}}">
                                
                                    <div class="form-group form-float">
                                        <div class="col-sm-12">
                                            <label class="form-label">Employee Name*</label>
                                            <select  id="employee" name="employee" class="form-control show-tick" required>
                                                <option value="0" selected="selected" disabled="disabled">Select Employee</option>
                                                @foreach ($employee as $employee)    
                                                    <option value="{{$employee->id}}" {{ $employee->id == $employeesSalary->empId ? "selected":"" }}>{{$employee->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <label class="form-label">Salary/day*</label>
                                        <input type="number" id="salaryDay" name="salaryDay" class="form-control" placeholder="" value="{{$employeesSalary->salaryRate}}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Salary/hour*</label>
                                        <input type="number" name="salaryHour" id="salaryHour" class="form-control" placeholder=""  value="{{$employeesSalary->hourlyRate}}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Overtime*</label>
                                        <input type="number" id="overtime" name="overtime" class="form-control" placeholder="" value="{{$employeesSalary->overTimeRate}}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Tax*</label>
                                        <input type="number" name="tax" id="tax" class="form-control" placeholder=""  value="{{$employeesSalary->tax}}" required>
                                    </div>

                                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                </form>
                            @else
                                {{--  ADD Form  --}}
                                <form id="form_validation" action = "{{ url('/addEmployeeSalary') }}" method = "POST">
                                    {{ csrf_field() }}
                                    <div class="form-group form-float">
                                        <div class="col-sm-12">
                                            <label class="form-label">Employee Name*</label>
                                            <select  id="employee" name="employee" class="form-control show-tick" required>
                                                <option value="0" selected="selected" disabled="disabled">Select Employee</option>
                                                @foreach ($employee as $employee)    
                                                    <option value="{{$employee->id}}" >{{$employee->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <label class="form-label">Salary/day*</label>
                                        <input type="number" id="salaryDay" name="salaryDay" class="form-control" placeholder="" value="" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Salary/hour*</label>
                                        <input type="number" name="salaryHour" id="salaryHour" class="form-control" placeholder=""  value="" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Overtime*</label>
                                        <input type="number" id="overtime" name="overtime" class="form-control" placeholder="" value="" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Tax*</label>
                                        <input type="number" name="tax" id="tax" class="form-control" placeholder=""  value="" required>
                                    </div>
                                    
                                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
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

    $('#start').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
    $('#end').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
   
     $(document).ready(function() {
            $('#cnic').inputmask({mask: "99999-9999999-9"});
            $('#phone').inputmask({ mask: "+99-999-9999999"});
            $('#mobile').inputmask({ mask: "+99-999-9999999"});
        });

    </script>
@endsection