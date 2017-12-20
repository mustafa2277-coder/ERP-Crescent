
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
    

   
@endsection

@section('content')



    <section class="content">

        <div class="container-fluid">
               <a class="btn btn-primary btn-circle-lg waves-effect waves-circle waves-float" id="add_new" href="{{ url('/addJournalEntry')}}"> 
                            <i class="material-icons" title="Create New">add</i>
                           </a>
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
                                </h2>
                         
                                  
                        </div>
                        <div class="body">
                            <div class="table-responsive">

                            <h2 class="card-inside-title">Filters</h2>
                                <div class="row clearfix">
                                    
                                    <div class="col-md-3" id="div_filter">
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
                                    </div>

                                    <div class="col-md-3" id="div_journal">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select id="filter_journal" name="filter_journal" class="form-control show-tick" data-live-search="true">
                                                    <option value="0" selected="selected" disabled="disabled" >Select Journal</option>
                                                    @foreach ($journals as $journal)    
                                                    <option value="{{$journal->id}}">{{$journal->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="div_project">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select id="filter_project" name="filter_project" class="form-control show-tick" data-live-search="true">
                                                    <option value="0" selected="selected" disabled="disabled" >Select Project</option>
                                                    @foreach ($projects as $project)    
                                                    <option value="{{$project->id}}">{{$project->title}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>


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

                                </div>

                            
                                <table id="example"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">Date</th>
                                            <th style="text-align:center">Number</th>
                                            <th>Project</th>
                                            <th>Journal</th>
                                            <th style="text-align:center">Amount</th>
                                        
                                        </tr>
                                    </thead>
                                    <tfoot>
                                      <tr id="total">
                                        <th colspan="4" style="text-align:right">Total:</th>
                                        <th></th>
                                      </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($journalentries as $journalentry)
                                        <tr>
                                            <td style="text-align:center"> {{date('d/m/Y', strtotime($journalentry->entryDate))}} </td>
                                            <td style="text-align:center">{{$journalentry->entryNum}} </td>
                                            <td>{{$journalentry->project}} </td>
                                            <td>{{$journalentry->journal}} </td>
                                            <td style="text-align:center">{{$journalentry->amount}} </td>
                                        </tr>

                                        @endforeach  
                                        
                                    </tbody>
                                </table>
                                

                                
                            </div>
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

    <!-- Select Plugin Js -->
    <script src="{{asset('public/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>



  <!-- Autosize Plugin Js -->
    <script src="{{asset('public/plugins/autosize/autosize.js')}}"></script>
     <!-- Moment Plugin Js -->
    <script src="{{asset('public/plugins/momentjs/moment.js')}}"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{asset('public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <!-- Jquery DataTable Plugin Js -->
  <!--   <script src="{{asset('public/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script> -->

    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
<!--     <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script> -->
    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>



<!--     <script>
$(document).ready(function() {
    $('#example').DataTable( {
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                'Rs.'+pageTotal +' ( Rs.'+ total +' total)'
            );
        }
    } );
} );
</script> -->
  

<script>

 $('#start_date').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});  // for changing dateformat
 $('#end_date').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});  // for changing dateformat
    
 $(document).ready(function() {
 
    
    ///====Start calculation of total of amount column
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
    
    ///====End calculation of total of amount column

    $("#filter").change(function () {
        var end = this.value;
        DropDownChange(end);
        
        if(end==0){
        var form = $('<form action="'+ '{{ asset("/getJournalEntries")}}'  + '" method="post">'  + '" />' +
          '<input type="hidden" name="selection" value="0" />' +
          '{{ csrf_field() }}'+
          '</form>');
        $('body').append(form);
        form.submit();
    } 
        
});

    ///====Start dropdown change of html

    FilterCriteria({{$selection}}); 

    function DropDownChange(item){ 

    switch(item){
            case "0":
            $("#div_start_date").hide();
            $("#div_end_date").hide();
            $("#div_journal").hide();
            $("#div_project").hide();
            break;
            case "1":
            $("#div_start_date").show();
            $("#div_end_date").show();
            $("#div_journal").hide();
            $("#div_project").hide();
            
            break;
            case "2":
            $("#div_start_date").hide();
            $("#div_end_date").hide();
            $("#div_journal").show();
            $("#div_project").hide();
            break;
            case "3":
            $("#div_start_date").hide();
            $("#div_end_date").hide();
            $("#div_journal").hide();
            $("#div_project").show();

            break;

         }
    }
    function FilterCriteria(item){ 

    switch(item){
            case 0:
                DropDownChange("0");
            break;
            case 1:
                DropDownChange("1");
                @if(isset($start) && isset($end))
                $("#start_date").val('{{$start}}');
                $("#end_date").val('{{$end}}');
                @endif
                SetFilterValues('1');
            
            break;
            case 2:

                DropDownChange("2");
                @if(isset($start) && isset($end))
                $("#start_date").val('{{$start}}');
                $("#end_date").val('{{$end}}');
                @endif

                SetFilterValues('2');

                @if(isset($journalId))
                $("#filter_journal").val('{{$journalId}}');
                @endif
                $("#div_journal .btn.dropdown-toggle.btn-default").attr('title',$("#filter_journal option:selected").text());
                $("#div_journal .btn.dropdown-toggle.btn-default").find('span.filter-option.pull-left').text($("#filter_journal option:selected").text())
                $("#div_journal ul.dropdown-menu.inner li.selected").removeClass('selected');
                $("#div_journal ul.dropdown-menu.inner li").each(function(i){
                    if($(this).text()==$("#filter_journal option:selected").text()){
                        $(this).addClass('selected');
                        //$("#filter").val('2');
                    }
                });
            
            break;
            case 3:


                DropDownChange("3");
                @if(isset($start) && isset($end))
                $("#start_date").val('{{$start}}');
                $("#end_date").val('{{$end}}');
                @endif
                SetFilterValues('3');
                @if(isset($journalId))
                $("#filter_journal").val('{{$journalId}}');
                @endif

                @if(isset($projectId))
                $("#filter_project").val('{{$projectId}}');
                @endif

                $("#div_project .btn.dropdown-toggle.btn-default").attr('title',$("#filter_project option:selected").text());
                $("#div_project .btn.dropdown-toggle.btn-default").find('span.filter-option.pull-left').text($("#filter_project option:selected").text())
                $("#div_project ul.dropdown-menu.inner li.selected").removeClass('selected');
                $("#div_project ul.dropdown-menu.inner li").each(function(i){
                    if($(this).text()==$("#filter_project option:selected").text()){
                        $(this).addClass('selected');
                    }
                }); 
            break;

         }     

    }

    function SetFilterValues(filterVal){

     
        $("#filter").val(filterVal);
        $("#div_filter .btn.dropdown-toggle.btn-default").attr('title',$("#filter option:selected").text());
        $("#div_filter .btn.dropdown-toggle.btn-default").find('span.filter-option.pull-left').text($("#filter option:selected").text())
        $("#div_filter ul.dropdown-menu.inner li.selected").removeClass('selected');
        $("#div_filter ul.dropdown-menu.inner li").each(function(i){
            if($(this).text()==$("#filter option:selected").text()){
                $(this).addClass('selected');
            }
        });

    }
    
    ///====End dropdown change of html    


        });        


