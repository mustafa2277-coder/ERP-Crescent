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
                        <!-- <li><a href="{{url('/stock')}}">Stock Taking</a></li> -->
                        <li class="active">
                            <a>Warehouse Report</a> 
                        </li>
                    </ol>
            </div>

        <div class="container-fluid">
            {{--  <div class="block-header">
            </div>  --}}
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="header">
                            <h2>Report of Products by Warehouse</h2>
                        </div>
                        <div class="body">
                            {{--  ADD Form  --}}
                            <form id="challan_form_validation" action="{{url('getWarehouseReport')}}" >
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    
                                    
                                    <div class="col-sm-4">
                                        <label class="form-label">Warehouse*</label>
                                        <select id="report_warehouse" name="report_warehouse" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Warehouse</option>
                                            @foreach ($warehouses as $warehouse)    
                                                <option value="{{$warehouse->id}}" >{{$warehouse->warehouse_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4 disp" >
                                        <label class="form-label">Category*</label>
                                        <select  id="cat" name="cat" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Products By Category</option>
                                            @foreach ($cats as $cat)    
                                                <option value="{{$cat->id}}"  >{{$cat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4 disp" >
                                        <label class="form-label">Subcategory*</label>
                                        <select  id="sub" name="sub" class="form-control show-tick" data-live-search="true" >
                                            <option value="" selected="selected" disabled="disabled">Products By sub category</option>
                                            @foreach ($subs as $sub)    
                                                <option value="{{$sub->id}}" >{{$sub->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <center><input type="submit" name="submit" class="btn btn-primary" style=""></center>
                                    <br>
                                
                                
                            </form>
                            
                            
                        </div>
                        <table id="listofProductsByWarehouse"  class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                     <tr>
                                        <th class="col-sm-3" style="text-align:center">Code</th>
                                         <th class="col-sm-3" style="text-align:center">Product Name</th>
                                         <th class="col-sm-3" style="text-align:center">Category</th>
                                         <th class="col-sm-3" style="text-align:center">Quantity</th>
                                         <th class="col-sm-3" style="text-align:center">Purchased Price</th>
                                         
                                     </tr>
                                 </thead>
                                 <tbody>
                                    
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{$product->pCode}}</td>
                                            <td>{{$product->pName}}</td>
                                            <td>{{$product->category}}</td>
                                            <td>{{$product->quantity_in_hand}}</td>
                                            <td>{{$product->purchased_price}}</td>
                                        </tr>
                                    @endforeach
                                    @foreach($products1 as $product)
                                        <tr>
                                            <td>{{$product->pCode}}</td>
                                            <td>{{$product->pName}}</td>
                                            <td>{{$product->category}}</td>
                                            <td>{{$product->quantity_in_hand}}</td>
                                            <td>{{$product->purchased_price}}</td>
                                        </tr>
                                    @endforeach
                              
                                 </tbody>
                             </table>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Validation -->
        </div>
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

    
    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    {{-- <script src="{{asset('public/js/pages/forms/form-validation.js')}}"></script> --}}

    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>
    <script>
            $(document).ready(function(){
                $('#listofProductsByWarehouse').DataTable({
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
    {{-- <script src="{{asset('public/warehouseReport.js')}}"></script> --}}
    
@endsection