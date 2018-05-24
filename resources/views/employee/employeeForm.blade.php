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
                        <li><a href="{{url('/employeeList')}}">Employee List</a></li>
                        <li class="active">                
                                @if(isset($employees))
                                    <a>Edit Employee</a>
                                @else
                                    <a>Add Employee</a>
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
                                    Edit Employee
                                @else
                                    Add Employee
                                @endif
                            </h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($employees))
                            <form id="form_validation" action = "{{ url('/editEmployee') }}" method = "POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$employees->id}}">
                             
                                <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  maxlength="100"class="form-control" name="name" value="{{$employees->name}}" required >
                                            <label class="form-label">Name*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <b>Phone Number</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">phone</i>
                                            </span>
                                            <div class="form-line">
                                               <input type="text" class="form-control" id="phone" name="phone"  value="{{$employees->phone}}" placeholder="Ex: +00 (000) 0000000" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                            <b>Mobile*</b>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                <i class="material-icons">phone_iphone</i>
                                                </span>
                                                <div class="form-line">
                                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{$employees->mobile}}" placeholder="Ex: +00 (000) 0000000" >
                                                </div>
                                            </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            
                                            <textarea name="address" cols="30" rows="3" class="form-control no-resize" >{{$employees->address}}</textarea>
                                            <label class="form-label">Address*</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                       <b>CNIC*</b>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">perm_identity</i>
                                                </span>
                                                <div class="form-line">
                                                    <input type="text" id="cnic" name="cnic" class="form-control" value="{{$employees->cnic}}" placeholder="xxxxx-xxxxxxx-x">
                                                </div>
                                            </div>
    
                                            @if ($errors->has('cnic'))
                                            <span class="help-block" style="color: red; font-size: 12px;">
                                                * {{ $errors->first('cnic') }}
                                            </span>
                                            @endif
                                    </div>
                                    
                                    <div class="form-group form-float">
                                        <div class="col-sm-12">
                                            <label class="form-label">Department*</label>
                                            <select  id="department" name="department" class="form-control show-tick" required>
                                                <option value="0" selected="selected" disabled="disabled">Select Department</option>
                                                @foreach ($departments as $department)    
                                                    <option value="{{$department->id}}" {{ $department->id == $employees->dptId ? "selected":"" }}>{{$department->dpt}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="col-sm-12">
                                            <label class="form-label">Designation*</label>
                                            <select  id="designation" name="designation" class="form-control show-tick" required>
                                                <option value="0" selected="selected" disabled="disabled">Select Designation</option>
                                                @foreach ($designations as $designation)    
                                                    <option value="{{$designation->id}}" {{ $designation->id == $employees->desgId ? "selected":"" }}>{{$designation->desg}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="col-sm-12">
                                            <label class="form-label">Project</label>
                                            <select  id="type_id" name="project" class="form-control show-tick" required>
                                                <option value="0" selected="selected" >Select Project</option>
                                                @foreach ($projects as $project)    
                                                    <option value="{{$project->id}}" {{ $project->id == $employees->projId ? "selected":"" }}>{{$project->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                            @else
                            {{--  ADD Form  --}}
                            <form id="form_validation" action = "{{ url('/addEmployee') }}" method = "POST">
                                {{ csrf_field() }}
                                
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  maxlength="100"class="form-control" name="name" required >
                                        <label class="form-label">Name*</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
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
                                <div class="form-group form-float">
                                        <b>Mobile*</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="material-icons">phone_iphone</i>
                                            </span>
                                            <div class="form-line">
                                            <input type="text" class="form-control" id="mobile" name="mobile" value="" placeholder="Ex: +00 (000) 0000000" >
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        
                                        <textarea name="address" cols="30" rows="3" class="form-control no-resize" ></textarea>
                                        <label class="form-label">Address*</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                   <b>CNIC*</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">perm_identity</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" id="cnic" name="cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x">
                                            </div>
                                        </div>

                                        @if ($errors->has('code'))
                                        <span class="help-block" style="color: red; font-size: 12px;">
                                            * {{ $errors->first('code') }}
                                        </span>
                                        @endif
                                </div>
                                
                                <div class="form-group form-float">
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
                                <div class="form-group form-float">
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
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Project</label>
                                        <select  id="type_id" name="project" class="form-control show-tick" required>
                                            <option value="0" selected="selected" >Select Project</option>
                                            @foreach ($projects as $project)    
                                                <option value="{{$project->id}}">{{$project->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{--  <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <label class="form-label">Receiveable Account Head*</label>
                                        <select  id="type_id" name="debit" class="form-control show-tick" data-live-search="true" required>

                                        @foreach ($accountHeads as $accountHead)    
                                            <option value="{{$accountHead->id}}" {{ $accountHead->name == "Account Receivable" ? "selected":"" }}>{{$accountHead->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <label class="form-label">Payable Account Head*</label>
                                        <select  id="type_id" name="credit" class="form-control show-tick" data-live-search="true" required>
                                           
                                        @foreach ($accountHeads as $accountHead)    
                                            <option value="{{$accountHead->id}}" {{ $accountHead->name == "Account Receivable" ? "selected":"" }}>{{$accountHead->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                  --}}
                                
                                
                                {{--  <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="cost" name="cost" required>
                                        <label class="form-label">Project Cost</label>
                                    </div>
                                </div>  --}}
                                
                                {{--  <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea name="description" cols="30" rows="5" class="form-control no-resize" required></textarea>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>  
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password" required>
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="checkbox" name="checkbox">
                                    <label for="checkbox">I have read and accept the terms</label>
                                </div>
                                --}}
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