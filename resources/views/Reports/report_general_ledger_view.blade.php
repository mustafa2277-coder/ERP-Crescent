
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


    <!-- Bootstrap Select Css -->
    <link href="{{asset('public/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{asset('public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <!-- <link href="{{asset('public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet" /> -->

    <!-- Custom Css -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('public/css/themes/all-themes.css')}}" rel="stylesheet" />
 
    <!-- JQuery Nestable Css -->
    <link href="{{asset('public/plugins/nestable/jquery-nestable.css')}}" rel="stylesheet" />
    
@endsection

@section('content')
  
 
    <section class="content">
        
        <div class="body">
            <ol class="breadcrumb breadcrumb-bg-red">
                <li><a href="{{url('/home')}}">Home</a></li>
                <li class="active"><a>General Ledger</a></li>
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
                                      General Ledger

                                     
                                </h2>       
                            </div>
                        <div class="body">

                            <h2 class="card-inside-title">Filters</h2>
                            <form id="form_filter" name = "form" method="GET" action="{{ url('/getFilterGeneralLedgerList') }}">
                                <div class="row clearfix">

                                    <div class="col-md-3" id="div_start_date">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">date_range</i>
                                            </span>
                                            <div class="form-line">
                                            <input type="text" id="start_date" name="start_date" class="datepicker form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3" id="div_end_date">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">date_range</i>
                                                 
                                            </span>
                                            <div class="form-line">
                                            <input type="text" id="end_date" name="end_date" class="datepicker form-control date">
                                           
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class="col-md-3" id="div_account">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select id="filter_account" name="filter_account" class="form-control show-tick" data-live-search="true">
                                                    <option value="0" selected="selected"  >All Accounts</option>
                                                    @foreach ($accounts as $account)    
                                                    <option value="{{$account->id}}">{{$account->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="div_customer">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select id="filter_customer" name="filter_customer" class="form-control show-tick" data-live-search="true">
                                                    <option value="0" selected="selected" >All Customers</option>
                                                    @foreach ($customers as $customer)    
                                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row clearfix">
                                   
                                    <div class="col-md-3" id="div_project">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select id="filter_project" name="filter_project" class="form-control show-tick" data-live-search="true">
                                                   
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-float">
                                                                            
                                     <button class="btn btn-primary waves-effect" type="submit">Search</button>

                                       </div>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="result">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>



             <!-- For Modal  -->
                <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div id="printInv">
                        <div class="modal-header">
                            <!-- <h4 class="modal-title" id="defaultModalLabel">Journal Entry</h4> -->
                             <div class="header">
                           
                                <h2>
                                      <span id="modal_entrynum"></span>
                                </h2>       
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-1">
                                  <strong>DATE:</strong>
                                </div>
                                <div class="col-sm-3">
                                    <span id="modal_date"></span>
                                </div>
                                <div class="col-sm-2">
                                  <strong>JOURNAL:</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span id="modal_journal"></span>
                                </div>
                            </div>
                            <div class="row clearfix">    
                                <div class="col-sm-2">
                                    <strong>Refrences:</strong>
                                </div>
                                <div class="col-sm-10">
                                    <span id="modal_ref"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                           

                            <table id="modalTable"  class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>CODE</th>
                                <th>ACCOUNT</th>
                                <th>PROJECT</th>
                                
                                <th style="text-align:center">DEBIT</th>
                                <th style="text-align:center">CREDIT</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>


                            
                        </div>
                    </div>
                    <div>
                        <div class="modal-footer">
                            <button type="button" id="btnPrint" class="btn btn-primary waves-effect">Print</button>
                           
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal  -->
            <!-- #END# Exportable Table -->
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

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>

    <!-- Select Plugin Js -->
    <script src="{{asset('public/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>



    <!-- Jquery DataTable Plugin Js -->
<!--     <script src="{{asset('public/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script> -->
    
    <!-- Autosize Plugin Js -->
    <script src="{{asset('public/plugins/autosize/autosize.js')}}"></script>
    <!-- Moment Plugin Js -->
    <script src="{{asset('public/plugins/momentjs/moment.js')}}"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{asset('public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>


<!--     <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script> -->

    <!-- <script src="{{asset('public/js/pages/ui/modals.js')}}"></script> -->
   

    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>
    

<script>
    $('#start_date').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});  // for changing dateformat
    $('#end_date').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});  // for changing dateformat
    $(document).ready(function(){

   
       var todayDate = new Date();
       $('#start_date').val( todayDate.getDate() + '/' + (todayDate.getMonth() + 1) + '/' +  todayDate.getFullYear());
       $('#end_date').val( todayDate.getDate() + '/' + (todayDate.getMonth() + 1) + '/' +  todayDate.getFullYear());
       $('#div_project').hide();


        var url  = $('#form_filter').attr('action');  
        var data = $('#form_filter').serializeArray();  
        var get  = $('#form_filter').attr('method');
    
        $.ajax({

                type:get,
                url:url,
                data:data,
                beforeSend: function() { $('.page-loader-wrapper').fadeOut(); $('.page-loader-wrapper').fadeIn();},
                complete: function() { $('.page-loader-wrapper').fadeOut();},


            }).done(function(data){

            $('.result').html(data);
          
           //  console.log(data);

        });

       

    });

   $('#form_filter').on('submit',function(e){
      e.preventDefault();
      
      
      var url  = $(this).attr('action');  
      var data = $(this).serializeArray();  
      var get  = $(this).attr('method');
    
        $.ajax({

            type:get,
            url:url,
            data:data,
            beforeSend: function() { $('.page-loader-wrapper').fadeIn();},
            complete: function() { $('.page-loader-wrapper').fadeOut();},


        }).done(function(data){

          $('.result').html(data);
        //  CalculateTotalFoot();
          // console.log(data);

        });



     });
$("#filter_customer").change(function () {

$('#div_project .dropdown-menu ul').html('');
$('#filter_project').html('');

   $.ajax({
        
        url: "http://localhost/ERP/getProjectsByCustomerId",
        type: "post",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
        data: {id:$('#filter_customer').val()},
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            //console.log(data);

            if(data.length !=0){ 

                $('#div_project').show();   

                $('#filter_project').append('<option value="0" selected="selected">All Projects</option>');
                $('#div_project .dropdown-menu ul').append('<li data-original-index="0" class="active selected"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">'+"Select Projects"+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>');
                $('#div_project').find('span.filter-option').text("Select Projects");
            
                $.each(data, function(i, d) {
                     
                        var ind = parseInt(i);
                        ind +=1
                        
                        $('#filter_project').append('<option value="' + d.id + '">' + d.title + '</option>');
                      
                        $('#div_project .dropdown-menu ul').append('<li data-original-index="'+ind+'" class=""><a tabindex="0" class="" style="" data-tokens="null"><span class="text">'+d.title+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>');
                         
                 });
            }
            else{

            $('#div_project').hide();  
            //swal("There is no project!");

            }

        }

    });
   

});      

    

      

</script>


@endsection