///====Start on change functions of html 

$("#end_date,#start_date").change(function () {

    if($("#start_date").val()!="" && $("#end_date").val()!=""){
        
 //window.location=('{{ asset("/getJournalEntries/")}}?start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val()+'selection=1');
//alert('wow');

    var form = $('<form action="'+ '{{ asset("/getJournalEntries")}}'  + '" method="post">' +
          '<input type="text" name="start_date" value="' + $("#start_date").val() + '" />' +
          '<input type="hidden" name="selection" value="1" />' +
          '<input type="text" name="end_date" value="' + $("#end_date").val() + '" />' +
          '{{ csrf_field() }}'+
          '</form>');
        $('body').append(form);
        form.submit();

    }

});

$("#filter_journal").change(function () {


//alert($(this).option.value);

    var form = $('<form action="'+ '{{ asset("/getJournalEntries")}}'  + '" method="post">' +
          '<input type="hidden" name="selection" value="2" />' +
          '<input type="text" name="journal" value="' + $("#filter_journal").val() + '" />' +
          '{{ csrf_field() }}'+
          '</form>');
        $('body').append(form);
        form.submit();

    

});

$("#filter_project").change(function () {


//alert($(this).option.value);

    var form = $('<form action="'+ '{{ asset("/getJournalEntries")}}'  + '" method="post">' +
          '<input type="hidden" name="selection" value="3" />' +
          '<input type="text" name="project" value="' + $("#filter_project").val() + '" />' +
          '{{ csrf_field() }}'+
          '</form>');
        $('body').append(form);
        form.submit();

    

});



///====End on change functions of html   



</script>

@endsection