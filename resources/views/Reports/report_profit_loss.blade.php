
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
                                    Profit and Loss 
                                </h2>       
                            </div>
                        <div class="body">
                            <div class="table-responsive">    
                                <table id="income"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="color:#F44336;">Income</th>
                             
                                        
                                        </tr>
                                    </thead> 
                                    <tfoot >
                                        <tr id="income_total" style="color:#F44336;">
                                        <th colspan="4" >Total Income:</th>
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
        @foreach ($incomeAccounts as $incomeAccount)
        <?php  $balance=0;?>        
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$incomeAccount->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$incomeAccount->id}}" aria-expanded="false" aria-controls="collapse_{{$incomeAccount->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$incomeAccount->type}}  
                            <span id="bal" style="float: right;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$incomeAccount->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$incomeAccount->id}}">
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
                          
                        @if ($acctype->id==$incomeAccount->id)
                           
                        

                            <tr>

                                <td> {{$incomeAccount->name}}  </td>
                                <td style="float: right;">{{$incomeAccount->Debit-$incomeAccount->Credit}} </td>
                            </tr>
                        <?php  $balance += $incomeAccount->Debit-$incomeAccount->Credit;?>
                        @endif
                        @endforeach 
                            <tr id="total">
                                <th  style="text-align:left;">Total of {{$incomeAccount->type}} :</th>
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

  <table id="expense"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="color:#F44336;">Expenses</th>
                             
                                        
                                        </tr>
                                    </thead> 
                                    <tfoot >
                                        <tr id="expense_total" style="color:#F44336;">
                                            <th colspan="4" >Total Expenses:</th>
                                            <th style="text-align:right;padding-right: 29px;"></th>
                                        </tr>
                                        <tr id="net_profit" >
                                            <th colspan="4" style="text-align:center;" >Net Profit:</th>
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
        @foreach ($expenseAccounts as $expenseAccount)
        <?php  $balance=0;?>        
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$expenseAccount->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$expenseAccount->id}}" aria-expanded="false" aria-controls="collapse_{{$expenseAccount->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$expenseAccount->type}}  
                            <span id="bal" style="float: right;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$expenseAccount->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$expenseAccount->id}}">
                <div class="panel-body">
                    <table id="example2"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <tbody>
                           
                        @foreach ($acctypes as $acctype)
                          
                        @if ($acctype->id==$expenseAccount->id)
                           
                        

                            <tr>

                                <td> {{$expenseAccount->name}}  </td>
                                <td style="float: right;">{{$expenseAccount->Debit-$expenseAccount->Credit}} </td>
                            </tr>
                        <?php  $balance += $expenseAccount->Debit-$expenseAccount->Credit;?>
                        @endif
                        @endforeach 
                            <tr id="total">
                                <th  style="text-align:left;">Total of {{$expenseAccount->type}} :</th>
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


// ===   for income calculation ===//
        var divIncome = $("#income .panel ");
        var totalIncome = 0;

        divIncome.each(function (item) {

            $(this).find('span#bal').text($(this).find('tr#total th').eq(1).text());
            totalIncome += parseFloat($(this).find('tr#total th').eq(1).text());
        });
        $('#income_total th').eq(1).text(totalIncome);

// ===   for expense calculation ===//
        var divExpense = $("#expense .panel ");
        var totalExpense = 0;

        divExpense.each(function (item) {

            $(this).find('span#bal').text($(this).find('tr#total th').eq(1).text());
            totalExpense += parseFloat($(this).find('tr#total th').eq(1).text());
        })
        $('#expense_total th').eq(1).text(totalExpense);

// ===   for profit calculation ===//
        

        $('#net_profit th').eq(1).text(totalIncome - totalExpense);


    });
   

</script>
@endsection