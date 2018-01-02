@extends('layouts.app')

@section('css')


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Core Css -->
    <link href="{{asset('public/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

    <!-- Waves Effect Css -->
    <link href="{{asset('public/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('public/plugins/animate-css/animate.css')}}" rel="stylesheet" />


    <!-- Custom Css -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('public/css/themes/all-themes.css')}}" rel="stylesheet" />

     <!-- JQuery Nestable Css -->
    <link href="{{asset('public/plugins/nestable/jquery-nestable.css')}}" rel="stylesheet" />
   
@endsection

@section('content')
    <section class="content">
            <a href="{{url('/home')}}">Home >></a><a> Product Categories</a>
        <div class="container-fluid">    
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                    <div class="card">
                            <div class="header">
                            <a class="btn btn-primary btn-circle waves-effect waves-circle waves-float" style=" float:right; margin-bottom: 4px;" id="add_new" href="{{ url('/getAddCategory')}}"> 
                                    <i class="material-icons" title="Create New">add</i>
                            </a>                     
                                <h2>
                                     Product Categories
                                </h2>
                            </div>
                        <div class="body"> 
                            <div class="clearfix m-b-20">
                                <div class="dd" id="undragable">
                                    <ol class="dd-list">
                                       {!!$arr!!}
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
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

    <!-- Jquery Nestable -->
    <script src="{{asset('public/plugins/nestable/jquery.nestable.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <!-- <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script> -->
    <script src="{{asset('public/js/pages/ui/sortable-nestable.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

    <script type="text/javascript"> $(document).ready(function() {
    $('#undragable').nestable('collapseAll');
    });
    </script>
@endsection