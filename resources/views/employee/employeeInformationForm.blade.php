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
                        <li><a href="{{url('/employeeList')}}?data=info">Employee List</a></li>
                        <li class="active">                
                                @if(isset($employees))
                                    <a>Edit Employee Information</a>
                                @else
                                    <a>Add Employee Information</a>
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
                                @if(isset($employees))
                                <h3>Employee Information</h3>  
                                @else
                                <h3>Employee Information</h3>  
                                @endif
                            </h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                      
                            {{--  ADD Form  --}}
                            <form id="form_validation" action = "#" method = "POST">
                                {{ csrf_field() }}
                                <div class="col-sm-4">
                                    <b>Employee Number</b>
                                    <div class="input-group">
                                       
                                        <div class="form-line">
                                           <input type="text" class="form-control" id="enumber" name="enumber"  value="" placeholder="Employee Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Name*</b>
                                    <div class="input-group">
                                       
                                        <div class="form-line">
                                           <input type="text" class="form-control" id="name" name="name"  value="" placeholder="Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Father Name*</b>
                                    <div class="input-group">
                                        
                                        <div class="form-line">
                                           <input type="text" class="form-control" id="father_name" name="father_name"  value="" placeholder="Father Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <b>Phone Number</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">phone</i>
                                        </span>
                                        <div class="form-line">
                                           <input type="text" class="form-control" id="phone" name="phone"  value="" placeholder="Ex: +00 (000) 0000000" >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                        <b>Mobile*</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="material-icons">phone_iphone</i>
                                            </span>
                                            <div class="form-line">
                                            <input type="text" class="form-control" id="mobile" name="mobile" value="" placeholder="Ex: +00 (000) 0000000" required>
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address*</label>
                                    <div class="form-line">
                                         
                                        <textarea name="address" cols="30" rows="2" class="form-control no-resize" required></textarea>
                                        
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-4">
                                        <b>Date of Birth*</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">date_range</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="date" id="dob" name="dob" class="form-control" placeholder="Date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>EOBI Number*</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">perm_identity</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" id="eobi" name="eobi" class="form-control" placeholder="EOBI Number" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-4">
                                        <b>CNIC*</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">perm_identity</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" id="cnic" name="cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x" required>
                                            </div>
                                        </div>

                                        @if ($errors->has('code'))
                                        <span class="help-block" style="color: red; font-size: 12px;">
                                            * {{ $errors->first('code') }}
                                        </span>
                                        @endif
                                    </div>

                                </div>
                                
                                
                                <hr>

                                <h3>Office Information</h3>    
            
                                <div class="col-sm-4">
                                    <div class="col-sm-12">
                                        <label class="form-label">Department*</label>
                                        <select  id="department" name="department" class="form-control show-tick" required>
                                            <option value="0" selected="selected" disabled="disabled">Select Department</option>
                                            @foreach ($departments as $department)    
                                                <option value="{{$department->id}}">{{$department->dpt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-12">
                                        <label class="form-label">Designation*</label>
                                        <select  id="designation" name="designation" class="form-control show-tick" required>
                                            <option value="0" selected="selected" disabled="disabled">Select Designation</option>
                                            @foreach ($designations as $designation)    
                                                <option value="{{$designation->id}}">{{$designation->desg}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="col-sm-12">
                                        <label class="form-label">Shift*</label>
                                        <select  id="shift" name="shift" class="form-control show-tick" required>
                                            <option value="0"  selected="selected" disabled="disabled">Select Shift</option>
                                            <option value="1" >General (9:00 am - 5:00 pm)</option>
                                            <option value="2" >Morning (8:00 am - 4:00 pm)</option>
                                            <option value="3" >Evening (4:00 pm - 12:00 am)</option>
                                            <option value="4" >Night (12:00 am - 8:00 am)</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class=" col-sm-3">
                                    <b>Date of Joining*</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="date" id="doj" name="doj" class="form-control" placeholder="Date">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-3">
                                    <b>Probation Period*</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">timelapse</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" id="probation_period" name="probation_period" class="form-control" placeholder="Number of Days">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-3">
                                    <b>Date of Permanency*</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="date" id="dop" name="dop" class="form-control" placeholder="Date">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-3">
                                    <b>Date of Resignation*</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="date" id="dor" name="dor" class="form-control" placeholder="Date">
                                        </div>
                                    </div>

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