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
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li><a href="{{url('/customerList')}}">List</a></li>
                        <li class="active">                
                            @if(isset($customer))
                                <a>Edit</a>
                            @else
                                <a>Add New</a>
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
                        @if(isset($customer))
                            <h2>Edit Customer</h2>
                        @else
                            <h2>Add Customer</h2>
                        @endif
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($customer))
                            <form id="form_validation" action = "{{ url('/editCustomer') }}" method = "POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$customer[0]->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" maxlength="100" value="{{$customer[0]->name}}" required>
                                        <label class="form-label">Name</label>
                                    </div>
                                </div>
                                
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="address1" maxlength="190" value="{{$customer[0]->address1}}" required >
                                        <label class="form-label">Address1</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="address2"  maxlength="190" value="{{$customer[0]->address2}}">
                                        <label class="form-label">Address2</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                        <b>Phone Number</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">phone</i>
                                            </span>
                                            <div class="form-line">
                                               <input type="text" class="form-control" id="phone" name="phone"  value="{{$customer[0]->phone}}" placeholder="Ex: +00 (000) 0000000" >
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
                                               <input type="text" class="form-control" id="mobile" name="mobile" value="{{$customer[0]->mobile}}" placeholder="Ex: +00 (000) 0000000" >
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="checkbox" id="isVendor" name="isVendor" {{ $customer[0]->isVendor == 'on' ? "checked":"" }} >
                                    <label for="isVendor">Is Vendor</label>
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
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="checkbox" id="isVendor" name="isVendor"  >
                                    <label for="isVendor">Is Vendor</label>
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
    <script src="{{asset('public/plugins/jquery-validation/jquery.validate.js')}}"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="{{asset('public/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>

     <!-- Autosize Plugin Js -->
    <script src="{{asset('public/plugins/autosize/autosize.js')}}"></script>

    <!-- Moment Plugin Js -->
    <script src="{{asset('public/plugins/momentjs/moment.js')}}"></script>
    
    <!-- Input Mask  Plugin Js -->
    <script src="{{asset('public/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
    
    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <script src="{{asset('public/js/pages/forms/form-validation.js')}}"></script>

    <!-- <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script> -->
    

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

     <script type="text/javascript">
     $(document).ready(function() {
            $('#phone').inputmask({ mask: "+99-999-9999999"});
            $('#mobile').inputmask({ mask: "+99-999-9999999"});
    });

    </script>


@endsection