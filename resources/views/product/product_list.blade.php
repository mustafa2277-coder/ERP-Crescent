@extends('layouts.app')

@section('css')
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('public/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('public/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('public/plugins/animate-css/animate.css') }}" rel="stylesheet" />
     <!-- Bootstrap Select Css -->
     <link href="{{asset('public/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

     <!-- JQuery DataTable Css -->
     {{-- <link href="{{asset('public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet" /> --}}
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
                        <li class="active"><a>Products</a></li>
                    </ol>
            </div>
            
        <!-- Bordered Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 30px;">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Products Filter
                                {{-- <a href="javascript:void(0);" class="js-search" data-close="true" title="Search"><i class="material-icons">search</i></a> --}}
                                <a class="btn btn-primary btn-circle waves-effect waves-circle waves-float" style="margin-bottom: 14px;float:right;" accesskey="+" tabindex='1' id="add_new" href="{{ url('/getAddProduct')}}"> 
                                    <i class="material-icons" title="Create New">add</i>
                                </a>
                               {{--  <a class="btn btn-danger btn-circle waves-effect waves-circle waves-float" style="margin-bottom: 14px;float:right;" target='_blank' id="add_new" href="http://crescent.cherryberry.website/import_product/"> 
                                    <i class="material-icons" title="import">import_export</i>
                                </a> --}}
                                <a class="btn btn-danger btn-circle waves-effect waves-circle waves-float" title="All Products" style="margin-bottom: 14px;float:right;" id="add_new" href="{{ url('/allProductList')}}"> 
                                    <i class="material-icons">select_all</i>
                                </a>
                            </h2>
                            
                           
                        </div>
                        <div class="col-sm-4" style="    margin-top: 24px;">
                            <div class="form-group">
                                <div class="form-line">
                                    <label><i class="material-icons">search</i> Search</label>
                                    <input type="text" class="typeahead form-control" placeholder="Search Products...">
                                </div>
                            </div>
                                
                        </div>
                        <div class="form-group form-float" style="    margin-top: 24px;">
                        <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label><i class="material-icons">search</i> Search By category</label>
                                        <select  id="cat" name="cat" class="form-control show-tick" data-live-search="true">
                                            <option value="" selected="selected" disabled="disabled">Products By Category</option>
                                            @foreach ($cats as $cat)    
                                                <option value="{{$cat->id}}"  >{{$cat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label><i class="material-icons">search</i> Search By subcategory</label>
                                        <select  id="sub" name="sub" class="form-control show-tick" data-live-search="true">
                                            <option value="" selected="selected" disabled="disabled">Products By sub category</option>
                                            @foreach ($subs as $sub)    
                                                <option value="{{$sub->id}}" >{{$sub->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                        <style>
                            .dropdown-menu {
                                min-width: 100% !important;
                            }
                            typeahead-container {
                                width: 100% !important;    
                            }
                        </style>
                        
                        <div class="body table-responsive">
                        @if(isset($productList))
                            <?php   $i=1;  ?>
                            <table class="table table-striped table-hover" id="product_table">
                                <thead>
                                    <tr style="background: #f44336;color: #fff;">
                                       
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Unit</th>
                                        <th>Category</th>
                                        <th>Qty</th>
                                       <!-- <th>Type</th> -->
                                
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($productList as $product)
                                    <tr>
                                        
                                        <td>{{$product->code}}</td>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->weight}} {{$product->unit}}</td>
                                        <td>{{$product->category}}</td>
                                        <td>{{$product->quantity_in_hand}}</td>
                                       <!-- <td></td> -->
                                        
                                        <td>
                                            <a href="{{ url('/getEditProduct') }}/{{$product->id}}" ><i class="material-icons">edit</i></a>
                                            <button type="button" class="view_transfer" data-id="{{ $product->id }}"  style="color:red; border:none"><i class="material-icons">remove_red_eye</i></button>
                                        </td>
                                    </tr>
                                @endforeach  
                                
                                </tbody>
                            </table>
                          {{--   {{ $productList->links() }} --}}
                            @endif
                        </div>
                        
                    </div>

                    <!--Show Data Modal --->
                    
                    <div id="showdataModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                      
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Show Product Quantity in Warehouse</h4>
                            </div>
                            <div class="modal-body loadmodal">
                                <table class="table table-striped table-hover" id="product_table">
                                    <thead>
                                        <tr style="background: #f44336;color: #fff;">
                                           
                                            <th>Product</th>
                                            <th>Warehouse</th>
                                            <th>Quantity</th>
                                           <!-- <th>Type</th> -->
                                        </tr>
                                    </thead>
                                </table>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                      
                        </div>
                      </div>


                    <!--End Show Data Modal --->

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
  {{--   <script src="{{asset('public/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>  --}}
    <!-- Slimscroll Plugin Js -->
    <script src="{{asset('public/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>

    <!-- Wait Me Plugin Js -->
    <script src="{{asset('public/plugins/waitme/waitMe.js')}}"></script>

    
    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <script src="{{asset('public/js/view_transfer_script.js') }}"></script>
    <script src="{{asset('public/js/pages/cards/colored.js')}}"></script>
    
    <!--Typeahead -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>
    <script>
        /* $(document).ready(function(){
            var dataTable = $('#product_table').DataTable({
                "paging": true, // Allow data to be paged
         "lengthChange": false,
        "searching": true, // Search box and search function will be actived
        "ordering": true,
        "info": true,
        "autoWidth": true,
         "processing": true,  // Show processing 
         "serverSide": true,  // Server side processing
          "deferLoading": 0, // In this case we want the table load on request so initial automatical load is not desired
          "pageLength": 5,
            "ajax":"{{url('/getSearchProduct')}}",
            "columns":[
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                ]
            });
            dataTable.draw();
        });  */

        
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
                             //console.log('hello'+result);

                              var resultList = result.map(function (item) {
                                 var aItem = { id: item.id, name: item.code+' '+item.name+" _____RS "+item.salePrice };
                                 return aItem;
                             });

                             return process(resultList);

                         }
                    });
                  }

     });
     $('.form-line').on("click","ul.typeahead li", function() {
        var data = $('ul.typeahead li.active').data().value;
        id=data.id;
        window.location.replace("{{url('/getSearchProductList')}}?id="+id);
     });
     $('#sub,#cat').change(function(){
        id=$(this).val();
        window.location.replace("{{url('/getSearchProductList')}}?catId="+id); 
     });
    </script>
@endsection