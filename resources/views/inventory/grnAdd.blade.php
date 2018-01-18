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
                        <li><a href="{{url('/grn')}}">GRN</a></li>
                        <li class="active">                
                            @if(isset($grn))
                                <a>Edit GRN</a>
                            @else
                                <a>Add GRN</a>
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
                            <h2>Add GRN</h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($grn))
                            <form id="form_validation" action="javasctipt:0;">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="grn_no_edit" name="grn_no_edit" value="{{$grn[0]->grn_no}}" maxlength="20" >
                                                <label class="form-label">GRN No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" maxlength="100" class="form-control" value="{{$grn[0]->bill_no}}" id="bill_no_edit"  name="bill_no_edit" required>
                                                <label class="form-label">Bill No*</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Vendor*</label>
                                        <select id="vendor_edit" name="vendor_edit" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Vendor</option>
                                            @foreach ($vendors as $vendor)    
                                                <option value="{{$vendor->id}}" {{ $grn[0]->vendor_id == "$vendor->id" ? "selected":"" }} >{{$vendor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Project*</label>
                                        <select id="project_edit" name="project_edit" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Project</option>
                                             @foreach ($projects as $project)    
                                                <option value="{{$project->id}}" {{ $grn[0]->project_id == "$project->id" ? "selected":"" }}>{{$project->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Warehouse*</label>
                                        <select id="warehouse_edit" name="warehouse_edit" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Warehouse</option>
                                            @foreach ($warehouses as $warehouse)    
                                                <option value="{{$warehouse->id}}" {{ $grn[0]->wareshouse_id == "$warehouse->id" ? "selected":"" }}>{{$warehouse->warehouse_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Date*</label>
                                        <input type="text" id="grn_date_edit" name="grn_date_edit" class="datepicker form-control" placeholder="Choose Date..." value="{{$grn[0]->grn_date}}" required>
                                    </div>
                               <div class="col-sm-12 form-group form-float">
                                    <div class="form-line">
                                    <input type="checkbox" id="isValidated_edit" name="isValidated_edit" {{ $grn[0]->grn_validatedby == 'on' ? "checked":"" }} >
                                    <label for="isValidated">Is Validated</label>
                                    </div>
                                </div>
                               </div>

                                <table id="exampleInvEdit"  class="table  table-striped table-hover dataTable js-exportable">
                                   <thead>
                                        <tr>
                                            <th >Product Name</th>
                                            <th >Product Quantity</th>
                                            <th >Purchased Price</th>
                                            <th >Purchased Currency</th>
                                            <th >Exchange Rate</th>
                                            <th >Price In PKR</th>
                                            <th >Action</th>
                                            <th ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grn as $grn)
                                        <tr id='{{$grn->id}}'>
                                            <td >{{ $grn->pName}}</td>
                                            <td >{{ $grn->product_quantity}}</td>
                                            <td >{{ $grn->purchased_price}}</td>
                                            <td >{{ $grn->purchased_currency}}</td>
                                            <td >{{ $grn->exchange_rate}}</td>
                                            <td >{{ $grn->price_in_pkr}}</td>
                                            <td ><a onclick="editGrnDetail({{$grn->id}})" data-toggle="modal" data-target="#inventryDetailEditModal"><i class="material-icons">edit</i></a></td>
                                            <td ><a  onclick="deleteGrnDetail({{$grn->id}})" class="removebutton">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="8" >
                                                <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#inventryModal" style="float: left;"> 
                                                <i class="material-icons">add</i>
                                               </a>    
                                              
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <button class="btn btn-primary waves-effect" onclick="updateGrn({{$grn->grnID}});">SUBMIT</button>
                            </form>
                            <div class="modal fade" id="inventryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">New</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div id="data">
                                                     <form id="invPopupForm">
                                                         <div class="col-sm-12" id="div_account">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <label class="form-label">Product*</label>
                                                                    <select  id="product_id" name="product_id" class="form-control show-tick" data-live-search="true" required>
                                                                        <option value="0" selected="selected" disabled="disabled">Select Product</option>
                                                                        @foreach ($products as $product)    
                                                                        <option value="{{$product->id}}" {{ $grn->product_id == "$product->id" ? "selected":"" }}>{{$product->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-6" id="div_project">
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
                                                                    <input type="text" class="form-control" id="modal_product_quantity"  name="modal_product_quantity" required>
                                                                    <label class="form-label">Product Quantity</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_product_price"  name="modal_product_price" required>
                                                                    <label class="form-label">Purchased Price</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_purchased_currency"  name="modal_purchased_currency" required>
                                                                    <label class="form-label">Purchased Currency</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_exchange_rate"  name="modal_exchange_rate" required>
                                                                    <label class="form-label">Exchange Rate</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_price_in_pkr"  name="modal_price_in_pkr" required>
                                                                    <label class="form-label">Price in PKR</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </form>
                                        </div>
                                        <div class="modal-footer">
                                      
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="addGrnDetailEditTime()">Save</button>
                                        </div>
                                    </div>
                                     </div>
                                      </div>
                                       </div> 



                                       {{-- Inventry Detail Edit Model --}}
                                       <div class="modal fade" id="inventryDetailEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">New</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div id="data">
                                                     <form id="invPopupFormEdit">
                                                         <div class="col-sm-12" id="div_account">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <label class="form-label">Product*</label>
                                                                    <select  id="product_id_edit" name="product_id_edit" class="form-control show-tick" data-live-search="true" required>
                                                                        <option value="0" selected="selected" disabled="disabled">Select Product</option>
                                                                        @foreach ($products as $product)    
                                                                        <option value="{{$product->id}}" {{ $grn->product_id == "$product->id" ? "selected":"" }}>{{$product->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-6" id="div_project">
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
                                                                    <input type="text" class="form-control" id="modal_product_quantity_edit"  name="modal_product_quantity_edit" required>
                                                                    <label class="form-label">Product Quantity</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_product_price_edit"  name="modal_product_price_edit" required>
                                                                    <label class="form-label">Purchased Price</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_purchased_currency_edit"  name="modal_purchased_currency_edit" required>
                                                                    <label class="form-label">Purchased Currency</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_exchange_rate_edit"  name="modal_exchange_rate_edit" required>
                                                                    <label class="form-label">Exchange Rate</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_price_in_pkr_edit"  name="modal_price_in_pkr_edit" required>
                                                                    <label class="form-label">Price in PKR</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </form>
                                        </div>
                                        <div class="modal-footer">
                                      
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" name="modal_save_edit_btn" id="modal_save_edit_btn" class="btn btn-primary" >Save</button>
                                        </div>
                                    </div>
                                     </div>
                                      </div>
                                       </div> 
                            @else
                            {{--  ADD Form  --}}
                            <form id="form_validation" action = "" method = "POST">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="grn_no" name="grn_no" value="{{ old('code') }}" maxlength="20" >
                                                <label class="form-label">GRN No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" maxlength="100" class="form-control" value="{{ old('name') }}" id="bill_no"  name="bill_no" required>
                                                <label class="form-label">Bill No*</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Vendor*</label>
                                        <select id="vendor" name="vendor" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Vendor</option>
                                            @foreach ($vendors as $vendor)    
                                                <option value="{{$vendor->id}}" >{{$vendor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Project*</label>
                                        <select id="project" name="project" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Project</option>
                                             @foreach ($projects as $project)    
                                                <option value="{{$project->id}}" >{{$project->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Warehouse*</label>
                                        <select id="warehouse" name="warehouse" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Warehouse</option>
                                            @foreach ($warehouses as $warehouse)    
                                                <option value="{{$warehouse->id}}" >{{$warehouse->warehouse_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Date*</label>
                                        <input type="text" id="grn_date" name="grn_date" class="datepicker form-control" placeholder="Choose Date..." value="" required>
                                    </div>
                               <div class="col-sm-12 form-group form-float">
                                    <div class="form-line">
                                    <input type="checkbox" id="isValidated" name="isValidated"  >
                                    <label for="isValidated">Is Validated</label>
                                    </div>
                                </div>
                               </div> 
                                <table id="exampleInv"  class="table  table-striped table-hover dataTable js-exportable">
                                   <thead>
                                        <tr>
                                            <th >Product Name</th>
                                            <th >Product Quantity</th>
                                            <th >Purchased Price</th>
                                            <th >Purchased Currency</th>
                                            <th >Exchange Rate</th>
                                            <th >Price In PKR</th>
                                            <th ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="6" >
                                                <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#inventryModal" style="float: left;"> 
                                                <i class="material-icons">add</i>
                                               </a>    
                                              
                                            </td>
                                        </tr>
                                      
                                    </tbody>
                                </table>
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                            <div class="modal fade" id="inventryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">New</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div id="data">
                                                     <form id="invPopupForm">
                                                         <div class="col-sm-12" id="div_account">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <!-- <label class="form-label">Product*</label> -->
                                                                    <select  id="product_id" name="product_id" class="form-control show-tick" data-live-search="true" required>
                                                                        <option value="0" selected="selected" disabled="disabled">Select Product</option>
                                                                        @foreach ($products as $product)    
                                                                        <option value="{{$product->id}}">{{$product->name}}</option>
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
                                                                    <input type="text" class="form-control" id="modal_product_quantity"  name="modal_product_quantity" required>
                                                                    <label class="form-label">Product Quantity</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_product_price"  name="modal_product_price" required>
                                                                    <label class="form-label">Purchased Price</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_purchased_currency"  name="modal_purchased_currency" required>
                                                                    <label class="form-label">Purchased Currency</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_exchange_rate"  name="modal_exchange_rate" required>
                                                                    <label class="form-label">Exchange Rate</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id="modal_price_in_pkr"  name="modal_price_in_pkr" required>
                                                                    <label class="form-label">Price in PKR</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </form>
                                        </div>
                                        <div class="modal-footer">
                                      
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="addGrnDetail()">Save</button>
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
    <script src="{{asset('public/invScript.js')}}"></script>
@endsection