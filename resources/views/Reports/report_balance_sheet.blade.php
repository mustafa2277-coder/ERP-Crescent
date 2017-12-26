
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
                                    Balance Sheet
                                </h2>       
                            </div>
                        <div class="body">
                            <div class="table-responsive">    
                                <table id="assets"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="color:#F44336;">Assets</th>
                             
                                        
                                        </tr>
                                    </thead> 
                                    <tfoot >
                                        <tr id="assets_total" style="color:#F44336;">
                                        <th colspan="4" >Total Assets:</th>
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
        @foreach ($assetAccounts as $assetAccount)
        <?php  $balance=0;?>        
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$assetAccount->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$assetAccount->id}}" aria-expanded="false" aria-controls="collapse_{{$assetAccount->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$assetAccount->type}}  
                            <span id="bal" style="float: right;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$assetAccount->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$assetAccount->id}}">
                <div class="panel-body">
                    <table id="example2"  class="table table-bordered table-striped table-hover dataTable js-exportable">
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
                           
                        @foreach ($acctypes as $acctype)
                          
                        @if ($acctype->id==$assetAccount->id)
                           
                        

                            <tr>

                                <td> {{$assetAccount->name}}  </td>
                                <td style="float: right;">{{$assetAccount->Debit-$assetAccount->Credit}} </td>
                            </tr>
                        <?php  $balance += $assetAccount->Debit-$assetAccount->Credit;?>
                        @endif
                        @endforeach 
                            <tr id="total">
                                <th  style="text-align:left;">Total of {{$assetAccount->type}} :</th>
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

  <table id="liabilities"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="color:#F44336;">Liabilities</th>
                             
                                        
                                        </tr>
                                    </thead> 
                                    <tfoot >
                                        <tr id="lia_total" style="color:#F44336;">
                                        <th colspan="4" >Total Liabilities:</th>
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
        @foreach ($liabilitiesAccounts as $liabilitiesAccount)
        <?php  $balance=0;?>        
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$liabilitiesAccount->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$liabilitiesAccount->id}}" aria-expanded="false" aria-controls="collapse_{{$liabilitiesAccount->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$liabilitiesAccount->type}}  
                            <span id="bal" style="float: right;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$liabilitiesAccount->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$liabilitiesAccount->id}}">
                <div class="panel-body">
                    <table id="example2"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <tbody>
                           
                        @foreach ($acctypes as $acctype)
                          
                        @if ($acctype->id==$liabilitiesAccount->id)
                           
                        

                            <tr>

                                <td> {{$liabilitiesAccount->name}}  </td>
                                <td style="float: right;">{{$liabilitiesAccount->Debit-$liabilitiesAccount->Credit}} </td>
                            </tr>
                        <?php  $balance += $liabilitiesAccount->Debit-$liabilitiesAccount->Credit;?>
                        @endif
                        @endforeach 
                            <tr id="total">
                                <th  style="text-align:left;">Total of {{$liabilitiesAccount->type}} :</th>
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
    <table id="equity"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="color:#F44336;">Liabilities</th>
                             
                                        
                                        </tr>
                                    </thead> 
                                    <tfoot >
                                        <tr id="equity_total" style="color:#F44336;">
                                        <th colspan="4" >Total Liabilities:</th>
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
        @foreach ($equityAccounts as $equityAccount)
        <?php  $balance=0;?>        
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$equityAccount->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$equityAccount->id}}" aria-expanded="false" aria-controls="collapse_{{$equityAccount->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$equityAccount->type}}  
                            <span id="bal" style="float: right;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$equityAccount->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$equityAccount->id}}">
                <div class="panel-body">
                    <table id="example2"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <tbody>
                           
                        @foreach ($acctypes as $acctype)
                          
                        @if ($acctype->id==$equityAccount->id)
                           
                        

                            <tr>

                                <td> {{$equityAccount->name}}  </td>
                                <td style="float: right;">{{$equityAccount->Debit-$equityAccount->Credit}} </td>
                            </tr>
                        <?php  $balance += $equityAccount->Debit-$equityAccount->Credit;?>
                        @endif
                        @endforeach 
                            <tr id="total">
                                <th  style="text-align:left;">Total of {{$equityAccount->type}} :</th>
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