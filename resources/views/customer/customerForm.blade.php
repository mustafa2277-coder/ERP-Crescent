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
        <div class="container-fluid">
            {{--  <div class="block-header">
            </div>  --}}
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Add Customers</h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($customer))
                            <form id="form_validation" action = "{{ url('/editCustomer') }}" method = "POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$customer[0]->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" value="{{$customer[0]->name}}" required>
                                        <label class="form-label">Name</label>
                                    </div>
                                </div>
                                
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="address1" value="{{$customer[0]->address1}}" required >
                                        <label class="form-label">Address1</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="address2" value="{{$customer[0]->address2}}">
                                        <label class="form-label">Address2</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="phone" value="{{$customer[0]->phone}}">
                                        <label class="form-label">Phone</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="mobile" value="{{$customer[0]->mobile}}" required>
                                        <label class="form-label">Mobile</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="checkbox" id="isVendor" name="isVendor" {{ $customer[0]->isVendor == 'on' ? "checked":"" }} >
                                    <label for="isVendor">Is Vendor</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <label class="form-label">Receiveable Account Head</label>
                                        <select  id="type_id" name="debit" class="form-control show-tick" data-live-search="true" required>

                                        @foreach ($accountHeads as $accountHead)    
                                            <option value="{{$accountHead->id}}" {{ $accountHead->id == $customer[0]->debitAccHeadId ? "selected":"" }}>{{$accountHead->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <label class="form-label">Payable Account Head</label>
                                        <select  id="type_id" name="credit" class="form-control show-tick" data-live-search="true" required>
                                           
                                        @foreach ($accountHeads as $accountHead)    
                                            <option value="{{$accountHead->id}}" {{ $accountHead->id == $customer[0]->creditAccHeadId ? "selected":"" }}>{{$accountHead->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                {{--  <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea name="description" cols="30" rows="5" class="form-control no-resize" required></textarea>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>  
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password" required>
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="checkbox" name="checkbox">
                                    <label for="checkbox">I have read and accept the terms</label>
                                </div>
                                --}}
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                            @else
                            {{--  ADD Form  --}}
                            <form id="form_validation" action = "{{ url('/addCustomer') }}" method = "POST">
                                {{ csrf_field() }}
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" required>
                                        <label class="form-label">Name</label>
                                    </div>
                                </div>
                                
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="address1" required >
                                        <label class="form-label">Address1</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="address2" >
                                        <label class="form-label">Address2</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="phone" >
                                        <label class="form-label">Phone</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="mobile" required>
                                        <label class="form-label">Mobile</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="checkbox" id="isVendor" name="isVendor"  >
                                    <label for="isVendor">Is Vendor</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <label class="form-label">Receiveable Account Head</label>
                                        <select  id="type_id" name="debit" class="form-control show-tick" data-live-search="true" required>

                                        @foreach ($accountHeads as $accountHead)    
                                            <option value="{{$accountHead->id}}" {{ $accountHead->name == "Account Receivable" ? "selected":"" }}>{{$accountHead->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <label class="form-label">Payable Account Head</label>
                                        <select  id="type_id" name="credit" class="form-control show-tick" data-live-search="true" required>
                                           
                                        @foreach ($accountHeads as $accountHead)    
                                            <option value="{{$accountHead->id}}" {{ $accountHead->name == "Account Receivable" ? "selected":"" }}>{{$accountHead->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                {{--  <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea name="description" cols="30" rows="5" class="form-control no-resize" required></textarea>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>  
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password" required>
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="checkbox" name="checkbox">
                                    <label for="checkbox">I have read and accept the terms</label>
                                </div>
                                --}}
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

    
    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <script src="{{asset('public/js/pages/forms/form-validation.js')}}"></script>

    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>
@endsection