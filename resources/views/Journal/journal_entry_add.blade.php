
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
                            <form id="form_validation" name = "form" method="POST">
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
                                            <input type="text"  name="date_post" id="pdate" tabindex="3" class="form-control date" >
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
                            <!-- <div class="table-responsive"> -->

                                <table id="example"  class="table  table-striped table-hover dataTable js-exportable">
                                   <thead>
                                        <tr>
                                            <th>ACCOUNT</th>
                                            <th></th>
                                            <th style='text-align:center'>DEBIT</th>
                                            <th style='text-align:center'>CREDIT</th>
                                            <th></th>
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
                                            <td colspan="5" >
                                                <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#New-Entry-Modal" tabindex="5" accesskey="+" style="float: left;"> 
                                                <i class="material-icons">add</i>
                                               </a>    
                                              
                                            </td>
                                         
                                        </tr>
                                      
                                    </tbody>
                                </table>
                            <!-- </div> -->
                            <button class="btn btn-primary waves-effect" type="submit" accesskey="s">SUBMIT</button>

                            </form>

    
<div class="modal fade" id="New-Entry-Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{--  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  --}}
                    <h4 class="modal-title">New</h4>
                </div>
                <div class="modal-body">

                    <div id="data">
                             <form id="person">
                                 <div class="col-sm-12" id="div_account">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                    <select  id="acc_id" name="acc_id" class="form-control show-tick" data-live-search="true" required>
                                         <option value="0" selected="selected" disabled="disabled">Select Account</option>
                                        @foreach ($accounts as $account)    
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                        @endforeach
                                    </select>
                                         </div>
                                    </div>
                                </div>
                               <!--  <div class="col-sm-6" id="div_project">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                    <select  id="project_id" name="project_id" class="form-control show-tick" data-live-search="true" required>
                                         <option value="0" selected="selected" disabled="disabled">Select Project</option>
                                        @foreach ($projects as $project)    
                                        <option value="{{$project->id}}">{{$project->title}}</option>
                                        @endforeach
                                    </select>
                                         </div>
                                    </div>
                                </div> -->
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="modal_debit"  name="modal_debit" required>
                                            <label class="form-label">Debit</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="modal_credit"  name="modal_credit" required>
                                            <label class="form-label">Credit</label>
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                </div>
                <div class="modal-footer">
              
                    <button type="button" class="btn btn-default" accesskey="x" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" accesskey="a" onclick="AddData()">Add</button>
                </div>
            </div>
             </div>
              </div>
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

    <script src="{{asset('public/myscript.js')}}"></script>
  
    <script type="text/javascript">
        $(document).ready(function() {
               $('.date').inputmask({ mask: "99/99/9999"});
               
       });
   
       </script>
@endsection