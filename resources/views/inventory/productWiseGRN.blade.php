@extends('layouts.app')

@section('css')
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('public/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('public/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="{{asset('public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet" />

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
@section("content")
<section class="content">
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li class="active"><a>Product GRN</a></li>
                    </ol>
            </div>
            
        <!-- Bordered Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 30px;">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Product GRN
                            </h2>
                            
                           
                        </div>
                        
                        <div class="body table-responsive">
                                <form id="form_filter" name = "form" method="POST" action="{{ url('/productGRNReport') }}">
                                    <div class="row clearfix">
                                    
                                     {{ csrf_field() }}    
                                        <div class="col-sm-12"  >
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label><i class="material-icons">search</i> Search</label>
                                                    <input type="text" class="typeahead form-control" placeholder="Search Products..." required>
                                                    <input type="hidden" id="product_id" name="product_id" value="">
                                                </div>
                                            </div>
                                                
                                        </div>
                                        <div class="col-md-4" id="div_start_date">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">date_range</i>
                                                </span>
                                                <div class="form-line">
                                                <input type="text" id="start_date" name="start_date" class="form-control" placeholder="Start date (dd/mm/yyyy)" tabindex='1'>
                                                </div>
                                            </div>
        
                                        </div>
        
                                        <div class="col-md-4" id="div_end_date">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">date_range</i>
                                                     
                                                </span>
                                                <div class="form-line">
                                                <input type="text" id="end_date" name="end_date" class="form-control" placeholder="End date (dd/mm/yyyy)" tabindex='2' >
                                               
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="col-sm-4 " >
                                            
                                            <select  id="warehouse" name="warehouse" class="form-control show-tick" data-live-search="true" required>
                                                    <option value="0" selected="selected" >Warehouse</option>
                                                    @foreach ($warehouses as $warehouse)    
                                                    <option value="{{$warehouse->id}}" >{{$warehouse->warehouse_name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
        
                                        {{-- <div class="col-md-4" id="div_vendor">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select id="filter_vendor" name="filter_vendor" class="form-control show-tick" data-live-search="true" tabindex='4'>
                                                        <option value="0" selected="selected" >All Vendors</option>
                                                        @foreach ($vendors as $vendor)    
                                                        <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                                        @endforeach
                                                    </select>
        
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    
                                    <div class="row clearfix">
                                       
                                        
                                        <div class="col-md-3">
                                            <div class="form-group form-float">
                                                                                
                                         <button class="btn btn-primary waves-effect" type="submit">Search</button>
        
                                           </div>
                                        </div>
                                    </div>
                                </form>
                            @if(isset($cwarehouse))
                                <div class="class="col-sm-12 "">
                                    <center>
                                            <b>Warehouse:</b> {{$cwarehouse[0]->warehouse_name}}&nbsp;&nbsp;&nbsp;
                                            <b>Date:</b> {{$start}} - {{$end}}
                                    </center>  
                                    
                                </div>
                            @endif
                        <br>
                        <?php   $i=1;  ?>

                            <table  id="listOfGrn" class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr style="background: #f44336;color: #fff;">
                                        <th>#</th>
                                        <th>code</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>GRN No.</th>
                                        <th>GRN DATE</th>
                                        <th>Created Date</th>
                                         {{-- <th>Date</th> --}}
                                        {{-- <th>Warehouse</th> --}}
                                
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($grnDetails))
                                    @foreach($grnDetails as $grnDetail)
                                        <tr>
                                            <th scope="row">{{$i++}}</th>
                                            <td>{{$grnDetail->code}}</td>
                                            <td>{{$grnDetail->name}}</td>
                                            <td>{{$grnDetail->product_quantity}}</td>
                                            <td>{{$grnDetail->id}}</td>
                                            <td>{{$grnDetail->grn_date}}</td>
                                            <td>{{$grnDetail->created_at}}</td>
                                           
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <!-- #END# Bordered Table -->
    </section>
            @stop

@section('js')
     <!-- Jquery Core Js -->
     <script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>

     <!-- Bootstrap Core Js -->
     <script src="{{asset('public/plugins/bootstrap/js/bootstrap.js')}}"></script>
 
     <!-- Select Plugin Js -->
     <script src="{{asset('public/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
     <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script> 
 
     <!-- Slimscroll Plugin Js -->
     <script src="{{asset('public/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
 
     {{-- <!-- Jquery Validation Plugin Css -->
     <script src="../../plugins/jquery-validation/jquery.validate.js"></script> --}}
 
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
     {{-- <script src="{{asset('public/js/pages/forms/form-validation.js')}}"></script> --}}
 
     <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
     
    <!--Typeahead -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 

     <!-- Demo Js -->
     <script src="{{asset('public/js/demo.js')}}"></script>
    <script>
        
        $(document).ready(function(){
            $('#start_date').inputmask({ mask: "99/99/9999"});
            $('#end_date').inputmask({ mask: "99/99/9999"});
            $('#listOfGrn').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    }
                ]
            });
        });
        
     $('input.typeahead').typeahead({
        minLength: 3,
        items: 1000,
        
      source:function (query, process) {
                     //alert(query);
                     return $.ajax({
                         url: "{{url('/getSearchProduct')}}",
                         type: 'get',
                         data: { name: query },
                         headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
                         dataType: 'json',
                        success: function (result) {
                            // console.log(result);

                            //  var resultList = result.map(function (item) {
                            //      var aItem = { id: item.id, code: item.code, name: item.name+" _____RS "+item.salePrice};
                            //      return aItem;
                            //  });
                             var resultList = result.map(function (item) {
                                 var aItem = { id: item.id, name: item.code+' '+item.name+" _____RS "+item.salePrice };
                                 return aItem;
                             });

                            console.log(resultList);

                             return process(resultList);

                         }
                    });
                  }

     });
     $('.form-line').on("click","ul.typeahead li", function() {
        var data = $('ul.typeahead li.active').data().value;
        id=data.id;
        //alert(id);
        $('#product_id').val(id);
     });
    </script>
    
@endsection