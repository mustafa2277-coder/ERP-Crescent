@extends('layouts.app')

@section('css')
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('public/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('public/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="{{asset('public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="{{ asset('public/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{asset('public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />

    <!--WaitMe Css-->
    <link href="{{asset('public/plugins/waitme/waitMe.css')}}" rel="stylesheet" />

     <!-- Bootstrap Select Css -->
    <link href="{{asset('public/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('public/css/themes/all-themes.css') }}" rel="stylesheet" />
@endsection
@section("content")
<section class="content">
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li><a href="{{url('/transfernotes')}}">Transfer Notes</a></li>
                    </ol>
            </div>
            
        <!-- Bordered Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 30px;">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Transfer Notes Search Results
                                <a class="btn bg-light-green waves-effect" style="    margin-left: 2%;" id="add_new" href=""> 
                                    Today's Transfer Notes
                                </a>
                                <a class="btn btn-primary btn-circle waves-effect waves-circle waves-float" style="margin-bottom: 14px;float:right;" id="add_new" href="{{ url('/transfernotesadd') }}"> 
                                    <i class="material-icons" title="Create New">add</i>
                                </a>
                            </h2>
                            
                           
                        </div>
                        
                        <div class="body table-responsive">
                                <form id="form_search" name = "form_search" method="GET" action="{{ url('/filtertransfernotes') }}">
                                    <div class="row clearfix">
                                    
                                        <div class="col-md-4" id="div_start_date">
                                            <label class ="form-label">Start Date</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">date_range</i>
                                                </span>
                                                <div class="form-line">
                                                <input type="date" id="start_date_search" name="start_date_search" class="form-control" placeholder="Start date (dd/mm/yyyy)" tabindex='1'>
                                                </div>
                                            </div>
        
                                        </div>
        
                                        <div class="col-md-4" id="div_end_date">
                                            <label class ="form-label">End Date</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">date_range</i>
                                                     
                                                </span>
                                                <div class="form-line">
                                                <input type="date" id="end_date_search" name="end_date_search" class="form-control" placeholder="End date (dd/mm/yyyy)" tabindex='2' >
                                               
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="col-sm-4 " >
                                                <label class ="form-label">Warehouses</label>
                                            <select  id="from_warehouse_search" name="from_warehouse_search" class="form-control show-tick" data-live-search="true" >
                                                    <option value="0" selected="selected" >All Warehouse</option>
                                                    @foreach($inv_warehouse as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                        
                                        <div class="col-sm-4 " >
                                                <label class ="form-label">To Warehouse</label>
                                            <select  id="to_warehouse_search" name="to_warehouse_search" class="form-control show-tick" data-live-search="true" >
                                                    <option value="0" selected="selected" >All Warehouse</option>
                                                    @foreach($inv_warehouse as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
        
        
                                        {{-- <div class="col-md-4" id="div_vendor">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select id="filter_vendor" name="filter_vendor" class="form-control show-tick" data-live-search="true" tabindex='4'>
                                                        <option value="0" selected="selected" >All Vendors</option>
                                                        @foreach ($vendors as $vendor)    
                                                        <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                                        @endforeach
                                                    </select>
        
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    
                                    <div class="row clearfix">
                                       
                                        
                                        <div class="col-md-3">
                                            <div class="form-group form-float">
                                                                                
                                         <button class="btn btn-primary waves-effect" type="submit">Search</button>
        
                                           </div>
                                        </div>
                                    </div>
                                </form>
                        <?php   $i=1;  ?>

                            <table  id="listOfGrn" class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr style="background: #f44336;color: #fff;">
                                        <th>#</th>
                                        <th>Transfer Code</th>
                                        <th>From Warehouse</th>
                                        <th>To Warehouse</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @foreach($data as $index=>$record)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>Trans {{ $record->transfer_code }}</td>
                                        <td>{{ $record->from_warehouse }}</td>
                                        <td>{{ $record->to_warehouse }}</td>
                                        <td>{{ $record->today_date }}</td>
                                        <td><a href="{{ url('viewtodaytransferedproducts/'.$record->notes_id) }}"><button type="button" class="btn btn-danger view_transfer" ><i class="material-icons">remove_red_eye</i></button></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <!-- #END# Bordered Table -->
    </section>
            @stop

@section('js')
     <!-- Jquery Core Js -->
     <script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>

     <!-- Bootstrap Core Js -->
     <script src="{{asset('public/plugins/bootstrap/js/bootstrap.js')}}"></script>
 
     <!-- Select Plugin Js -->
     <script src="{{asset('public/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script> 
 
     <!-- Slimscroll Plugin Js -->
     <script src="{{asset('public/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
 
     <!-- Jquery Validation Plugin Css -->
     <script src="../../plugins/jquery-validation/jquery.validate.js"></script>
 
     <!-- Sweet Alert Plugin Js -->
     <script src="{{asset('public/plugins/sweetalert/sweetalert.min.js')}}"></script>
 
     <!-- Waves Effect Plugin Js -->
     <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>
 
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
     {{-- <script src="{{asset('public/js/pages/forms/form-validation.js')}}"></script> --}}
 
     <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
     
 
     <!-- Demo Js -->
     <script src="{{asset('public/js/demo.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#start_date').inputmask({ mask: "99/99/9999"});
            $('#end_date').inputmask({ mask: "99/99/9999"});
            $('#listOfGrn').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    }
                ]
            });
        });
    </script>
    
@endsection