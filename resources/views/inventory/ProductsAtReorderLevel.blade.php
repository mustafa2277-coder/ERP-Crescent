@extends('layouts.app')

@section('css')
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('public/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('public/plugins/animate-css/animate.css') }}" rel="stylesheet" />

     <!--WaitMe Css-->
    <link href="{{asset('public/plugins/waitme/waitMe.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('public/css/themes/all-themes.css')}}" rel="stylesheet" />
@endsection
@section('content')
    <section class="content">
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li class="active"><a>Products at Reorder Level</a></li>
                    </ol>
            </div>
            
        <!-- Bordered Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 30px;">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Products at Reorder Level
                                <!-- <a class="btn btn-primary btn-circle waves-effect waves-circle waves-float" style="margin-bottom: 14px;float:right;" accesskey="+" tabindex='1' id="add_new" href="{{ url('/getAddProduct')}}"> 
                                    <i class="material-icons" title="Create New">add</i>
                                </a> -->
                            </h2>
                            
                           
                        </div>
                        <div class="body table-responsive">
                        <?php   $i=1;  ?>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr style="background: #f44336;color: #fff;">
                                        <th style="text-align:center">#</th>
                                        <th style="text-align:center">Name</th>
                                        <th style="text-align:center">Re-Order Level</th>
                                        <th style="text-align:center">Quantity in Hand</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($productList as $product)
                                    <tr>
                                        <th style="text-align:center" scope="row">{{$i++}}</th>
                                        <td style="text-align:center">{{$product->name}}</td>
                                        <td style="text-align:center">{{$product->reorder_level}}</td>
                                        <td style="text-align:center">{{$product->quantity_in_hand}}</td>
                                    </tr>
                                @endforeach  
                                </tbody>
                            </table>
                            <a class="btn btn-primary waves-effect" href="http://localhost/ERP/productsatReorderLevelPdf"  >Print</a>
                        </div>

                    </div>
                </div>
            </div>
        <!-- #END# Bordered Table -->
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