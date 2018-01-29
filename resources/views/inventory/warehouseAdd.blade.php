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
                        <li><a href="{{url('/warehouse')}}">Warehouse</a></li>
                        <li class="active">                
                            @if(isset($warehouse))
                                <a>Edit Warehouse</a>
                            @else
                                <a>Add Warehouse</a>
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
                            <h2>Add Warehouse</h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($warehouse))
                            <form id="form_validation" action = "{{ url('/editWarehouse') }}" method = "POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$warehouse->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" maxlength="20" name="code" value="{{$warehouse->warehouse_code}}"required>
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
                                        <input type="text" class="form-control" name="name" maxlength="100" value="{{$warehouse->warehouse_name}}" required>
                                        <label class="form-label">Name</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" maxlength="100" class="form-control" value="{{$warehouse->warehouse_address}}"  name="address" required>
                                        <label class="form-label">Address*</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" maxlength="100" class="form-control" value="{{$warehouse->warehouse_address2}}"  name="address2" required>
                                        <label class="form-label">Address Two*</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">City*</label>
                                        <select  id="city_id" name="city" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="selected" disabled="disabled">Select City</option>
                                            
                                            <option value="Lahore" {{ $warehouse->warehouse_cityid == "Lahore" ? "selected":"" }} >Lahore</option>
                                            <option value="Islamabad" {{ $warehouse->warehouse_cityid == "Islamabad" ? "selected":"" }}>Islamabad</option>
                                            <option value="Karachi" {{ $warehouse->warehouse_cityid == "Karachi" ? "selected":"" }}>Karachi</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">State*</label>
                                        <select  id="state_id" name="state" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="selected" disabled="disabled">Select State</option>
                                            
                                            <option value="Punjab" {{ $warehouse->warehouse_stateid == "Punjab" ? "selected":"" }} >Punjab</option>
                                            <option value="Sindh" {{ $warehouse->warehouse_stateid == "Sindh" ? "selected":"" }}>Sindh</option>
                                            <option value="KPK" {{ $warehouse->warehouse_stateid == "KPK" ? "selected":"" }}>KPK</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Country*</label>
                                        <select  id="country_id" name="country" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="selected" disabled="disabled">Select Country</option>
                                            
                                            <option value="Pakistan" {{ $warehouse->warehouse_countryid == "Pakistan" ? "selected":"" }} >Pakistan</option>
                                            <option value="UAE" {{ $warehouse->warehouse_countryid == "UAE" ? "selected":"" }}>UAE</option>
                                            <option value="UK" {{ $warehouse->warehouse_countryid == "UK" ? "selected":"" }}>UK</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                        <b>Phone Number</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">phone</i>
                                            </span>
                                            <div class="form-line">
                                               <input type="text" class="form-control" id="phone" name="phone" value="{{$warehouse->warehouse_ph}}" placeholder="Ex: +00 (000) 0000000" required>
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group form-float">
                                        <b>Mobile</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="material-icons">phone_iphone</i>
                                            </span>
                                            <div class="form-line">
                                               <input type="text" class="form-control" id="mobile" name="mobile" value="{{$warehouse->warehouse_mobile}}"  placeholder="Ex: +00 (000) 0000000" required>
                                            </div>
                                        </div>
                                </div>
                                
                                
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                            @else
                            {{--  ADD Form  --}}
                            <form id="form_validation" action = "{{ url('/addWarehouse') }}" method = "POST">
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
                                        <input type="text" maxlength="100" class="form-control" value="{{ old('address') }}"  name="address" required>
                                        <label class="form-label">Address*</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" maxlength="100" class="form-control" value="{{ old('address2') }}"  name="address2" required>
                                        <label class="form-label">Address Two*</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">City*</label>
                                        <select  id="city_id" name="city" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="selected" disabled="disabled">Select City</option>
                                            
                                            <option value="1" >Lahore</option>
                                            <option value="2" >Islamabad</option>
                                            <option value="3" >Karachi</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">State*</label>
                                        <select  id="state_id" name="state" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="selected" disabled="disabled">Select State</option>
                                            
                                            <option value="1" >Punjab</option>
                                            <option value="2" >Sindh</option>
                                            <option value="3" >KPK</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Country*</label>
                                        <select  id="country_id" name="country" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="selected" disabled="disabled">Select Counrty</option>
                                            
                                            <option value="1" >Pakistan</option>
                                            <option value="2" >UAE</option>
                                            <option value="3" >UK</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                        <b>Phone Number</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">phone</i>
                                            </span>
                                            <div class="form-line">
                                               <input type="text" class="form-control" id="phone" name="phone" placeholder="Ex: +00 (000) 0000000" required>
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group form-float">
                                        <b>Mobile</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="material-icons">phone_iphone</i>
                                            </span>
                                            <div class="form-line">
                                               <input type="text" class="form-control" id="mobile" name="mobile"  placeholder="Ex: +00 (000) 0000000" required>
                                            </div>
                                        </div>
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

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>

    <!-- Wait Me Plugin Js -->
    <script src="{{asset('public/plugins/waitme/waitMe.js')}}"></script>

    
    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <script src="{{asset('public/js/pages/cards/colored.js')}}"></script>
    

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>
@endsection