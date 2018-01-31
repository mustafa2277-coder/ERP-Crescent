﻿
@extends('layouts.app')

@section('css')



    <!-- Bootstrap Core Css -->
    <link href="{{asset('public/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

    <!-- Waves Effect Css -->
    <link href="{{asset('public/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('public/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="{{asset('public/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />

     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{asset('public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="{{asset('public/plugins/waitme/waitMe.css')}}" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="{{asset('public/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />


    <!-- Custom Css -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('public/css/themes/all-themes.css')}}" rel="stylesheet" />

    <style>
        .download{
            display:none;
        }
    </style>

    
@endsection

@section('content')


    <section class="content">

       

            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li><a href="{{url('/getJournalEntriesListView')}}">Journal Entries</a></li>
                        <li class="active"><a>New Journal Entries</a></li>
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
                                   New Journal Entries
                                </h2>
                         
                              
                        </div>
                        <div class="body">
                            <form id="form_validation" name ="form" action="{{ url('/journalEntry/print') }}" target="_blank" method="POST">
                                 {{ csrf_field() }}
                             <div class="row clearfix">
                                <div class="col-sm-6">
                                    <select  id="journal_id" name="journal_id" class="form-control show-tick" data-live-search="true"  tabindex="1" required>
                                         <option value="0" selected="selected" disabled="disabled"><strong>Select Journal</strong></option>
                                        @foreach ($journals as $journal)    
                                        <option value="{{$journal->id}}">{{$journal->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6" id="div_project">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                    <select  id="project_id" name="project_id" class="form-control show-tick" data-live-search="true" tabindex="2"  required>
                                         <option value="0" selected="selected" disabled="disabled">Select Project</option>
                                        @foreach ($projects as $project)    
                                        <option value="{{$project->id}}">{{$project->title}}</option>
                                        @endforeach
                                    </select>
                                         </div>
                                    </div>
                                </div>
                                   
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                            <input type="text"  name="pdate" id="pdate" tabindex="3" class="form-control date" >
                                            <label class="form-label">Date (dd/mm/yyyy)</label>
                                            </div>
                                        </div>
                                    </div>

                                  <div class="col-sm-6">
                                    <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="reference" tabindex="4" name="reference" required>
                                        <label class="form-label">Reference</label>
                                    </div>
                                </div>
                                    </div>    
                            </div>
                            <input type="hidden" class="form-control" id="rowTotal" name="rowTotal">
                            <!-- <div class="table-responsive"> -->

                                <table id="example"  class="table  table-striped table-hover dataTable js-exportable">
                                   <thead>
                                        <tr>
                                            <th>ACCOUNT</th>
                                            <th></th>
                                            <th style='text-align:center'>DEBIT</th>
                                            <th style='text-align:center'>CREDIT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr id="total">
                                            <th colspan="2" style="text-align:center">Total</th>
                                           <th></th>
                                           <th></th>
                                            <th></th>
                                            
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                         <tr>
                                           {{-- <td colspan="5" >
                                                <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#New-Entry-Modal" tabindex="5" accesskey="+" style="float: left;"> 
                                                <i class="material-icons">add</i>
                                               </a>    
                                              
                                            </td>  --}}

                                             <td colspan="5" >
                                                <a class="btn btn-default waves-effect" id ="appendRow" accesskey="a" style="float: left;"> 
                                                <i class="material-icons">add</i>
                                               </a>    
                                              
                                            </td>
                                         
                                        </tr>
                                      
                                    </tbody>
                                </table>
                                        <center><b id="msg" style="color:red; font-size:16px;"></b></center>
                            <!-- </div> -->
                            <button class="btn btn-primary waves-effect" id="submit" accesskey="s">SUBMIT</button>
                            <button class="btn btn-primary waves-effect download" type="submit"  id="download" >Print</button>

                            </form>

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

    <!-- Autosize Plugin Js -->
    <script src="{{asset('public/plugins/autosize/autosize.js')}}"></script>

    <!-- Moment Plugin Js -->
    <script src="{{asset('public/plugins/momentjs/moment.js')}}"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{asset('public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <!-- Input Mask  Plugin Js -->
    <script src="{{asset('public/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script> 

    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
<!--     <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script> -->
    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

    {{--  <script src="{{asset('public/myscript.js')}}"></script>  --}}
    <script src="{{asset('public/Ejournal.js')}}"></script>
  
    <script type="text/javascript">
        var selectOpt = ""; 
        var ndata=0;
        $(document).ready(function() {
               $('.date').inputmask({ mask: "99/99/9999"});
                 
                @foreach ($accounts as $account)    
                selectOpt += "<option value='{{$account->id}}'>{{$account->name}}</option>";
                @endforeach
            
                
       });

        
        $('#appendRow').on('click', function () {
            var i = $('#example tbody tr').length;
            rdata=$('#rowTotal').val();
            if(i>1){
                var debit=$("#debit"+rdata).val();
                var credit=$("#credit"+rdata).val();
                //alert(debit);
                //alert(credit);
                if(debit==""&&credit=="" || debit=='0'&&credit=='0'){
                    swal("PLease Enter the values Properly");
                   
                    return false;
                }
                if(debit=="0"&&credit=="" || debit==''&&credit=='0'){
                    swal("PLease Enter the values Properly");
                   
                    return false;
                }
               /* if(debit!=null&&credit!=null || debit='0'&&credit='0' ){
                    swal("Invalid Entry");
                    
                    return false;
                }*/
            }

            ndata++;
         
         


        row = "<tr><td> <select  id='acc"+ndata+"' name='acc["+ndata+"]' class='form-control show-tick' data-live-search='true'  required>"
                                   +selectOpt+
                                    "</select></td><td></td><td style='text-align:center'><input type='number' name='debit["+ndata+"]' id='debit"+ndata+"' class='form-control debit key' value='0' ></td><td style='text-align:center'><input type='number' name='credit["+ndata+"]' id='credit"+ndata+"' class='form-control credit key' value='0'></td><td style='text-align:center'><a id='icon-toggle-delete2' class='removebutton'>  <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a></td></tr>";
                            $('#example tbody').append(row);

                            $('#rowTotal').val(ndata);
        });

        /*$( ".key" ).keypress(function() {
            var entry=$('#rowTotal').val();
            if ( event.which == 13 ) {
                event.preventDefault();
                
             }
          });*/
          $(document).on('click', '#icon-toggle-delete2', function () {
    
            $(this).closest('tr').remove();
            row=$('#rowCount').val()-1;
            $('#rowCount').val(row);
            console.log($(this).closest('tr').attr('id'));
           
            calculate2();
             return false;
         });

        
        $('body').on('change','.debit,.credit',function(event){
            calculate2(); 
        });
        function calculate2(){

            var debitAmt = 0;
            var creditAmt = 0;


            var table = $("table tbody");
            var rowCount = $('#example tbody tr').length;
            //console.log(rowCount);
            table.find('tr').each(function (i) {
                if(i>0){
                  
                   var $tds = $(this).find('td');
        
                    debit = $tds.eq(2).find("input").val();
                    
                    debitAmt = parseFloat(debit) + debitAmt;

                    credit = $tds.eq(3).find("input").val();
                    creditAmt = parseFloat(credit) + creditAmt;

                }
            });
            $('#total').closest('tr').remove();
            var tbody = $("#example tfoot");
            var row = "<tr id='total'><th colspan='2' style='text-align:center'>    Total</th><th style='text-align:center' id='debitAmt'>" + debitAmt +"</th><th style='text-align:center' id='creditAmt'>" + creditAmt +"</th><th><input type='hidden' name='debitAmt' class='form-control ' value='" + debitAmt +"' ><input type='hidden' name='creditAmt' class='form-control ' value='" + creditAmt +"' ></th></tr>";
                tbody.append(row);
            //debitTotal=$('#debitAmt').text();
            //creditTotal=$('#creditAmt').text();
            

        }

         
        
       </script>
@endsection