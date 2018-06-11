@extends('layouts.app')

@section('css')



    <!-- Bootstrap Core Css -->
    <link href="{{asset('public/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

    <!-- Waves Effect Css -->
    <link href="{{asset('public/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('public/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="{{asset('public/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />

     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{asset('public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="{{asset('public/plugins/waitme/waitMe.css')}}" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="{{asset('public/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />


    <!-- Custom Css -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('public/css/themes/all-themes.css')}}" rel="stylesheet" />

    <style>
        .download{
            display:none;
        }
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>

    
@endsection

@section('content')
   
    @if(isset($payrolls)&&sizeof($payrolls)>0)
    
        <section class="content">

            

                <div class="body">
                        <ol class="breadcrumb breadcrumb-bg-red">
                            <li><a href="{{url('/home')}}">Home</a></li>
                            <li><a href="{{url('/employeePayrollList')}}">Payroll List</a></li>
                            <li class="active"><a>Edit Payroll</a></li>
                        </ol>
                </div>
        

            <div class="container-fluid">
            <!--   <div class="block-header">
                    <h2>
                        JQUERY DATATABLES
                        <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small>
                    </h2>
                </div> -->
                <!-- #END# Basic Examples -->
                <!-- Exportable Table -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                        <div class="card">
                                <div class="header">
                            
                                    <h2>
                                    Edit Payroll
                                    </h2>
                            
                                
                            </div>
                            <div class="body">
                                <form id="form_validation" name ="form" action="{{ url('/purchase/print') }}" target="_blank" method="POST">
                                    {{ csrf_field() }}
                                
                                <input type="hidden" class="form-control" id="rowTotal" name="rowTotal" value="{{sizeof($payrolls)}}">
                               {{--  <input type="hidden" class="form-control" id="id" name="id" value="{{$purchaseorders[0]->poId}}"> --}}
                                <input type="hidden" class="form-control" id="num" name="num" value="">
                                <input type="hidden" class="form-control" id="payrollMonthId" name="payrollMonthId" value="{{$payrolls[0]->payrollMonthId}}">
                                <div class="col-sm-6">  
                                    <div class="form-group form-float">
                                        <label class="form-label">Month*</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control month" id="month" name="month" placeholder="mm" value="{{$payrollMonth->month}}">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <div class="form-group form-float">
                                        <label class="form-label">Year*</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control year" id="year" name="year" placeholder="yyyy" value="{{$payrollMonth->year}}">
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <a id="update" class="btn btn-primary waves-effect">Update</a>
                                <!-- <div class="table-responsive"> -->

                                    <table id="example"  class="table  table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th style='text-align:center'>Normal Days</th>
                                                <th style='text-align:center'>Sundays</th>
                                                <th style='text-align:center'>Overtime</th>
                                                <th style='text-align:center'>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr id="total">
                                                <th colspan="2" style="text-align:center">Total</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                        
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                            

                                                <td colspan="5" >
                                                    <a class="btn btn-default waves-effect" id ="appendRow" accesskey="a" style="float: left;"> 
                                                    <i class="material-icons">add</i>
                                                </a>    
                                                
                                                </td>
                                            
                                            </tr>
                                            @foreach($payrolls as $i=>$payroll)
                                            <tr>
                                                <td>
                                                    <select id='employee{{$i+1}}' name='employee[{{$i+1}}]' class='form-control'   required>
                                                            @foreach ($employees as $employee)    
                                                                <option value="{{$employee->id}}" {{ $payroll->empId == $employee->id ? "selected":"" }}>{{$employee->name}}</option>
                                                            @endforeach       
                                                    </select> 
                                                </td>
                                                <td><input type='number' data-id='{{$i+1}}' name='normaldays[{{$i+1}}]' id='normaldays{{$i+1}}' class='form-control normaldays' value='{{$payroll->normalDays}}' ></td>
                                                <td><input type='number' data-id='{{$i+1}}' name='sundays[{{$i+1}}]' id='sundays{{$i+1}}' class='form-control sundays' value='{{$payroll->sundays}}' ></td>
                                                <td><input type='number' data-id='{{$i+1}}' name='overtime[{{$i+1}}]' id='overtime{{$i+1}}' class='form-control overtime' value='{{$payroll->overtime}}' ></td>
                                                <td style='text-align:center'><a id='icon-toggle-deleteEdit' class='removebutton' data-id="{{$payroll->id}}" title='Delete'>  <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a><a id='icon-toggle-saveEdit' data-id="{{$payroll->id}}" title='Save' class='icon-toggle-saveEdit'><i class='material-icons'>done</i></a></td></tr>
                                            </tr>
                                                
                                            @endforeach
                                        
                                        </tbody>
                                    </table>
                                            <center><b id="msg" style="color:red; font-size:16px;"></b></center>
                                <!-- </div> -->
                                <a href="{{ url('/printPayroll') }}/{{$payroll->payrollMonthId}}"  target="_blank" id="print" class="btn btn-primary waves-effect ">Print</a>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Exportable Table -->
            </div>
        </section>
    @elseif(isset($payrolls)&&sizeof($payrolls)==0)
        <section class="content">

            

                <div class="body">
                        <ol class="breadcrumb breadcrumb-bg-red">
                            <li><a href="{{url('/home')}}">Home</a></li>
                            <li><a href="{{url('/employeePayrollList')}}">Payroll List</a></li>
                            <li class="active"><a>Edit Payroll</a></li>
                        </ol>
                </div>
        

            <div class="container-fluid">
            <!--   <div class="block-header">
                    <h2>
                        JQUERY DATATABLES
                        <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small>
                    </h2>
                </div> -->
                <!-- #END# Basic Examples -->
                <!-- Exportable Table -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                        <div class="card">
                                <div class="header">
                            
                                    <h2>
                                    Edit Purchase Order
                                    </h2>
                            
                                
                            </div>
                            <div class="body">
                                <form id="form_validation" name ="form" action="{{ url('/purchase/print') }}" target="_blank" method="POST">
                                    {{ csrf_field() }}
                                
                                <input type="hidden" class="form-control" id="rowTotal" name="rowTotal" value="{{sizeof($payrolls)}}">
                               {{--  <input type="hidden" class="form-control" id="id" name="id" value="{{$purchaseorders[0]->poId}}"> --}}
                                <input type="hidden" class="form-control" id="num" name="num" value="">
                                <input type="hidden" class="form-control" id="payrollMonthId" name="payrollMonthId" value="{{$payrollMonth->id}}">
                                <div class="col-sm-6">  
                                    <div class="form-group form-float">
                                        <label class="form-label">Month*</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control month" id="month" name="month" placeholder="mm" value="{{$payrollMonth->month}}">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <div class="form-group form-float">
                                        <label class="form-label">Year*</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control year" id="year" name="year" placeholder="yyyy" value="{{$payrollMonth->year}}">
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <a id="update" class="btn btn-primary waves-effect">Update</a>
                                <!-- <div class="table-responsive"> -->

                                    <table id="example"  class="table  table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th style='text-align:center'>Normal Days</th>
                                                <th style='text-align:center'>Sundays</th>
                                                <th style='text-align:center'>Overtime</th>
                                                <th style='text-align:center'>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr id="total">
                                                <th colspan="2" style="text-align:center">Total</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                        
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                            

                                                <td colspan="5" >
                                                    <a class="btn btn-default waves-effect" id ="appendRow" accesskey="a" style="float: left;"> 
                                                    <i class="material-icons">add</i>
                                                </a>    
                                                
                                                </td>
                                            
                                            </tr>
                                        
                                        </tbody>
                                    </table>
                                            <center><b id="msg" style="color:red; font-size:16px;"></b></center>
                                <!-- </div> -->
                                <a href="{{ url('/printPayroll') }}/{{$payrollMonth->id}}" id="print" target="_blank" class="btn btn-primary waves-effect ">Print</a>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Exportable Table -->
            </div>
        </section>
    @else
        <section class="content">

        

                <div class="body">
                        <ol class="breadcrumb breadcrumb-bg-red">
                            <li><a href="{{url('/home')}}">Home</a></li>
                            <li><a href="{{url('/employeePayrollList')}}">Payroll List</a></li>
                            <li class="active"><a>Create Payroll</a></li>
                        </ol>
                </div>
        

            <div class="container-fluid">
            <!--   <div class="block-header">
                    <h2>
                        JQUERY DATATABLES
                        <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small>
                    </h2>
                </div> -->
                <!-- #END# Basic Examples -->
                <!-- Exportable Table -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                        <div class="card">
                                <div class="header">
                            
                                    <h2>Create Employees Payroll</h2>
                            
                                
                            </div>
                            <div class="body">
                                <form id="form_validation" name ="form" action="" target="_blank" method="POST">
                                    {{ csrf_field() }}
                                
                                <input type="hidden" class="form-control" id="rowTotal" name="rowTotal">
                                {{-- <input type="hidden" class="form-control" id="id" name="id" value=""> --}}
                                <input type="hidden" class="form-control" id="num" name="num" value="">
                                <input type="hidden" class="form-control" id="payrollMonthId" name="payrollMonthId" value="">
                                <div class="col-sm-6">  
                                    <div class="form-group form-float">
                                        <label class="form-label">Month*</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control month" id="month" name="month" placeholder="mm" value="">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">  
                                    <div class="form-group form-float">
                                        <label class="form-label">Year*</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control year" id="year" name="year" placeholder="yyyy" value="">
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <a id="create" class="btn btn-primary waves-effect">Create</a>
                                <!-- <div class="table-responsive"> -->

                                    <table id="example"  class="table  table-striped table-hover dataTable js-exportable " style="display:none;">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th style='text-align:center'>Normal Days</th>
                                                <th style='text-align:center'>Sundays</th>
                                                <th style='text-align:center'>Overtime</th>
                                                <th style='text-align:center'>Action</th>
                        
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr id="total">
                                                <th colspan="2" style="text-align:center">Total</th>
                                            <th></th>
                                            <th></th>
                                                <th></th>
                                                
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                            {{-- <td colspan="5" >
                                                    <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#New-Entry-Modal" tabindex="5" accesskey="+" style="float: left;"> 
                                                    <i class="material-icons">add</i>
                                                </a>    
                                                
                                                </td>  --}}

                                                <td colspan="6" >
                                                    <a class="btn btn-default waves-effect" id ="appendRow" accesskey="a" style="float: left;"> 
                                                    <i class="material-icons">add</i>
                                                </a>    
                                                
                                                </td>
                                            
                                            </tr>
                                        
                                        </tbody>
                                    </table>
                                            <center><b id="msg" style="color:red; font-size:16px;"></b></center>
                                <!-- </div> -->
                                <a href="" id="print" class="btn btn-primary waves-effect download" target="_blank" >Print</a>
                                

                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Exportable Table -->
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

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>

    <!-- SweetAlert Plugin Js -->
    <script src="{{asset('public/plugins/sweetalert/sweetalert.min.js')}}" ></script>

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
<!--     <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script> -->
    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

    {{--  <script src="{{asset('public/myscript.js')}}"></script>  --}}
    <script src="{{asset('public/payroll.js')}}"></script>
  
    <script type="text/javascript">
    
    
        var selectOpt = ""; 
        @if(isset($payrolls))
          var ndata=$('#rowTotal').val();
        @else
        var ndata=0;

        @endif

        $(document).ready(function() {
               $('.month').inputmask({ mask: "99"});
               $('.year').inputmask({ mask: "9999"});
                @foreach ($employees as $employee)    
                selectOpt += "<option value='{{$employee->id}}'>{{$employee->name}}</option>";
                @endforeach
                calculate2();
            
                
       });

        
        $('#appendRow').on('click', function () {
            var table = $("table tbody");
            var i = $('#example tbody tr').length;
            rdata=$('#rowTotal').val();
           
            if(i>1){
                var employee=$("#employee"+rdata).val();
                var normaldays=$("#normaldays"+rdata).val();
                var sundays=$("#sundays"+rdata).val();
                var overtime=$("#overtime"+rdata).val();
         
                //alert(debit);
                //alert(credit);
                if(employee==""||normaldays==""||normaldays=="0"||sundays==""||overtime==""){
                    swal("PLease Enter the values Properly");
                   
                    return false;
                }
               
            }

            ndata++;
         
         


        row = "<tr><td> <select  id='employee"+ndata+"' name='employee["+ndata+"]' class='form-control show-tick' data-live-search='true'  required>"
                                   +selectOpt+
                                    "</select></td><td><input type='number' data-id='"+ndata+"' name='normaldays["+ndata+"]' id='normaldays"+ndata+"' class='form-control normaldays' value='0' ></td><td style='text-align:center'><input type='number' data-id='"+ndata+"' name='sundays["+ndata+"]' id='sundays"+ndata+"' class='form-control sundays' value='0' ></td><td style='text-align:center'><input type='number' data-id='"+ndata+"' name='overtime["+ndata+"]' id='overtime"+ndata+"' class='form-control overtime' value='0' ></td><td style='text-align:center'><a id='icon-toggle-delete2' class='removebutton' title='Delete'>  <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a><a id='icon-toggle-save' title='Save'class=' icon-toggle-save'><i class='material-icons'>done</i></a></td></tr>";
                            $('#example tbody').append(row);

                            $('#rowTotal').val(ndata);
        });

        /*$( ".key" ).keypress(function() {
            var entry=$('#rowTotal').val();
            if ( event.which == 13 ) {
                event.preventDefault();
                
             }
          });*/
          $(document).on('click', '#icon-toggle-delete2', function () {
    
            $(this).closest('tr').remove();
            row=$('#rowCount').val()-1;
            $('#rowCount').val(row);
            console.log($(this).closest('tr').attr('id'));
           
            //calculate2();
             return false;
         });
         $(document).on('click', '#icon-toggle-deleteEdit', function () {
    
            $(this).closest('tr').remove();
            row=$('#rowCount').val()-1;
            $('#rowCount').val(row);
            console.log($(this).closest('tr').attr('id'));
           
            urllink ="{{ url('/deletePayrollEntry') }}/"+ $(this).data("id");
            $.ajax({
                url: urllink,
                type: "GET",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                
                //crossDomain: true,
                
            
                success: function(data) {
                console.log(data);
                
                }
            });
            //calculate2();
            return false;
        });
        $(document).on('click', '#icon-toggle-save', function () {
            var chkyear=$('#year').val();
            var entry="";
            var emp="";
            var norm="";
            var sun="";
            var over="";
            payrollMonthId=$('#payrollMonthId').val();
            
            entry=$(this).closest('tr');
            emp=$(this).closest('tr').find('td').eq(0).find("select").val();
            norm=$(this).closest('tr').find('td').eq(1).find("input").val();
            sun=$(this).closest('tr').find('td').eq(2).find("input").val();
            over=$(this).closest('tr').find('td').eq(3).find("input").val();
            if(norm==""||norm=="0"){
                    swal("PLease Enter the values Properly");
                   
                    return false;
                }
                urllink ="{{ url('/addEmployeePayroll') }}"
                $.ajax({
                url: urllink,
                type: "POST",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                data: {empId:emp, normaldays:norm, sundays:sun, overtime:over, payrollMonthId:payrollMonthId},
                //crossDomain: true,
                dataType: "json",
            
                success: function(data) {
                console.log(data);
                if(data.message=="inserted"){
                /*  alert(entry.find('td').eq(0).find("select").val()); */
                entry.find('td').eq(4).replaceWith("<td style='color:  green;font-weight:  bold;'>Saved</td>");
                    //$(this).remove();
                    
                } 
                else if(data.message=="Add salary rate for the employee") {
                    swal(data.message);
                    
                    return false;
                }
            

                }
            });
            
            //calculate2();
            //return false;
        });
         $(document).on('click', '#icon-toggle-saveEdit', function () {
            var chkyear=$('#year').val();
            var entry="";
            var emp="";
            var norm="";
            var sun="";
            var over="";
            id=$(this).data("id");
            payrollMonthId=$('#payrollMonthId').val();
            entry=$(this).closest('tr');
            emp=$(this).closest('tr').find('td').eq(0).find("select").val();
            norm=$(this).closest('tr').find('td').eq(1).find("input").val();
            sun=$(this).closest('tr').find('td').eq(2).find("input").val();
            over=$(this).closest('tr').find('td').eq(3).find("input").val();
            if(norm==""||norm=="0"){
                    swal("PLease Enter the values Properly");
                   
                    return false;
                }
                urllink ="{{ url('/addEmployeePayroll') }}"
                $.ajax({
                url: urllink,
                type: "POST",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                data: {empId:emp, normaldays:norm, sundays:sun, overtime:over, payrollMonthId:payrollMonthId, id:id},
                //crossDomain: true,
                dataType: "json",
            
                success: function(data) {
                console.log(data);
                if(data.message=="updated"){
                    //alert('hello');
                /*  alert(entry.find('td').eq(0).find("select").val()); */
                entry.find('td').eq(4).replaceWith("<td style='color:  green;font-weight:  bold;'>Saved</td>");
                    //$(this).remove();
                    
                } 
                else if(data.message=="Add salary rate for the employee") {
                    swal(data.message);
                    
                    return false;
                }
            

                }
            });
            
            //calculate2();
            //return false;
        });
        $(document).on('click', '#create', function (e) {
            
            var chkmonth=$('#month').val();
            var chkyear=$('#year').val();
            if(moment(chkmonth, 'MM',true).isValid()==false) {
                swal("Wrong Month");
                e.preventDefault(); //prevent the default action
                return false;
            }
            if(moment(chkyear, 'YYYY',true).isValid()==false) {
                swal("Wrong Year");
                e.preventDefault(); //prevent the default action
                return false;
            }
                urllink ="{{ url('/addPayrollMonth') }}"
                $.ajax({
                url: urllink,
                type: "POST",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                data: {month:chkmonth, year:chkyear},
                //crossDomain: true,
                dataType: "json",
            
                success: function(data) {
                console.log(data);
                    if(data.message=="created"){
                        //alert('hello');
                        $('#example').show();
                        $('#create').hide();
                        $('#payrollMonthId').val(data.id);
                        $("#print").attr("href","{{ url('/printPayroll') }}/"+data.id);
                        $("#print").removeClass("download");
                  
                    } 
                }
            });
            
            //calculate2();
            //return false;
        });
        $(document).on('click', '#update', function (e) {

            var payrollMonthId=$('#payrollMonthId').val();
            var chkmonth=$('#month').val();
            var chkyear=$('#year').val();
            if(moment(chkmonth, 'MM',true).isValid()==false) {
                swal("Wrong Month");
                e.preventDefault(); //prevent the default action
                return false;
            }
            if(moment(chkyear, 'YYYY',true).isValid()==false) {
                swal("Wrong Year");
                e.preventDefault(); //prevent the default action
                return false;
            }
                urllink ="{{ url('/editPayrollMonth') }}"
                $.ajax({
                url: urllink,
                type: "POST",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                data: {month:chkmonth, year:chkyear, id:payrollMonthId},
                //crossDomain: true,
                dataType: "json",
            
                success: function(data) {
                console.log(data);
                    if(data.message=="updated"){
                        //alert('hello');
                        $('#example').show();
                        $('#create').hide();
                        
                        $("#print").attr("href","{{ url('/printPayroll') }}/"+data.id);
                        $("#print").removeClass("download");
                  
                    } 
                }
            });
            
            //calculate2();
            //return false;
        });
         dataID=$('#rowTotal').val();
         //selector='#tax,';
         //$('#rowTotal').val();
        $('body').on('change','.quantity,.quantity,.unit,.tax',function(event){
            var rdata=$(this).attr('data-id');
            var quantity=$("#quantity"+rdata).val();
            var unit=$("#unit"+rdata).val();
            var taxPrecent=$("#tax"+rdata).val();
            var sub=0
            taxRate=0;
            tax=(taxPrecent/100);
            //alert(tax);
            if(tax>0){
                taxRate=tax;
                netPrice=quantity*unit;
                sub=netPrice*taxRate;
                sub=sub+netPrice;
            }
            else{
                netPrice=quantity*unit;
                sub=netPrice;
            }
               
            $("#sub"+rdata).val(sub);
            
            var i = $('#example tbody tr').length;
            //calculate2(); 
            //alert('calculating');
        });
        
        function calculate2(){

           
            var total=0;
            var sub=0;
            var table = $("table tbody");
            var rowCount = $('#example tbody tr').length;
            //console.log(rowCount);
            table.find('tr').each(function (i) {
                if(i>0){
                    
                   var $tds = $(this).find('td');
                   
                   var quantity=$tds.eq(1).find("input").val();
                   //alert(quantity);
                   var unit=$tds.eq(2).find("input").val();
                   //alert(unit);
                   var taxPrecent=$tds.eq(3).find("input").val();
                   taxRate=0;
                   tax=(taxPrecent/100);
                   //alert(tax);
                   if(tax>0){
                    taxRate=tax;
                    netPrice=quantity*unit;
                    sub=netPrice*taxRate;
                    sub=sub+netPrice;
                   }else{
                    netPrice=quantity*unit;
                    sub=netPrice;
                   }
                   total=total+sub;
                   

                }
            });
            $('#total').closest('tr').remove();
            var tbody = $("#example tfoot");
           
            

        }

         
        
       </script>
@endsection