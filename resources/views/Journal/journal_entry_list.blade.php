
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

                                <table id="example"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">Date</th>
                                            <th>Number</th>
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
                                            <td>Entry/{{$journalentry->id}} </td>
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

<script type="text/javascript">

    $(document).ready(function() {
    
     var Amt = 0;
     //var creditAmt = 0;


            var table = $("table tbody");
            var rowCount = $('#example tbody tr').length;
            //console.log(rowCount);
            table.find('tr').each(function (i) {
                if(i<rowCount){
                  
                   var $tds = $(this).find('td'),
                    
                   // debit = $tds.eq(5).text();
                    //debitAmt = parseFloat(debit) + debitAmt;

                    amtt = $tds.eq(4).text();
                    Amt = parseFloat(amtt) + Amt;

                }
            });
            $('#total').closest('tr').remove();
            var tbody = $("#example tfoot");
            var row = "<tr id='total'><th colspan='4' style='text-align:center'>    Total</th><th style='text-align:center'>" + Amt +"</th></tr>";
                tbody.append(row);

        });        


</script>

@endsection