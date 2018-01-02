
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
                                

                                <table id="example"  class="table  table-striped table-hover">
                                    <thead>
                                        <tr style="background: #f44336;color: #fff;">
                                            <th style="text-align:center; width: 265px;" colspan="5">ACCOUNT</th>
                                            <th style="text-align:center">DEBIT</th>
                                            <th style="text-align:center">CREDIT</th>
                                            <th style="text-align:center">BALANCE</th>
                                        
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
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$ledgerAccount->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$ledgerAccount->id}}" aria-expanded="false" aria-controls="collapse_{{$ledgerAccount->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$ledgerAccount->code}}  {{$ledgerAccount->name}}
                            <span id="bal" style="float: right;border-left solid: 1px;border-left: solid #b9b6b6 1px;width: 14%; display: inline-block;text-align: center; font-size: 12px;"></span>
                            <span id="cre" style="float: right;border-left: solid #b9b6b6 1px;width: 14%;display: inline-block;
                            text-align: center;font-size: 12px;"></span>
                            <span id="deb" style="float: right;border-left: solid #b9b6b6 1px;width: 13%;display: inline-block;
                            text-align: center;font-size: 12px;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$ledgerAccount->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$ledgerAccount->id}}">
                <div class="panel-body">
                    <table id="example2"  class="table  table-striped table-hover">
                        <thead>
                            <tr style="background: #f44336;color: #fff;">
                                <th>DATE</th>
                                <th>NUMBER</th>
                                <th>PROJECT</th>
                                <th style="text-align:center">DEBIT</th>
                                <th style="text-align:center">CREDIT</th>
                                <th style="text-align:center">BALANCE</th>
                            </tr>
                        </thead>
                                                                          <!--   <tfoot>
                                                                              <tr id="total">
                                                                                <th colspan="4" style="text-align:right">Total:</th>
                                                                                <th></th>
                                                                              </tr>
                                                                            </tfoot> -->
                        <tbody>
                            <tr>
                                <td colspan="3">Initial Balance</td>
                                <td style="text-align:center">0</td>
                                <td style="text-align:center">0</td>
                                <td style="text-align:center">0</td>
                            </tr>
                        @foreach ($ledgers as $ledger)
                          
                        @if ($ledger->id==$ledgerAccount->id)
                           
                        

                            <tr class="detailModal" style="cursor:  pointer;" title="View" >

                                <td> {{date('d/m/Y', strtotime($ledger->date_post))}} </td>
                                <td>{{$ledger->entryNum}} </td>
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
                                <td style="text-align:center">{{$balance}}</td> 
                                           
                            </tr>
                        
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

             <!-- For Modal  -->
                <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <!-- <h4 class="modal-title" id="defaultModalLabel">Journal Entry</h4> -->
                             <div class="header">
                           
                                <h2>
                                      <span id="modal_entrynum"></span>
                                </h2>       
                            </div>
                               <div class="row clearfix">
                                <div class="col-sm-1">
                                  <strong>DATE</strong>
                                </div>
                                <div class="col-sm-3">
                                    <span id="modal_date"></span>
                                </div>
                                <div class="col-sm-2">
                                  <strong>JOURNAL</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span id="modal_journal"></span>
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
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
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

    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
<!--     <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script> -->

    <!-- <script src="{{asset('public/js/pages/ui/modals.js')}}"></script> -->

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

<script>
    $(document).ready(function(){
        $('.collapse').on('shown.bs.collapse', function(){
        $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }).on('hidden.bs.collapse', function(){
        $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
        });



        var divPanel = $(".panel");

        divPanel.each(function (item) {

            $(this).find('span#deb').text($(this).find('tr#total th').eq(1).text());
            $(this).find('span#cre').text($(this).find('tr#total th').eq(2).text());
            $(this).find('span#bal').text($(this).find('tr#total th').eq(3).text());
        });

    });

    $('.detailModal').on('click', function () {
       // alert($(this).find('td').eq(1).text());
       $.ajax({
            url: "http://localhost/ERP/erp1/getJournalEntryByEntrynum",
            type: "GET",
            headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
            data: {entrynum:$(this).find('td').eq(1).text()},
            //crossDomain: true,
            dataType: "json",
            beforeSend: function() { $('.page-loader-wrapper').fadeIn();},
            complete: function() { $('.page-loader-wrapper').fadeOut();},

            success: function(data) {


                if(data.length !=0){
                    var inovDate = new Date(data[0].entryDate);
                    $('#modal_date').text( inovDate.getDate() + '/' + (inovDate.getMonth() + 1) + '/' +  inovDate.getFullYear());
                    $('#modal_journal').text(data[0].journal);
                    $('#modal_entrynum').text(data[0].entryNum);
                    
               
                    $('#defaultModal').modal('show');
                    var totalDebit = 0;
                    var totalCredit = 0;

                    $.each(data,function(i,val){

                        var row ="";
                        var debit=0;
                        var credit=0;
                        if(val.isDebit==0){
                          credit = val.amount;
                          debit = 0;
                        }
                         else{
                         debit = val.amount; 
                         credit = 0;  
                        }
                        totalDebit  += parseFloat(debit);
                        totalCredit += parseFloat(credit);

                        row = "<tr><td>"+val.accountheadCode+"</td><td>"+val.account+"</td><td>"+val.project+"</td><td>"+debit+"</td><td>"+credit+"</td></tr>";
                        $('#modalTable tbody').append(row);

                       

                   //  console.log(val);  

                    });

                     row = "<tr><th  colSpan='3' style='text-align:center'>Total</th><th>"+totalDebit+"</th><th>"+totalCredit+"</th></tr>";
                        $('#modalTable tbody').append(row);
                   
                    
                //alert(data);
            }
            else{

                swal('error');
            }
        }

         });

        
    });

$('#defaultModal').on('hidden.bs.modal', function () {
        $('#modal_date').text('');
        $('#modal_journal').text('');
        $('#modal_entrynum').text('');
        $('#modalTable tbody').html('');

    });    

</script>
@endsection