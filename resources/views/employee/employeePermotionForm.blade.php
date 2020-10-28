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
                        
                        <li class="active">                
                                @if(isset($employees))
                                    <a>Edit Employee Education</a>
                                @else
                                    <a> Employee Permotion / Demotion</a>
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
                                    Edit Employee Permotion
                                @else
                                    Employee Permotion / Demotion
                                @endif
                            </h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}

                            {{--  ADD Form  --}}
                            <form id="form_validation" action = "#" method = "POST">
                                {{ csrf_field() }}
                                <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <b class="form-label">Employee*</b>
                                        
                                        <select  id="employee" name="employee" class="form-control show-tick" required>
                                            <option value="0" selected="selected" disabled="disabled">Select Employee</option>
                                            <option value="1"  >Adnan</option>
                                            <option value="2" >Allen</option>
                                            <option value="3" >Joe</option>
                                           
                                        </select>
                                    </div>
                               
                                    <div class="col-sm-6">
                                        <b class="form-label">Designation*</b>
                                        
                                        <select  id="designation" name="designation" class="form-control show-tick" required>
                                            <option value="" selected="selected" disabled="disabled">Select Designation</option>
                                            <option value="1"  >Sales Manager</option>
                                            <option value="2" >Production Manager</option>
                                            <option value="3" >Human Resource Manager</option>
                                           
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-6">
                                    <b class="form-label">Salary*</b>
                                    <input type="text" id="salary" name="salary"  maxlength="100"class="form-control" name="salary" required >
                                    
                                </div>
                                <div class="col-sm-6">
                                    <b class="form-label">Date*</b>
                                    <input type="date" id="date" name="date" maxlength="100"class="form-control" name="name" required >
                                    
                                </div>
                             
                                

                              
                            </form>
                            <button class="btn btn-primary waves-effect" id="add">ADD</button>
                      
                            <div  id="jsGrid" style=" margin-top:15px;margin-bottom:10px; display:none;" ></div>
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
            $('#employee').change(function(){
                $('#jsGrid').hide('2000');
                $('#jsGrid').show('2000');
            })
            $('#add').click(function(){

                designation=$("#designation option:selected").text(); 
                designationId=$("#designation").val(); 
                // deartment=$("#deartment").val();
                salary=$("#salary").val(); 
                date=$("#date").val(); 
                if(designationId==null){
                    swal('Select Designation');
                    exit();
                }
            
                if(date==""){
                    swal('Fill Date');
                    exit();
                }
               
              
                obj={};
                obj.Date=date;
                obj.Designation=designation;
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
                
                    { name: "Date", type: "text", width: 100,editing: false },
                    { name: "Designation", type: "text", width: 100,editing: false },
                    { name: "Salary", type: "text",width: 30,editing: false},
                    { type: "control",width: 30 }
                ]
            });
            
        });

    </script>
@endsection