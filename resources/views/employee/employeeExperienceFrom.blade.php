@extends('layouts.app')

@section('css')
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    
     <!-- Grid Css -->
     <link href="{{ asset('public/grid/demos.css') }}" rel="stylesheet"> 
     <link href="{{ asset('public/grid/css/theme.css') }}" rel="stylesheet">
     <link href="{{ asset('public/grid/css/jsgrid.css') }}" rel="stylesheet">  

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
                        <li><a href="{{url('/employeeList')}}?data=exp">Employee List</a></li>
                        <li class="active">                
                                @if(isset($employees))
                                    <a>Edit Employee Experinece</a>
                                @else
                                    <a>Add Employee Experinece</a>
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
                                    Edit Employee Experinece
                                @else
                                    Add Employee Experinece
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
                                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{$employees->mobile}}" placeholder="Ex: +00 (000) 0000000" required>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            
                                            <textarea name="address" cols="30" rows="3" class="form-control no-resize" required >{{$employees->address}}</textarea>
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
                                                    <input type="text" id="cnic" name="cnic" class="form-control" value="{{$employees->cnic}}" placeholder="xxxxx-xxxxxxx-x" required>
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



                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                            @else
                            {{--  ADD Form  --}}
                            <form id="form_validation" action = "#" method = "POST">
                                {{ csrf_field() }}
                                <div class="col-sm-12">
                                    <div class="col-sm-4">
                                        <label class="form-label">Employee*</label>

                                        <select  id="employee" name="employee" class="form-control show-tick" required>
                                            <option value="0" selected="selected" disabled="disabled">Select Employee</option>
                                            <option value="1" >Adnan</option>
                                            <option value="2" >Allen</option>
                                            <option value="3" >Joe</option>
                                           
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Designation*</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="designation" name="designation" value="" placeholder="Designation" required>
                                            </div>
                                            
                                        </div>
                                    
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Company*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="material-icons">location_city</i>
                                            </span>
                                            <div class="form-line">
                                            <input type="text" class="form-control" id="company" name="company" value="" placeholder="Company" required>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                             
                                <div class="col-sm-3">
                                    <label>From Date*</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                        <input type="date" class="form-control" id="joining_date" name="joining_date" value="" required>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <label>To Date*</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
                                        <input type="date" class="form-control" id="leaving_date" name="leaving_date" value="" required>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <label>Duration*</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="material-icons">timelapse</i>
                                        </span>
                                        <div class="form-line">
                                        <input type="text" class="form-control" id="duration" name="duration" value="" required>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label>Salary*</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="material-icons">money</i>
                                        </span>
                                        <div class="form-line">
                                        <input type="text" class="form-control" id="salary" name="salary" value="" required>
                                        </div>
                                        
                                    </div>
                                </div>

                            </form>
                            <button class="btn btn-primary waves-effect" id="add">ADD</button>
                            @endif
                            <div id="jsGrid" style=" margin-top:15px;margin-bottom:10px;" ></div>
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

     <!-- JS Grid -->
    {{--  <script src="{{ asset('/grid/external/jquery/jquery-1.8.3.js') }}"></script>  --}}
    <script src="{{ asset('public/grid/db.js') }}"></script>
    <script src="{{ asset('public/grid/jsgrid.core.js') }}"></script>
    <script src="{{ asset('public/grid/jsgrid.load-indicator.js') }}"></script>
    <script src="{{ asset('public/grid/jsgrid.load-strategies.js') }}"></script>
    <script src="{{ asset('public/grid/jsgrid.sort-strategies.js') }}"></script>
    <script src="{{ asset('public/grid/jsgrid.field.js') }}"></script>
    <script src="{{ asset('public/grid/fields/jsgrid.field.text.js') }}"></script>
    {{--  <script src="{{ asset('/grid/fields/jsgrid.field.select.js')}}"></script>  --}}
    <script src="{{ asset('public/grid/fields/jsgrid.field.checkbox.js')}}"></script>
    <script src="{{ asset('public/grid/fields/jsgrid.field.number.js')}}"></script>
    <script src="{{ asset('public/grid/fields/jsgrid.field.control.js')}}"></script>

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
            $('#add').click(function(){
                company=$("#company").val(); 
                designation=$("#designation").val(); 
                joining_date=$("#joining_date").val(); 
                leaving_date=$("#leaving_date").val(); 
                duration=$("#duration").val(); 
                salary=$("#salary").val(); 
                if(designation==""){
                    swal('Fill Designation');
                    exit();
                }
                if(company==""){
                    swal('Fill Company');
                    exit();
                }
                if(joining_date==""){
                    swal('Fill Joining Date');
                    exit();
                }
                if(leaving_date==""){
                    swal('Fill Leaving Date');
                    exit();
                }
                if(duration==""){
                    swal('Fill Leaving Date');
                    exit();
                }
                if(salary==""){
                    swal('Fill Salary');
                    exit();
                }
                obj={};
                obj.Company=company;
                obj.Designation=designation;
                obj.From=joining_date;
                obj.To=leaving_date;
                obj.Duration=duration;
                obj.Salary=salary;

                $("#jsGrid").jsGrid("insertItem", obj);
            });
            $("#jsGrid").jsGrid({
                height: "70%",
                width: "100%",

               // filtering: true,
                editing: true,
               // inserting: true,
               // sorting: true,
               //paging: true,
                
                autoload: true,
                pageSize: 15,
                pageButtonCount: 5,
               // deleteConfirm: "Do you really want to delete the client?",
                confirmDeleting:false,
                controller: {

                                deleteItem:function(item){

                                },

                                updateItem: function(item) {
                               
                              
                                },
                            },
                fields: [
                
                    { name: "Company", type: "text", width: 100,editing: true },
                    { name: "Designation", type: "text", width: 100,editing: true },
                    { name: "From", type: "text",width: 30,editing: true},
                    { name: "To", type: "text",width: 30,editing: true},
                    { name: "Duration", type: "text",width: 30,editing: false},
                    { name: "Salary", type: "text",width: 30,editing: true},
                    { type: "control",width: 30 }
                ]
            });
        });

    </script>
@endsection