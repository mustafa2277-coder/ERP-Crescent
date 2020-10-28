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
                        <li class="active"><a>Product Detail & Stock Value Report</a></li>
                    </ol>
            </div>
            
        <!-- Bordered Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 30px;">
                    <div class="card">
                        <div class="header">

                            <h2>
                                Product Detail & Stock Value Report
                                <!-- <a class="btn btn-primary btn-circle waves-effect waves-circle waves-float" style="margin-bottom: 14px;float:right;" accesskey="+" tabindex='1' id="add_new" href="{{ url('/getAddProduct')}}"> 
                                    <i class="material-icons" title="Create New">add</i>
                                </a> -->
                            </h2>
                              
                        </div>
                        <div class="body">
                            <form id="" method="post" action="{{url('productDeatil')}}" >
                                    {{ csrf_field() }}
                                <div class="col-sm-6 disp" >
                                    <label class="form-label">Category*</label>
                                    <select  id="cat" name="cat" class="form-control show-tick" data-live-search="true" >
                                        <option value="" selected="selected" disabled="disabled">Products By Category</option>
                                        @foreach ($cats as $cat)    
                                            <option value="{{$cat->id}}"  >{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 disp" >
                                    <label class="form-label">Subcategory*</label>
                                    <select  id="sub" name="sub" class="form-control show-tick" data-live-search="true" >
                                        <option value="" selected="selected" disabled="disabled">Products By sub category</option>
                                        @foreach ($subs as $sub)    
                                            <option value="{{$sub->id}}" >{{$sub->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <button class="btn btn-primary waves-effect"  id="n_submit" >Search</button>
                            </form>
                        </div>
                        <div class="body table-responsive">
                            
                        <?php   $i=1;  ?>
                            <table class="table table-striped table-hover" id="listOfProducts">
                                <thead>
                                    <tr style="background: #f44336;color: #fff;">
                                        <th style="text-align:center">#</th>
                                        <th style="text-align:center">Name</th>
                                        <th style="text-align:center">weight</th>
                                        <th style="text-align:center">Vendor</th>
                                        <th style="text-align:center">Category</th>
                                        <th style="text-align:center">Qauntity in Hand</th>
                                        <th style="text-align:center">Sale Price</th>
                                        <th style="text-align:center">Purchase Price</th>
                                        <th style="text-align:center">Total Sale Price Value</th>
                                        <th style="text-align:center">Total Purchase Price Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($productDeatil))
                                    @foreach($productDeatil as $product)
                                        <tr>
                                            <th style="text-align:center" scope="row">{{$i++}}</th>
                                            <td style="text-align:center">{{$product->name}}</td>
                                            <td style="text-align:center">{{$product->weight}} {{$product->uName}}</td>
                                            <td style="text-align:center">{{$product->cName}}</td>
                                            <td style="text-align:center">{{$product->categoryName}}</td>
                                            <td style="text-align:center">{{$product->quantity_in_hand}}</td>
                                            <td style="text-align:center">{{$product->salePrice}}</td>
                                            <td style="text-align:center">{{$product->purchasePrice}}</td>
                                            <td style="text-align:center">{{$product->salePrice*$product->quantity_in_hand}}</td>
                                            <td style="text-align:center">{{$product->purchasePrice*$product->quantity_in_hand}}</td>
                                        </tr>
                                    @endforeach  
                                @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan='8' ><b>Total Stock Value</b></td>
                                        <td > <span style="float:right;"id ='totalSaleValue'></span> </td>
                                        <td > <span style="float:right;"id ='totalPurchaseValue'></span> </td>
                                    </tr>
                                </tfoot>
                            </table>
                            {{-- <a class="btn btn-primary waves-effect" href="http://localhost/ERP/productDetailPdf">Print</a> --}}
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
    <script src="{{asset('public/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script> 

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
    <script>
        $(document).ready(function(){
            
            $('#listOfProducts').DataTable({
                dom: 'Bfrtip',
                "sPaginationType": "full_numbers",
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;	 
                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                          return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ?	i : 0;
                        };

                        total_amount = api.column( 8 ).data().reduce( function (a, b) {
                          return intVal(a) + intVal(b);
                        },0 );
                        total_amount1 = api.column( 9 ).data().reduce( function (a, b) {
                          return intVal(a) + intVal(b);
                        },0 );

                        total_page_amount = api.column( 8, { page: 'current'} ).data().reduce( function (a, b) {
                          return intVal(a) + intVal(b);
                        }, 0 );
                        total_page_amount1 = api.column( 9, { page: 'current'} ).data().reduce( function (a, b) {
                          return intVal(a) + intVal(b);
                        }, 0 );
                    
                        total_page_amount=parseFloat(total_page_amount);
                        total_page_amount1=parseFloat(total_page_amount1);
                       
                        total_amount = parseFloat(total_amount);
                        // Update footer
                  
                        $('#totalSaleValue').html(total_page_amount.toFixed(2)+" / <b>"+total_amount.toFixed(2)+"</b>");
                        $('#totalPurchaseValue').html(total_page_amount1.toFixed(2)+" / <b>"+total_amount1.toFixed(2)+"</b>");				
                      },
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'potrait',
                        pageSize: 'A4'
                    }
                ]
            });
        });
    </script>
    
@endsection