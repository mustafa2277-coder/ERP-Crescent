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
        <div class="container-fluid">
            {{--  <div class="block-header">
            </div>  --}}
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Add Project</h2>
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($projects))
                            <form id="form_validation" action = "{{ url('/editProject') }}" method = "POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$projects[0]->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="code" value="{{$projects[0]->code}}" required>
                                        <label class="form-label">Project Code</label>
                                    </div>
                                </div>
                                
                                 <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="title" value="{{$projects[0]->title}}" required >
                                        <label class="form-label">Project Title</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="description" value="{{$projects[0]->description}}" >
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="cost" value="{{$projects[0]->cost}}" >
                                        <label class="form-label">Project Cost</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Start Date</label>
                                    <input type="text" id="date_post1" name="start" class="datepicker form-control" placeholder="Please choose Start Date..." value="{{date('d/m/Y', strtotime($projects[0]->start))}}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">End Date</label>
                                    <input type="text" name="end" id="date_post" class="datepicker form-control" placeholder="Please choose End Date..."  value="{{date('d/m/Y', strtotime($projects[0]->end))}}" required>
                                </div>
                                
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Customer</label>
                                        <select  id="type_id" name="customer" class="form-control show-tick" data-live-search="true" required>
                                        <option value="0" selected="selected" disabled="disabled">Select Customer</option>
                                        @foreach ($customers as $customer)    
                                            <option value="{{$customer->id}}" {{ $customer->id == $projects[0]->customerId ? "selected":"" }}>{{$customer->name}}</option>
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
                            <form id="form_validation" action = "{{ url('/addProject') }}" method = "POST">
                                {{ csrf_field() }}
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="code" required>
                                        <label class="form-label">Project Code</label>
                                    </div>
                                </div>
                                
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="title" required >
                                        <label class="form-label">Project Title</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="description" >
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="cost" >
                                        <label class="form-label">Project Cost</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Start Date</label>
                                    <input type="text" id="date_post1" name="start" class="datepicker form-control" placeholder="Please choose Start Date..." required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">End Date</label>
                                    <input type="text" name="end" id="date_post" class="datepicker form-control" placeholder="Please choose End Date..." required>
                                </div>
                                
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Customer</label>
                                        <select  id="type_id" name="customer" class="form-control show-tick" data-live-search="true" required>
                                        <option value="0" selected="selected" disabled="disabled">Select Customer</option>
                                        @foreach ($customers as $customer)    
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                
                                
                                
                                {{--  <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="cost" required>
                                        <label class="form-label">Project Cost</label>
                                    </div>
                                </div>  --}}
                                
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