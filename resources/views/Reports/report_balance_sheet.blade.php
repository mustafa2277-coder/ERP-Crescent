
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
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li class="active"><a>Balance Sheet</a></li>
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
                                    Balance Sheet
                                </h2> 
                                <a href="{{url('/getBalanceSheetPdf')}}" target="_blank" style="float:right;">Downlaod PDF</a>     
                            </div>
                        <div class="body">
                            <div class="table-responsive">    
                                <table id="assets"  class="table  table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="color:#F44336;">ASSETS</th>
                             
                                        
                                        </tr>
                                    </thead> 
                                    <tfoot >
                                        <tr id="assets_total" style="color:#F44336;">
                                        <th colspan="4" >TOTAL ASSETS:</th>
                                        <th style="text-align:right;padding-right: 29px;"></th>
                                        </tr>
                                    </tfoot>

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
        @foreach ($assetAcctypes as $assetAcctype )
        <?php  $balance=0;?>        
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$assetAcctype->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$assetAcctype->id}}" aria-expanded="false" aria-controls="collapse_{{$assetAcctype->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$assetAcctype->type}}  
                            <span id="bal" style="float: right;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$assetAcctype->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$assetAcctype->id}}">
                <div class="panel-body">
                    <table id="example2"  class="table table-striped table-hover">
                     <!--    <thead>
                            <tr>
                                <th>Amount</th>
                               
                            </tr>
                        </thead> -->
                    
                                                                          <!--   <tfoot>
                                                                              <tr id="total">
                                                                                <th colspan="4" style="text-align:right">Total:</th>
                                                                                <th></th>
                                                                              </tr>
                                                                            </tfoot> -->
                        <tbody>
                           
                        @foreach ($assetAccounts as $assetAccount)
                          
                        @if ($assetAcctype->id==$assetAccount->id)
                           
                        

                            <tr>

                                <td> {{$assetAccount->name}}  </td>
                                <td style="text-align: right;">{{$assetAccount->Debit-$assetAccount->Credit}} </td>
                            </tr>
                        <?php  $balance += $assetAccount->Debit-$assetAccount->Credit;?>
                        @endif
                        @endforeach 
                            <tr id="total">
                                <th  style="text-align:left;">Total of {{$assetAcctype->type}} :</th>
                                <th style="text-align:right">{{$balance}}</th>
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

  <table id="liabilities"  class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="color:#F44336;">LIABILITIES</th>
                             
                                        
                                        </tr>
                                    </thead> 
                                    <tfoot >
                                        <tr id="lia_total" style="color:#F44336;">
                                        <th colspan="4" >TOTAL LIABILITIES:</th>
                                        <th style="text-align:right;padding-right: 29px;"></th>
                                        </tr>
                                    </tfoot>

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
        @foreach ($liaAcctypes as $liaAcctype)
        <?php  $balance=0;?>        
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$liaAcctype->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$liaAcctype->id}}" aria-expanded="false" aria-controls="collapse_{{$liaAcctype->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$liaAcctype->type}}  
                            <span id="bal" style="float: right;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$liaAcctype->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$liaAcctype->id}}">
                <div class="panel-body">
                    <table id="example2"  class="table table-striped table-hover">
                        <tbody>
                           
                        @foreach ($liabilitiesAccounts  as $liabilitiesAccount)
                          
                        @if ($liaAcctype->id==$liabilitiesAccount->id)
                           <?php $debCre = $liabilitiesAccount->Debit-$liabilitiesAccount->Credit;
                                 $debCre = $debCre<0?$debCre*-1:$debCre;   

                            ?>
                        

                            <tr>

                                <td> {{$liabilitiesAccount->name}}  </td>
                                <td style="text-align: right;">{{$debCre}} </td>
                            </tr>
                        <?php  $balance += $liabilitiesAccount->Debit-$liabilitiesAccount->Credit;?>
                        @endif
                        @endforeach 
                            <tr id="total">
                                <th  style="text-align:left;">Total of {{$liabilitiesAccount->type}} :</th>
                                <th style="text-align:right">{{$balance<0?$balance*-1:$balance}}</th>
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
    <table id="equity"  class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="color:#F44336;">EQUITY</th>
                             
                                        
                                        </tr>
                                    </thead> 
                                    <tfoot >
                                        <tr id="equity_total" style="color:#F44336;">
                                        <th colspan="4" >TOTAL EQUITY:</th>
                                        <th style="text-align:right;padding-right: 29px;"></th>
                                        </tr>
                                    </tfoot>

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
        @foreach ($equityAcctypes as $equityAcctype)
        <?php  $balance=0;?>        
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$equityAcctype->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$equityAcctype->id}}" aria-expanded="false" aria-controls="collapse_{{$equityAcctype->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$equityAcctype->type}}  
                            <span id="bal" style="float: right;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$equityAcctype->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$equityAcctype->id}}">
                <div class="panel-body">
                    <table id="example2"  class="table table-striped table-hover">
                        <tbody>
                           
                        @foreach ($equityAccounts as $equityAccount)
                          
                        @if ($equityAcctype->id==$equityAccount->id)
                           
                        

                            <tr>

                                <td> {{$equityAccount->name}}  </td>
                                <td style="text-align: right;">{{$equityAccount->Debit-$equityAccount->Credit}} </td>
                            </tr>
                        <?php  $balance += $equityAccount->Debit-$equityAccount->Credit;?>
                        @endif
                        @endforeach 
                            <tr id="total">
                                <th  style="text-align:left;">Total of {{$equityAcctype->type}} :</th>
                                <th style="text-align:right">{{$balance}}</th>
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


// ===   for assets calculation ===//
        var divAssets = $("#assets .panel ");
        var totalAssets = 0;

        divAssets.each(function (item) {

            $(this).find('span#bal').text($(this).find('tr#total th').eq(1).text());
            totalAssets += parseFloat($(this).find('tr#total th').eq(1).text());
        });
        $('#assets_total th').eq(1).text(totalAssets);

// ===   for liablilities calculation ===//
        var divliab = $("#liabilities .panel ");
        var totalLiab = 0;

        divliab.each(function (item) {

            $(this).find('span#bal').text($(this).find('tr#total th').eq(1).text());
            totalLiab += parseFloat($(this).find('tr#total th').eq(1).text());
        })
        $('#lia_total th').eq(1).text(totalLiab);

// ===   for equity calculation ===//
        var divequity = $("#equity .panel ");
        var totalEquity = 0;

        divequity.each(function (item) {

            $(this).find('span#bal').text($(this).find('tr#total th').eq(1).text());
            totalEquity += parseFloat($(this).find('tr#total th').eq(1).text());
        })
        $('#equity_total th').eq(1).text(totalEquity);


    });
   

</script>
@endsection