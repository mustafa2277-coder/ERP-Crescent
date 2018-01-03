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

@section('content')
    <section class="content">
            <a href="{{url('/home')}}">Home >> </a><a href="{{url('/productList')}}">Products >> </a> @if(isset($products))
                                                                                                            <a>Edit Product</a>
                                                                                                        @else
                                                                                                            <a>Add Product</a>
                                                                                                        @endif 
        <div class="container-fluid">
            {{--  <div class="block-header">
            </div>  --}}
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="header">
                            <h2>Add Product</h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($products))
                            <form id="form_validation" action = "{{ url('/editProduct') }}" method = "POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$products->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" maxlength="20" name="code" value="{{$products->code}}"required>
                                        <label class="form-label">Code</label>
                                    </div>
                                     @if ($errors->has('code'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('code') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" maxlength="100" value="{{$products->name}}" required>
                                        <label class="form-label">Name</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea name="description" cols="30" rows="3" class="form-control no-resize" >{{$products->description}}</textarea>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>  
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="weight" maxlength="20" value="{{$products->weight}}" >
                                        <label class="form-label">Weight</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Unit</label>
                                        <select  id="type_id" name="unit" class="form-control show-tick" data-live-search="true">
                                        <option value="" selected="selected" disabled="disabled">Select Unit</option>
                                        @foreach ($units as $unit)    
                                            <option value="{{$unit->id}}" {{ $products->unitId == $unit->id ? "selected":"" }} >{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Category</label>
                                        <select  id="type_id" name="categoryId" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="selected" disabled="disabled">Select Category</option>
                                        @foreach ($category as $category)    
                                            <option value="{{$category->id}}" {{ $products->categoryId == $category->id ? "selected":"" }}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Product Type</label>
                                        <select  id="type_id" name="type" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="selected" disabled="disabled">Select Product Type</option>
                                            
                                            <option value="Consumable" {{ $products->type == "Consumable" ? "selected":"" }} >Consumable</option>
                                            <option value="Service" {{ $products->type == "Service" ? "selected":"" }}>Service</option>
                                            <option value="Stockable Product" {{ $products->type == "Stockable Product" ? "selected":"" }}>Stockable Product</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Manufacture Lead Time</label>
                                    <input type="text" id="date_post1" name="mlt" class="datepicker form-control" placeholder="Choose Date..." value="{{date('d/m/Y', strtotime($products->manfLeadTime))}}" >
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Customer Lead Time</label>
                                    <input type="text" name="clt" id="date_post" class="datepicker form-control" placeholder="Choose Date..."  value="{{date('d/m/Y', strtotime($products->custLeadTime))}}" >
                                </div>
                                
                                
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                            @else
                            {{--  ADD Form  --}}
                            <form id="form_validation" action = "{{ url('/addProduct') }}" method = "POST">
                                {{ csrf_field() }}
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="code" value="{{ old('code') }}" maxlength="20" required>
                                        <label class="form-label">Code*</label>
                                    </div>
                                    @if ($errors->has('code'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('code') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" maxlength="100" class="form-control" value="{{ old('name') }}"  name="name" required>
                                        <label class="form-label">Name*</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea maxlength="200" name="description" cols="30" rows="3" value="{{ old('description') }}" class="form-control no-resize" ></textarea>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div> 

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" value="{{ old('weight') }}"  class="form-control" maxlength="20" name="weight"  >
                                        <label class="form-label">Weight</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Unit</label>
                                        <select  id="type_id" name="unit" class="form-control show-tick" data-live-search="true">
                                        <option value="" selected="selected" disabled="disabled">Select Unit</option>
                                        @foreach ($units as $unit)    
                                            <option value="{{$unit->id}}" >{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Category*</label>
                                        <select  id="type_id" name="categoryId" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="selected" disabled="disabled">Select Category</option>
                                        @foreach ($category as $category)    
                                            <option value="{{$category->id}}" >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Product Type*</label>
                                        <select  id="type_id" name="type" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="selected" disabled="disabled">Select Product Type</option>
                                            
                                            <option value="Consumable" >Consumable</option>
                                            <option value="Service" >Service</option>
                                            <option value="Stockable Product" >Stockable Product</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Manufacture Lead Time</label>
                                    <input type="text" id="date_post1" name="mlt" class="datepicker form-control" placeholder="Choose Date..." value="" >
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Customer Lead Time</label>
                                    <input type="text" name="clt" id="date_post" class="datepicker form-control" placeholder="Choose Date..."  value="" >
                                </div>
                                
                                
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>

                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Validation -->
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
    <script src="{{asset('public/myscript.js')}}"></script>
@endsection