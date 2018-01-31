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
                        <!-- <li><a href="{{url('/stock')}}">Stock Taking</a></li> -->
                        <li class="active">
                            <a>Product Summary</a> 
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
                            <h2>Product Summary</h2>
                        </div>
                        <div class="body">
                            <form id="challan_form_validation" action="javasctipt:0;">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <label class="form-label">Record Search By Category</label>
                                        <select id="by_category" name="by_category" class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected="selected" disabled="disabled">Select Category</option>
                                            @foreach ($productcategories as $productcategorie)    
                                                <option value="{{$productcategorie->id}}" >{{$productcategorie->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- <div class="col-sm-6">
                                        <label class="form-label">By Weight</label>
                                        <select id="by_weight" name="by_weight" class="form-control show-tick" data-live-search="true" required>
                                            
                                        </select>
                                    </div> -->
                                </div>    
                               
                                <?php   $i=1;  ?>
                                <table id="listofProductsSummary" class="table table-striped table-hover">
                                    <thead>
                                        <tr style="background: #f44336;color: #fff;">
                                            <!-- <th style="text-align:center">#</th> -->
                                            <th style="text-align:center">Name</th>
                                            <th style="text-align:center">Code</th>
                                            <th style="text-align:center">Weight</th>
                                            <th style="text-align:center">Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($productsSummery as $product)
                                        <tr>
                                            <!-- <th style="text-align:center" scope="row">{{$i++}}</th> -->
                                            <td style="text-align:center">{{$product->name}}</td>
                                            <td style="text-align:center">{{$product->code}}</td>
                                            <td style="text-align:center">{{$product->weight}} {{$product->uName}}</td>
                                            <td style="text-align:center">{{$product->cName}}</td>
                                        </tr>
                                    @endforeach  
                                    </tbody>
                                </table>
                                <a id="productSummaryByCategory" class="btn btn-primary waves-effect" href="http://localhost/ERP/productSummaryPdf">Print</a>
                            </form>
                        
                            
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
    <script src="{{asset('public/productSummary.js')}}"></script>
@endsection