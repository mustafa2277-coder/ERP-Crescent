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

    <!-- Sweet Alert Css -->
    <link href="{{asset('public/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
    

    <!-- Bootstrap Select Css -->
    <link href="{{asset('public/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('public/css/themes/all-themes.css')}}" rel="stylesheet" />

@endsection

@section('content')

@if (isset($record))
    <section class="content">
            <div class="body">
                <ol class="breadcrumb breadcrumb-bg-red">
                    <li><a href="{{url('/home')}}">Home</a></li>
                    <li><a href="{{url('/getAccountHeads')}}">Account Heads</a></li>
                    <li class="active"><a>Update Account Heads</a></li>
                </ol>
            </div>
            <a href="{{url('/home')}}">Home >></a><a href="{{url('/getAccountHeads')}}">Account Heads>></a><a>Update Account Heads</a>
            
        <div class="container-fluid">
          
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Update Account Head</h2>
                          <!--   <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul> -->
                        </div>
                        <div class="body">
                            <form id="form_validation" name = "form" action = "{{ url('/updateAccountHead') }}" method="POST">
                                 {{ csrf_field() }}
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="hidden"  name="acchead_id" value='{{$record->id}}'> 
                                        <input type="text" class="form-control" id="acchead_code" value='{{$record->code}}' name="acchead_code" required>
                                        <label class="form-label">Code</label>
                                    </div>
                                    @if ($errors->has('acchead_code'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('acchead_code') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="acchead_name" value='{{$record->name}}' name="acchead_name" maxlength="100" required>
                                        <label class="form-label">Name</label>
                                    </div>
                                    @if ($errors->has('acchead_name'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('acchead_name') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                     <div class="form-line">
                                        <input type="text" class="form-control" id="open_balance" value='{{$record->openingBalance}}' name="open_balance" >
                                        <label class="form-label">Opening Balance</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="checkbox" id="is_tran" name="is_tran" <?php echo $record->isTransactional=='1'?'checked':'unchecked' ?> >
                                    <label for="is_tran">Is Transactional</label>
                                    </div>
                                   @if ($message = Session::get('error'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{$message}}
                                    </span>
                                    @endif
                                </div>
                               
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select  id="type_id" name="type_id" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="" disabled="">Select Type</option>
                                        @foreach ($types as $type)    
                                        <option value="{{$type->id}}" {{$record->accHeadTypeId==$type->id ? 'selected' : ''}}>{{$type->type}}</option>
                                        @endforeach
                                    </select>
                                        
                                    </div>
                                </div>
                         
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           
    </section>

@else

   <section class="content">
        <ol class="breadcrumb breadcrumb-bg-red">
                <li><a href="{{url('/home')}}">Home</a></li>
                <li><a href="{{url('/getAccountHeads')}}">Account Heads</a></li>
                <li class="active"><a>Add New Account Heads</a></li>
        </ol>
          
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Add New Account Head</h2>
                          <!--   <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul> -->
                        </div>
                        <div class="body">
                        
                            <form id="addn" name = "form" action = "{{ url('/insertAccountHead') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="hidden"  name="parent_id" value='{{$parentId}}'> 
                                        <input type="text" class="form-control" id="acchead_code"  name="acchead_code" required>
                                        <label class="form-label">Code</label>
                                    </div>
                                      @if ($errors->has('acchead_code'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('acchead_code') }}
                                    </span>
                                @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="acchead_name"  name="acchead_name" maxlength="100" required>
                                        <label class="form-label">Name</label>
                                    </div>
                              @if ($errors->has('acchead_name'))
                                    <span class="help-block" style="color: red; font-size: 12px;">
                                        * {{ $errors->first('acchead_name') }}
                                    </span>
                                @endif
                                </div>
                                <div class="form-group form-float">
                                     <div class="form-line">
                                        <input type="text" class="form-control" id="open_balance" name="open_balance">
                                        <label class="form-label">Opening Balance</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="checkbox" id="is_tran" name="is_tran">
                                    <label for="is_tran">Is Transactional</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select  id="type_id" name="type_id" class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected="" disabled="">Select Types</option>
                                        @foreach ($types as $type)    
                                        <option value="{{$type->id}}">{{$type->type}}</option>
                                        @endforeach
                                    </select>
                                        
                                    </div>
                                </div>
                         
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           
    </section> 
@endif
    
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

    <!-- JQuery Steps Plugin Js -->
    <script src="{{asset('public/plugins/jquery-steps/jquery.steps.js')}}"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="{{asset('public/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>
    
   <!-- Input Mask  Plugin Js -->
    <script src="{{asset('public/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

 <script type="text/javascript">
     $(document).ready(function() {
            $('#acchead_code').inputmask({ mask: "9-99-999"});
            $('#open_balance').inputmask({mask: "9{1,40}.99"});
        });

    </script>
@endsection