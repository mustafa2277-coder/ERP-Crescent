
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

    <!-- JQuery DataTable Css -->
    <link href="{{asset('public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('public/css/themes/all-themes.css')}}" rel="stylesheet" />

     <!-- JQuery Nestable Css -->
    <link href="{{asset('public/plugins/nestable/jquery-nestable.css')}}" rel="stylesheet" />
   
@endsection

@section('content')


    <section class="content">
        <div class="container-fluid">
          <!--   <div class="block-header">
                <h2>
                    JQUERY DATATABLES
                    <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small>
                </h2>
            </div> -->
            <!-- #END# Basic Examples -->
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                            <div class="header">
                           
                                <h2>
                                     Chart of Accounts
                                </h2>
                         
                           <a class="btn btn-primary btn-circle-lg waves-effect waves-circle waves-float" id="add_new" href="{{ url('/addAccountHead')}}"> 
                            <i class="material-icons">add</i>
                           </a>       
                        </div>
                        <div class="body">
                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($accountHeads as $accountHead)
                                        <tr>
                                            <td>{{$accountHead->code}} </td>
                                            <td>{{$accountHead->name}} </td>
                                            <td>{{$accountHead->type}} </td>
                                            <td> <a href="{{url('/editAccountHead')}}/{{$accountHead->id}}">Edit</a></td>
                                        </tr>

                                        @endforeach  
                                        
                                    </tbody>
                                </table>
                            </div>
                             <div class="clearfix m-b-20">
                                <div class="dd">
                                    <ol class="dd-list">

                                     @foreach ($accountHeads2 as $accountHead2)
                                     <li class="dd-item" data-id="1">
                                            <div class="dd-handle">{{$accountHead2->parent}}</div>
                                            
                                            @foreach ($accountHeads3 as $accountHead3)
                                            @if($accountHead3->parentid==$accountHead2->parentid)
                                
                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="3">
                                                    <div class="dd-handle">{{$accountHead3->child}}</div>
                                                </li>
                                            </ol>
                                       
                                            @endif
                                             @endforeach
                                    </li>
                                     @endforeach 


                                        <li class="dd-item" data-id="1">
                                            <div class="dd-handle">Item 1</div>
                                        </li>
                                        <li class="dd-item" data-id="2">
                                            <div class="dd-handle">Item 2</div>
                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="3">
                                                    <div class="dd-handle">Item 3</div>
                                                </li>
                                                <li class="dd-item" data-id="4">
                                                    <div class="dd-handle">Item 4</div>
                                                </li>
                                                <li class="dd-item" data-id="5">
                                                    <div class="dd-handle">Item 5</div>
                                                    <ol class="dd-list">
                                                        <li class="dd-item" data-id="6">
                                                            <div class="dd-handle">Item 6</div>
                                                        </li>
                                                        <li class="dd-item" data-id="7">
                                                            <div class="dd-handle">Item 7</div>
                                                        </li>
                                                        <li class="dd-item" data-id="8">
                                                            <div class="dd-handle">Item 8</div>
                                                        </li>
                                                    </ol>
                                                </li>
                                                <li class="dd-item" data-id="9">
                                                    <div class="dd-handle">Item 9</div>
                                                </li>
                                                <li class="dd-item" data-id="10">
                                                    <div class="dd-handle">Item 10</div>
                                                </li>
                                            </ol>
                                        </li>
                                        <li class="dd-item" data-id="11">
                                            <div class="dd-handle">Item 11</div>
                                        </li>
                                        <li class="dd-item" data-id="12">
                                            <div class="dd-handle">Item 12</div>
                                        </li>
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

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('public/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <!-- Jquery Nestable -->
    <script src="{{asset('public/plugins/nestable/jquery.nestable.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script>
    <script src="{{asset('public/js/pages/ui/sortable-nestable.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>


@endsection