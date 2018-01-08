
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

    <!-- JQuery DataTable Css -->
    <!-- <link href="{{asset('public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet" /> -->

    <!-- Custom Css -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('public/css/themes/all-themes.css')}}" rel="stylesheet" />
    
@endsection

@section('content')


    <section class="content">
        <a href="{{url('/home')}}">Home >> </a><a>Journal Items</a> 
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
                                     Journal Items
                                </h2>       
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                
                            
                                <table id="example"  class="table table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr style="background:#f44336;color:#fff;">
                                            <th style="text-align:center">DATE</th>
                                            <th>NUMBER</th>
                                            <th>PROJECT</th>
                                            <th>JOURNAL</th>
                                            <th>ACCOUNT</th>
                                            <th style="text-align:center">DEBIT</th>
                                            <th style="text-align:center">CREDIT</th>
                                        
                                        </tr>
                                    </thead>
                                    <tfoot>
                                      <tr id="total">
                                        <th colspan="5" style="text-align:center">TOTAL:</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                      </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($journalItems as $journalItem)
                                        <tr>
                                            <td style="text-align:center"> {{date('d/m/Y', strtotime($journalItem->entryDate))}}</td>
                                            <td>{{$journalItem->entryNum}} </td>
                                            <td>{{$journalItem->project}} </td>
                                            <td>{{$journalItem->journal}} </td>
                                            <td>{{$journalItem->account}} </td>

                                        @if (isset($journalItem->isDebit) && $journalItem->isDebit==1 )    
                                            <td style="text-align:center">{{$journalItem->amount}}</td>
                                            <td style="text-align:center">0</td>
                                        @else
                                            <td style="text-align:center">0</td>
                                            <td style="text-align:center">{{$journalItem->amount}}</td>
                                        @endif    
                                        
                                        </tr>

                                        @endforeach  
                                        
                                    </tbody>
                                </table>
                               {{$journalItems->links()}} 
                                <!-- {{($journalItems->currentpage()-1) * $journalItems->perpage() + $journalItems->count()}} -->
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

    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
<!--     <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script> -->

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>



   <!--  <script>
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
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            total2 = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );    
 
            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
               // Total over this page
            pageTotal2 = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );    
 
            // Update footer Debit
            $( api.column( 5 ).footer() ).html(
                'Rs.'+pageTotal +' ( Rs.'+ total +' total)'
            );

            // Update footer Credit
            $( api.column( 6).footer() ).html(
                'Rs.'+pageTotal2 +' ( Rs.'+ total2 +' total)'
            ); 
        }
    } );
} );
</script> -->

<script type="text/javascript">

    $(document).ready(function() {
    
     var debitAmt = 0;
     var creditAmt = 0;


            var table = $("table tbody");
            var rowCount = $('#example tbody tr').length;
            //console.log(rowCount);
            table.find('tr').each(function (i) {
                if(i<rowCount){
                  
                   var $tds = $(this).find('td'),
                    
                    debit = $tds.eq(5).text();
                    debitAmt = parseFloat(debit) + debitAmt;

                    credit = $tds.eq(6).text();
                    creditAmt = parseFloat(credit) + creditAmt;

                }
            });
            $('#total').closest('tr').remove();
            var tbody = $("#example tfoot");
            var row = "<tr id='total'><th colspan='5' style='text-align:center'>    Total</th><th style='text-align:center'>" + debitAmt +"</th><th style='text-align:center'>" + creditAmt +"</tr>";
                tbody.append(row);

        });        


</script>
@endsection