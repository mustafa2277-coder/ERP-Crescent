
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
                        <li class="active"><a> Profit and Loss </a></li>
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
                                    Profit and Loss 
                                </h2>       
                            </div>
                        <div class="body">
                            <div class="table-responsive">    
                                <table id="income"  class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="color:#F44336;">INCOME</th>
                             
                                        
                                        </tr>
                                    </thead> 
                                    <tfoot >
                                        <tr id="income_total" style="color:#F44336;">
                                        <th colspan="4" >TOTAL INCOME:</th>
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
        @foreach ($incomeAcctypes as $incomeAcctype)
        <?php  $balance=0;?>        
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$incomeAcctype->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$incomeAcctype->id}}" aria-expanded="false" aria-controls="collapse_{{$incomeAcctype->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$incomeAcctype->type}}  
                            <span id="bal" style="float: right;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$incomeAcctype->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$incomeAcctype->id}}">
                <div class="panel-body">
                    <table id="example2"  class="table  table-striped table-hover">
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
                           
                        @foreach ($incomeAccounts as $incomeAccount)
                          
                        @if ($incomeAcctype->id==$incomeAccount->id)
                           
                        

                            <tr>

                                <td> {{$incomeAccount->name}}  </td>
                                <td style="float: right;">{{$incomeAccount->Debit-$incomeAccount->Credit}} </td>
                            </tr>
                        <?php  $balance += $incomeAccount->Debit-$incomeAccount->Credit;?>
                        @endif
                        @endforeach 
                            <tr id="total">
                                <th  style="text-align:left;">Total of {{$incomeAcctype->type}} :</th>
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

  <table id="expense"  class="table  table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="8" style="color:#F44336;">EXPENSES</th>
                             
                                        
                                        </tr>
                                    </thead> 
                                    <tfoot >
                                        <tr id="expense_total" style="color:#F44336;">
                                            <th colspan="4" >TOTAL EXPENSES:</th>
                                            <th style="text-align:right;padding-right: 29px;"></th>
                                        </tr>
                                        <tr id="net_profit" >
                                            <th colspan="4" style="text-align:center;" >NET PROFIT:</th>
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
        @foreach ($expenseAcctypes as $expenseAcctype)
        <?php  $balance=0;?>        
            <div class="panel">
                <div class="panel-heading" role="tab" id="{{$expenseAcctype->id}}">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$expenseAcctype->id}}" aria-expanded="false" aria-controls="collapse_{{$expenseAcctype->id}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{$expenseAcctype->type}}  
                            <span id="bal" style="float: right;"></span>
                        </a>
                    </h4>
                </div>

            <div id="collapse_{{$expenseAcctype->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$expenseAcctype->id}}">
                <div class="panel-body">
                    <table id="example2"  class="table table-striped table-hover">
                        <tbody>
                           
                        @foreach ($expenseAccounts as $expenseAccount)
                          
                        @if ($expenseAcctype->id==$expenseAccount->id)
                           
                        

                            <tr>

                                <td> {{$expenseAccount->name}}  </td>
                                <td style="float: right;">{{$expenseAccount->Debit-$expenseAccount->Credit}} </td>
                            </tr>
                        <?php  $balance += $expenseAccount->Debit-$expenseAccount->Credit;?>
                        @endif
                        @endforeach 
                            <tr id="total">
                                <th  style="text-align:left;">Total of {{$expenseAcctype->type}} :</th>
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