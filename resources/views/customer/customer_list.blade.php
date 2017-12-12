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
        <div class="container-fluid">
            <div class="block-header">

                <a href="{{ url('/getAddCustomer') }}" type="button" class="btn btn-primary btn-circle waves-effect waves-circle waves-float"><i class="material-icons">add</i></a>
                     
            </div>
            
            <!-- Basic Example -->
            <div class="row clearfix">
            @foreach($customerList as $customerList)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="header bg-red">
                            <h2>
                                {{$customerList->name}} {{--  <small>Description text here...</small>  --}}
                            </h2>
                            <ul class="header-dropdown m-r-0">
                                <li>
                                    <a href="{{ url('/getEditCustomer') }}/{{$customerList->custId}}" ><i class="material-icons">edit</i></a>
                                </li>
                            </ul>
                            
                        </div>
                        <div class="body">
                            <i class="material-icons">phone_android</i><b> Mobile:</b> {{$customerList->mobile}} <br>
                            <i class="material-icons">phone</i><b> Phone:</b> {{$customerList->phone}} <br>
                            <i class="material-icons">location_city</i><b> Address 1:</b> {{$customerList->address1}} <br>  
                            <i class="material-icons">location_city</i><b> Address 2:</b> {{$customerList->address2}}
                        </div>
                    </div>
                </div>
            @endforeach  
            </div>
       
            <!-- #END# Colored Card - With Loading -->
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

