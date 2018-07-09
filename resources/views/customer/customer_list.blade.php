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
        @if(sizeof($customerList)>0)
            @if($customerList[0]->isVendor=="on")
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li class="active"><a>Vendors</a></li>
                    </ol>
            </div>
            @else
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li class="active"><a>Customers</a></li>
                    </ol>
            </div>
            @endif
        @endif
        <div class="container-fluid">
            <div class="block-header">

            <a href="{{ url('/getAddCustomer') }}/{{$chkVendor}}" type="button" class="btn btn-primary btn-circle waves-effect waves-circle waves-float" accesskey="+" title="Add New" ><i class="material-icons">add</i></a>
                     
            </div>
            
            <!-- Basic Example -->
            <div class="row clearfix">
            @foreach($customerList as $cus)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="header bg-red">
                            <h2>
                                {{$cus->name}} {{--  <small>Description text here...</small>  --}}
                            </h2>
                            <ul class="header-dropdown m-r-0">
                                <li>
                                    <a href="{{ url('/getEditCustomer') }}/{{$cus->id}}" ><i class="material-icons">edit</i></a>
                                </li>
                            </ul>
                            
                        </div>
                        <div class="body">
                            <i class="material-icons">phone_android</i><b> Mobile:</b> {{$cus->mobile}} <br>
                            <i class="material-icons">phone</i><b> Phone:</b> {{$cus->phone}} <br>
                            <i class="material-icons">location_city</i><b> Address 1:</b> {{$cus->address1}} <br>  
                            <i class="material-icons">location_city</i><b> Address 2:</b> {{$cus->address2}}
                        </div>
                    </div>
                </div>
            @endforeach  
            </div>
            {{$customerList->links()}}
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

