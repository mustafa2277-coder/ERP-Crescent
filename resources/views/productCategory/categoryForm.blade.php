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
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li><a href="{{url('/categoryList')}}">Product Categories>></a></li>
                        <li class="active">                
                                @if(isset($categories))
                                    <a>Subcategory of {{$categories->name}}</a>
                                @elseif(isset($editCategories))
                                    <a>Edit Category</a>
                                @else
                                    <a>Add Category</a>
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
                            
                            @if(isset($categories))
                                <h2>Subcategory of {{$categories->name}}</h2>
                            @elseif(isset($editCategories))
                                <h2>Edit Category</h2>
                            @else
                                <h2>Add Category</h2>
                            @endif
                        </div>
                        <div class="body">
                            {{--  Add Subcategory Form  --}}
                            @if(isset($categories))
                                <form id="form_validation" action = "{{ url('/addCategory') }}" method = "POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="pid" value="{{$categories->id}}">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="sub" value="" maxlength="100" required>
                                            <label class="form-label">Sub Category</label>
                                        </div>
                                    </div>
                                    
                                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                </form>
                            @elseif(isset($editCategories))
                            {{--  Edit Category  --}}
                                <form id="form_validation" action = "{{ url('/editCategory') }}" method = "POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$editCategories->id}}">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="cat" maxlength="100" value="{{$editCategories->name}}" required>
                                            <label class="form-label">Sub Category</label>
                                        </div>
                                    </div>
                                    
                                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                </form>
                            @else
                            {{--  ADD Form  --}}
                                <form id="form_validation" action = "{{ url('/addCategory') }}" method = "POST">
                                    {{ csrf_field() }}
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name" maxlength="100" required>
                                            <label class="form-label">Category</label>
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