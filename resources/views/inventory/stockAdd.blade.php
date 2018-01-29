@extends('layouts.app')

@section('css')
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('public/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('public/plugins/animate-css/animate.css') }}" rel="stylesheet" />

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
                        <li><a href="{{url('/stock')}}">Stock Taking</a></li>
                        <li class="active">                
                            @if(isset($stock))
                                <a>Edit Stock Taking</a>
                            @else
                                <a>Add Stock Taking</a>
                            @endif 
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
                            <h2>Add Stock Taking</h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($stock))
                            <form id="form_validation" action="javasctipt:0;">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                   
                                    <div class="col-sm-6">
                                        <label class="form-label">Date*</label>
                                        <input type="text" id="stock_date_edit" name="stock_date_edit" class="datepicker form-control" placeholder="Choose Date..." value="{{$stock[0]->stock_date}}" required>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <label class="form-label">Warehouse*</label>
                                        <select id="stock_warehouse_edit" name="stock_warehouse_edit" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Warehouse</option>
                                            @foreach ($warehouses as $warehouse)    
                                                <option value="{{$warehouse->id}}" {{ $stock[0]->warehouse_id == "$warehouse->id" ? "selected":"" }}>{{$warehouse->warehouse_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                               
                               </div>

                                <table id="exampleStockEdit"  class="table  table-striped table-hover dataTable js-exportable">
                                   <thead>
                                        <tr>
                                            <th class="col-sm-3" style="text-align:center">Product Name</th>
                                            <th class="col-sm-3" style="text-align:center">Quantity in Stock</th>
                                            <th class="col-sm-3" style="text-align:center">Actual Quantity</th>
                                            <th class="col-sm-3" style="text-align:center">Reason of Diff</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stock as $stock)
                                        <tr id='{{$stock->id}}'>
                                            <td style="display:none"><input type="hidden" value="{{ $stock->product_id}}" name='productId'></td>
                                            <td style="display:none"><input type="hidden" value="{{ $stock->id}}" name='stockTakingDeatilId'></td>
                                            <td class="col-sm-3" style="text-align:center">{{ $stock->pName}}</td>
                                            <td class="col-sm-3" style="text-align:center">{{ $stock->quantity_in_stock}}</td>
                                            <td class="col-sm-3" style="text-align:center"><input type="text" name="actualQuantity" value="{{ $stock->actual_quantity}}" class="form-control"></td>
                                            <td class="col-sm-3" style="text-align:center"><input type="text" name="actualQuantity" value="{{ $stock->reason_of_diff}}" class="form-control"></td>
                                            
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                                <button class="btn btn-primary waves-effect" onclick="updateStock({{$stock->stockID}});">SUBMIT</button>
                            </form> 
                            @else
                            {{--  ADD Form  --}}
                            <form id="challan_form_validation" action="javasctipt:0;">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    
                                    <div class="col-sm-6">
                                        <label class="form-label">Date*</label>
                                        <input type="text" id="stock_date" name="stock_date" class="datepicker form-control" placeholder="Choose Date..." value="" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Warehouse*</label>
                                        <select id="stock_warehouse" name="stock_warehouse" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Warehouse</option>
                                            @foreach ($warehouses as $warehouse)    
                                                <option value="{{$warehouse->id}}" >{{$warehouse->warehouse_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                               
                                <table id="exampleStock"  class="table  table-striped table-hover dataTable js-exportable">
                                   <thead>
                                        <tr>
                                            <th class="col-sm-3" style="text-align:center">Product Name</th>
                                            <th class="col-sm-3" style="text-align:center">Quantity in Stock</th>
                                            <th class="col-sm-3" style="text-align:center">Actual Quantity</th>
                                            <th class="col-sm-3" style="text-align:center">Reason of Difference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr>
                                            <td colspan="6" >
                                                <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#stockModal" style="float: left;"> 
                                                <i class="material-icons">add</i>
                                               </a>    
                                              
                                            </td>
                                        </tr> -->
                                      
                                    </tbody>
                                </table>
                                <button class="btn btn-primary waves-effect"  onclick="addStock();">SUBMIT</button>
                            </form>
                            @endif
                            
                        </div>
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
    <script src="{{asset('public/js/pages/forms/form-validation.js')}}"></script>

    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>
    <script src="{{asset('public/stockScript.js')}}"></script>
@endsection