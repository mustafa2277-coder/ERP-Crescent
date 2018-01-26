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
                        <li><a href="{{url('/projectList')}}">Projects</a></li>
                        <li class="active">                
                                @if(isset($projects))
                                    <a>Edit Projet</a>
                                @else
                                    <a>Add Project</a>
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
                            @if(isset($projects))
                                <h2>Edit Product</h2>
                            @else
                                <h2>Add Project</h2>
                            @endif
                        </div>
                        <div class="body">
                            {{--  Edit Form  --}}
                            @if(isset($projects))
                            <form id="form_validation" action = "{{ url('/editProject') }}" method = "POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$projects[0]->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="code" value="{{$projects[0]->code}}" autofocus required>
                                        <label class="form-label">Project Code*</label>
                                    </div>
                                    @if ($errors->has('code'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('code') }}
                                    </span>
                                    @endif
                                </div>
                                
                                 <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="title" value="{{$projects[0]->title}}" required >
                                        <label class="form-label">Project Title*</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="description" value="{{$projects[0]->description}}" >
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                   <b>Project Cost</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">attach_money</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" id="cost"  name="cost" value="{{$projects[0]->cost}}" class="form-control money-dollar" placeholder="Ex:99.99 ">
                                            </div>
                                        </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Start Date</label>
                                    <input type="text" id="date_post1" name="start" class="stDate form-control" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime($projects[0]->start))}}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">End Date</label>
                                    <input type="text" name="end" id="date_post" class="edDate form-control" placeholder="dd/mm/yyyy"  value="{{date('d/m/Y', strtotime($projects[0]->end))}}">
                                </div>
                                
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Customer*</label>
                                        <select  id="type_id" name="customer" class="form-control show-tick" data-live-search="true" required>
                                        <option value="0" selected="selected" disabled="disabled">Select Customer</option>
                                        @foreach ($customers as $customer)    
                                            <option value="{{$customer->id}}" {{ $customer->id == $projects[0]->customerId ? "selected":"" }}>{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                {{--  <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <label class="form-label">Receiveable Account Head*</label>
                                        <select  id="type_id" name="debit" class="form-control show-tick" data-live-search="true" required>

                                        @foreach ($accountHeads as $accountHead)    
                                            <option value="{{$accountHead->id}}" {{ $accountHead->id == $projects[0]->debitAccHeadId ? "selected":"" }}>{{$accountHead->name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <label class="form-label">Payable Account Head*</label>
                                        <select  id="type_id" name="credit" class="form-control show-tick" data-live-search="true" required>
                                           
                                        @foreach ($accountHeads as $accountHead)    
                                            <option value="{{$accountHead->id}}" {{ $accountHead->id == $projects[0]->creditAccHeadId ? "selected":"" }}>{{$accountHead->name}}</option>
                                        @endforeach
                                        </select>
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
                            @else
                            {{--  ADD Form  --}}
                            <form id="form_validation" action = "{{ url('/addProject') }}" method = "POST">
                                {{ csrf_field() }}
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" maxlength="20" class="form-control"  name="code" autofocus required>
                                        <label class="form-label">Project Code*</label>
                                    </div>
                                    @if ($errors->has('code'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('code') }}
                                    </span>
                                    @endif
                                </div>
                                
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  maxlength="100"class="form-control" name="title" required >
                                        <label class="form-label">Project Title*</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        
                                        <textarea name="description" cols="30" rows="3" class="form-control no-resize" ></textarea>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                   <b>Project Cost</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">attach_money</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" id="cost" name="cost" class="form-control money-dollar" placeholder="Ex:99.99 ">
                                            </div>
                                        </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Start Date</label>
                                    <input type="text"  name="start" class="stDate form-control" placeholder="dd/mm/yyyy" >
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">End Date</label>
                                    <input type="text" name="end"  class="edDate form-control" placeholder="dd/mm/yyyy" >
                                </div>
                                
                                <div class="form-group form-float">
                                    <div class="col-sm-12">
                                        <label class="form-label">Customer*</label>
                                        <select  id="type_id" name="customer" class="form-control show-tick" data-live-search="true" required>
                                        <option value="0" selected="selected" disabled="disabled">Select Customer</option>
                                        @foreach ($customers as $customer)    
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                {{--  <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <label class="form-label">Receiveable Account Head*</label>
                                        <select  id="type_id" name="debit" class="form-control show-tick" data-live-search="true" required>

                                        @foreach ($accountHeads as $accountHead)    
                                            <option value="{{$accountHead->id}}" {{ $accountHead->name == "Account Receivable" ? "selected":"" }}>{{$accountHead->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="col-sm-6">
                                        <label class="form-label">Payable Account Head*</label>
                                        <select  id="type_id" name="credit" class="form-control show-tick" data-live-search="true" required>
                                           
                                        @foreach ($accountHeads as $accountHead)    
                                            <option value="{{$accountHead->id}}" {{ $accountHead->name == "Account Receivable" ? "selected":"" }}>{{$accountHead->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                  --}}
                                
                                
                                {{--  <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="cost" name="cost" required>
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
    <script src="{{asset('public/plugins/jquery-validation/jquery.validate.js')}}"></script>

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
    
    <!-- Input Mask  Plugin Js -->
    <script src="{{asset('public/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
    
    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <script src="{{asset('public/js/pages/forms/form-validation.js')}}"></script>

    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

     <script type="text/javascript">

    $('#start').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
    $('#end').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
   
     $(document).ready(function() {
            $('#cost').inputmask({mask: "9{1,40}.99"});
            $('.stDate').inputmask({ mask: "99/99/9999"});
            $('.edDate').inputmask({ mask: "99/99/9999"});
        });

    </script>
@endsection