
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                            <div class="header">
                           
                                <h2>
                                      General Ledger
                                </h2>       
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                

                                <table id="example"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center; width: 265px;" colspan="5">Account</th>
                                      
                                            <th style="text-align:center">Debit</th>
                                            <th style="text-align:center">Credit</th>
                                            <th style="text-align:center">Balance</th>
                                        
                                        </tr>
                                    </thead> 

                                   <!--  <tfoot>
                                      <tr id="total">
                                        <th colspan="5" style="text-align:center">Total:</th>
                                        <th></th>
                                        <th></th>
                                        
                                      </tr>
                                    </tfoot> -->
                                  <!--  -->
                                    <tbody>
                                       
                                        <tr>
                                            <td colspan="8">
                                          <!-- <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12"> -->
                                   <!--  <b>Panel Danger</b> -->
 
                                    <div class="panel-group" id="accordion_4" role="tablist" aria-multiselectable="true">
                                    @foreach ($ledgerAccounts as $ledgerAccount)
                                    <?php $sumDebit=$sumCredit=0; $balance=0;?>        
                                        <div class="panel panel-danger">
                                            <div class="panel-heading" role="tab" id="{{$ledgerAccount->code}}">
                                                <h4 class="panel-title">

                                                    <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$ledgerAccount->code}}" aria-expanded="false" aria-controls="collapse_{{$ledgerAccount->code}}">
                                                        <span class="glyphicon glyphicon-plus"></span>
                                                       {{$ledgerAccount->code}}  {{$ledgerAccount->name}}

                                                       
                                                       
                                                       <span id="deb" style="float: right;padding-right: 15px;">balance</span>
                                                       <span id="cre" style="float: right;padding-right: 80px;">credit</span>
                                                       <span id="bal" style="float: right;padding-right: 80px;">debit</span>


                                                   
                                                    </a>

                                                </h4>



                                            </div>

                                            <div id="collapse_{{$ledgerAccount->code}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$ledgerAccount->code}}">
                                                <div class="panel-body">
                                                     
                                                          <table id="example2"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="text-align:center">Date</th>
                                                                        <th style="text-align:center">Number</th>
                                                                        <th>Project</th>
                                                                        <th style="text-align:center">Debit</th>
                                                                        <th style="text-align:center">Credit</th>
                                                                        <th style="text-align:center">Balance</th>
                                                                    
                                                                    </tr>
                                                                </thead>
                                                              <!--   <tfoot>
                                                                  <tr id="total">
                                                                    <th colspan="4" style="text-align:right">Total:</th>
                                                                    <th></th>
                                                                  </tr>
                                                                </tfoot> -->
                                                                <tbody>
                                                                    
                                        @foreach ($ledgers as $ledger)
                                        
                                            @if ($ledger->name==$ledgerAccount->name)
                                                                    <tr>
                                                                        <td style="text-align:center"> {{date('d/m/Y', strtotime($ledger->date_post))}} </td>
                                                                        <td style="text-align:center">{{$ledger->entryNum}} </td>
                                                                        <td>{{$ledger->project}} </td>
                                                @if ($ledger->Debit!=null)
                                                    <td style="text-align:center">{{$ledger->Debit}}</td>
                                                @else                        
                                                    <td style="text-align:center">0</td>
                                                @endif    
                                                @if ($ledger->Credit!=null)
                                                    <td style="text-align:center">{{$ledger->Credit}}</td>
                                                @else                        
                                                    <td style="text-align:center">0</td>
                                                @endif                          
                                                 
                                                  <?php $sumDebit += $ledger->Debit; $sumCredit += $ledger->Credit; $balance = $balance + $ledger->Debit - $ledger->Credit ;?>

                                                    <td style="text-align:center">{{$balance}}</td>                </tr>
                                            @endif
                                        @endforeach 
                                                                    <tr id="total">
                                                                    <th colspan="3" style="text-align:center">Total:</th>
                                                                    <th style="text-align:center">{{$sumDebit}}</th>
                                                                    <th style="text-align:center">{{$sumCredit}}</th>
                                                                    <th style="text-align:center">{{$balance}}</th>
                                                                  </tr>

                                                                </tbody>
                                                            </table>
                                                             
                                                  
                                                </div>
                                            </div>
                                            
                                        </div>
                                        @endforeach
                                     
                                    </div>
                                <!-- </div>   -->
                                            </td>
                                        </tr>

                                        
                                        
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

<script>
$(document).ready(function(){
$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
});


            var table = $("tr#total");
            //var rowCount = $('#example tbody tr').length;
            //console.log(rowCount);
            table.find('th').each(function (i) {
                // if(i<rowCount-1){
                  
                    var $trs = $(this).find('tr'),
                    
                     debit = $trs.eq(0).text();
                     alert(trs.text());
                //     debitAmt = parseFloat(debit) + debitAmt;

                //     credit = $tds.eq(3).text();
                //     creditAmt = parseFloat(credit) + creditAmt;

                // }
            });

});

</script>
@endsection