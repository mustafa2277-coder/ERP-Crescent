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
                        <li class="active"><a>Projects</a></li>
                    </ol>
            </div>

        <!-- Bordered Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Projects
                                <a class="btn btn-primary btn-circle waves-effect waves-circle waves-float" style="margin-bottom: 14px;float:right;" id="add_new" accesskey="+" href="{{ url('/getAddProject')}}"> 
                                    <i class="material-icons" title="Create New">add</i>
                                </a>
                            </h2>
                            
                           
                        </div>
                        <div class="body table-responsive">
                        <?php   $i=1;  ?>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr style="background: #f44336;color: #fff;">
                                        <th>#</th>
                                        <th>TITLE</th>
                                        <th>Description</th>
                                        <th>Project Code</th>
                                        <th>Cost</th>
                                        <th>Customer</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($projectList as $project)
                                    <tr>
                                        <th scope="row">{{$i++}}</th>
                                        <td>{{$project->title}}</td>
                                        <td>{{$project->description}}</td>
                                        <td>{{$project->code}}</td>
                                        <td>{{$project->cost}}</td>
                                        <td>{{$project->name}}</td>
                                        <td>{{$project->start}}</td>
                                        <td>{{$project->end}}</td>
                                        <td>
                                            <a href="{{ url('/getEditProject') }}/{{$project->id}}" ><i class="material-icons">edit</i></a>
                                        </td>
                                    </tr>
                                @endforeach  
                                </tbody>
                            </table>
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