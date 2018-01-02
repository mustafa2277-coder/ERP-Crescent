
@extends('layouts.app')

@section('css')


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Core Css -->
    <link href="{{asset('public/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

    <!-- Waves Effect Css -->
    <link href="{{asset('public/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="{{asset('public/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
    
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
    

   
@endsection

@section('content')



    <section class="content">

        <div class="container-fluid">
            
                           <br>
          <!--   <div class="block-header">
                <h2>
                    JQUERY DATATABLES
                    <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small>
                </h2>
            </div> -->
            <!-- #END# Basic Examples -->
            <!-- Exportable Table -->

            <div class="row clearfix" style="margin-top: 10px;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                            <div class="header">
                           
                                <h2>
                                     Journal Entries
                            <a class="btn btn-primary btn-circle waves-effect waves-circle waves-float" id="add_new" href="{{ url('/addJournalEntry')}}" style="float:right;"> 
                            <i class="material-icons" title="Create New">add</i>
                           </a>
                                </h2>
                           
                                  
                        </div>
                        <div class="body">
                            <!-- <div class="table-responsive"> -->

                            <h2 class="card-inside-title">Filters</h2>
                            <form id="form_filter" name = "form" method="GET" action="{{ url('/getFilterJournalEntriesTest') }}">
                                <div class="row clearfix">
                                
                                 {{ csrf_field() }}    
                                 <!--    <div class="col-md-3" id="div_filter">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select id="filter" class="form-control show-tick">
                                                    <option value="0" selected="selected" >All</option>
                                                    <option value="1">Date</option>
                                                    <option value="2">Journal</option>
                                                    <option value="3">Project</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div> -->

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
                                        
                                    <div class="col-md-3" id="div_journal">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select id="filter_journal" name="filter_journal" class="form-control show-tick" data-live-search="true">
                                                    <option value="0" selected="selected"  >All Journals</option>
                                                    @foreach ($journals as $journal)    
                                                    <option value="{{$journal->id}}">{{$journal->name}}</option>
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
                          
                       

                                
                         <!--    </div> -->
                        </div>
                    </div>
                </div>
            </div>

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

    <!-- SweetAlert Plugin Js -->
    <script src="{{asset('public/plugins/sweetalert/sweetalert.min.js')}}" ></script>

    <!-- Select Plugin Js -->
    <script src="{{asset('public/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>



    <!-- Autosize Plugin Js -->
    <script src="{{asset('public/plugins/autosize/autosize.js')}}"></script>
     <!-- Moment Plugin Js -->
    <script src="{{asset('public/plugins/momentjs/moment.js')}}"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{asset('public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>

    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

    <script>
    
    $(document).ready(function() {

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


            }).done(function(data){

               $('.result').html(data);
               CalculateTotalFoot();
              // console.log(data);

        });
        

    });

    $('#start_date').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});  // for changing dateformat
    $('#end_date').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});  // for changing dateformat
     
    $('#form_filter').on('submit',function(e){
      e.preventDefault();
      
      var url  = $(this).attr('action');  
      var data = $(this).serializeArray();  
      var get  = $(this).attr('method');
      //alert(data);
     // return false;
        $.ajax({

            type:get,
            url:url,
            data:data,


        }).done(function(data){

          $('.result').html(data);
         CalculateTotalFoot();
          // console.log(data);

        });



     });   

    $(document).on('click','.pagination a',function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getJournalEntry(page);

    });
function getJournalEntry(page){

        var url = "{{url('/getFilterJournalEntriesTest')}}" ; 
        var data = $('#form_filter').serializeArray();  

            $.ajax({

            type:'get',
            url:url+'?page='+page,
            data:data,


            }).done(function(data){

                $('.result').html(data);
                CalculateTotalFoot();
               // console.log(data);

            });
}

function CalculateTotalFoot(){

     var Amt = 0;
    var table = $("table tbody");
    var rowCount = $('#example tbody tr').length;

    if(rowCount !=0 ){
    table.find('tr').each(function (i) {
        if(i<rowCount){
                  
        var $tds = $(this).find('td'),
        amtt = $tds.eq(4).text();
         Amt = parseFloat(amtt) + Amt;

        }
    });

    $('#total').closest('tr').remove();
    var tbody = $("#example tfoot");
    var row = "<tr id='total'><th colspan='4' style='text-align:center'>    Total</th><th style='text-align:center'>" + Amt +"</th></tr>";
    tbody.append(row);
    }
    else{

    $('#total').closest('tr').remove();
    var tbody = $("#example tfoot");
    var row = "<tr id='total'><th colspan='5' style='text-align:center'>    No Data Found!</th></tr>";
    tbody.append(row);

    }
}        

$("#filter_customer").change(function () {

$('#div_project .dropdown-menu ul').html('');
$('#filter_project').html('');

   $.ajax({
        
        url: "http://localhost/ERP/erp1/getProjectsByCustomerId",
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