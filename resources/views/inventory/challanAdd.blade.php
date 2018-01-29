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
                        <li><a href="{{url('/challan')}}">Challan</a></li>
                        <li class="active">                
                            @if(isset($challan))
                                <a>Edit Delivery Challan</a>
                            @else
                                <a>Add Delivery Challan</a>
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
                            <h2>Add Delivery Challan</h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($challan))
                            <form id="form_validation" action="javasctipt:0;">
                                {{ csrf_field() }}
                                <div class="col-sm-12">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="challan_no_edit" name="challan_no_edit" value="{{$challan[0]->delivery_challan_no}}" maxlength="20" >
                                                <label class="form-label">Delivery Challan No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Date*</label>
                                        <input type="text" id="challan_date_edit" name="challan_date_edit" class="datepicker form-control" placeholder="Choose Date..." value="{{$challan[0]->delivery_challan_date}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <label class="form-label">Project*</label>
                                        <select id="challan_project_edit" name="challan_project_edit" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Project</option>
                                             @foreach ($projects as $project)    
                                                <option value="{{$project->id}}" {{ $challan[0]->project_id == "$project->id" ? "selected":"" }}>{{$project->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Warehouse*</label>
                                        <select id="challan_warehouse_edit" name="challan_warehouse_edit" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Warehouse</option>
                                            @foreach ($warehouses as $warehouse)    
                                                <option value="{{$warehouse->id}}" {{ $challan[0]->warehouse_id == "$warehouse->id" ? "selected":"" }}>{{$warehouse->warehouse_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>    
                               <div class="col-sm-12 form-group form-float">
                                    <div class="form-line">
                                    <input type="checkbox" id="challan_isValidated_edit" name="challan_isValidated_edit" {{ $challan[0]->delivery_challan_validatedby == 'on' ? "checked":"" }} >
                                    <label for="challan_isValidated_edit">Is Validated</label>
                                    </div>
                                </div>
                              

                                <table id="exampleChallanEdit"  class="table  table-striped table-hover dataTable js-exportable">
                                   <thead>
                                        <tr>
                                            <th >Product Name</th>
                                            <th >Product Quantity</th>
                                            <th ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($challan as $challan)
                                        <tr id='{{$challan->id}}'>
                                            <td style="display:none">{{ $challan->product_id}}</td>
                                            <td >{{ $challan->pName}}</td>
                                            <td >{{ $challan->product_quantity}}</td>
                                            <td ><a onclick="editChallanDetail({{$challan->id}})" data-toggle="modal" data-target="#challanDetailEditModal"><i class="material-icons">edit</i></a></td>
                                            <td ><a  onclick="deleteChallanDetail({{$challan->id}})" class="removebutton">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="8" >
                                                <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#challanModal" style="float: left;"> 
                                                <i class="material-icons">add</i>
                                               </a>    
                                              
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <button class="btn btn-primary waves-effect" onclick="updateChallan({{$challan->challanID}});">SUBMIT</button>
                            </form>
                            <div class="modal fade" id="challanModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">New</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div id="data">
                                                     <form id="challanPopupForm">
                                                         <div class="col-sm-12" id="div_account">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <label class="form-label">Product*</label>
                                                                    <select  id="product_id" name="product_id" class="form-control show-tick" data-live-search="true" required>
                                                                        <option value="0" selected="selected" disabled="disabled">Select Product</option>
                                                                        @foreach ($products as $product)    
                                                                        <option value="{{$product->id}}" {{ $challan->product_id == "$product->id" ? "selected":"" }}>{{$product->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_product_quantity"  name="modal_product_quantity" required>
                                                                    <label class="form-label">Product Quantity</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </form>
                                        </div>
                                        <div class="modal-footer">
                                      
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="addChallanDetailEditTime()">Save</button>
                                        </div>
                                    </div>
                                     </div>
                                      </div>
                                       </div> 



                                       {{-- Inventry Detail Edit Model --}}
                                       <div class="modal fade" id="challanDetailEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">New</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div id="data">
                                                     <form id="challanPopupFormEdit">
                                                         <div class="col-sm-12" id="div_account">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <label class="form-label">Product*</label>
                                                                    <select  id="product_id_edit_challan" name="product_id_edit_challan" class="form-control show-tick" data-live-search="true" required>
                                                                        <option value="0" selected="selected" disabled="disabled">Select Product</option>
                                                                        @foreach ($products as $product)    
                                                                        <option value="{{$product->id}}" {{ $challan->product_id == "$product->id" ? "selected":"" }}>{{$product->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_product_quantity_edit_challan"  name="modal_product_quantity_edit_challan" required>
                                                                    <label class="form-label">Product Quantity</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </form>
                                        </div>
                                        <div class="modal-footer">
                                      
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" name="challan_modal_save_edit_btn" id="challan_modal_save_edit_btn" class="btn btn-primary" >Save</button>
                                        </div>
                                    </div>
                                     </div>
                                      </div>
                                       </div> 
                            @else
                            {{--  ADD Form  --}}
                            <form id="challan_form_validation" action="javasctipt:0;">
                                {{ csrf_field() }}
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" id="delivery_challan_no" name="delivery_challan_no" value="{{ old('code') }}" maxlength="20" >
                                                    <label class="form-label">Delivery Challan No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">Date*</label>
                                            <input type="text" id="delivery_challan_date" name="delivery_challan_date" class="datepicker form-control" placeholder="Choose Date..." value="" required>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <label class="form-label">Project*</label>
                                            <select id="challan_project" name="challan_project" class="form-control show-tick" data-live-search="true" required>
                                                <option value="" selected="selected" disabled="disabled">Select Project</option>
                                                 @foreach ($projects as $project)    
                                                    <option value="{{$project->id}}" >{{$project->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">Warehouse*</label>
                                            <select id="challan_warehouse" name="challan_warehouse" class="form-control show-tick" data-live-search="true" required>
                                                <option value="" selected="selected" disabled="disabled">Select Warehouse</option>
                                                @foreach ($warehouses as $warehouse)    
                                                    <option value="{{$warehouse->id}}" >{{$warehouse->warehouse_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                    </div>
                               <div class="col-sm-12 form-group form-float">
                                    <div class="form-line">
                                    <input type="checkbox" id="challan_isValidated" name="challan_isValidated"  >
                                    <label for="challan_isValidated">Is Validated</label>
                                    </div>
                                </div>
                               
                                <table id="exampleChallan"  class="table  table-striped table-hover dataTable js-exportable">
                                   <thead>
                                        <tr>
                                            <th >Product Name</th>
                                            <th >Product Quantity</th>
                                            <th ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="6" >
                                                <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#challanModal" style="float: left;"> 
                                                <i class="material-icons">add</i>
                                               </a>    
                                              
                                            </td>
                                        </tr>
                                      
                                    </tbody>
                                </table>
                                <button class="btn btn-primary waves-effect"  onclick="addChallan();">SUBMIT</button>
                            </form>
                            <div class="modal fade" id="challanModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">New</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div id="data">
                                                     <form id="challanPopupForm">
                                                         <div class="col-sm-12" id="div_account">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <!-- <label class="form-label">Product*</label> -->
                                                                    <select  id="challan_product_id" name="product_id" class="form-control show-tick" data-live-search="true" required>
                                                                        <option value="0" selected="selected" disabled="disabled">Select Product</option>
                                                                        @foreach ($products as $product)    
                                                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="challan_modal_product_quantity"  name="challan_modal_product_quantity" required>
                                                                    <label class="form-label">Product Quantity</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                        </div>
                                        <div class="modal-footer">
                                      
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="addChallanDetail()">Save</button>
                                        </div>
                                    </div>
                                     </div>
                                      </div>
                                       </div>
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
    <script src="{{asset('public/challanScript.js')}}"></script>
@endsection