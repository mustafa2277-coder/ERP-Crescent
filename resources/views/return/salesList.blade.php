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
     <link href="{{asset('public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet" />
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
                                Sales
                                {{-- <a href="javascript:void(0);" class="js-search" data-close="true" title="Search"><i class="material-icons">search</i></a> --}}
                                <a class="btn bg-light-green waves-effect" style="    margin-left: 2%;" id="add_new" href="{{ url('/getTodayReturnSales')}}"> 
                                    Today's Return Sale Record
                                </a>
                               {{--  <a class="btn btn-danger btn-circle waves-effect waves-circle waves-float" style="margin-bottom: 14px;float:right;" target='_blank' id="add_new" href="http://crescent.cherryberry.website/import_product/"> 
                                    <i class="material-icons" title="import">import_export</i>
                                </a> --}}
                                {{-- <a class="btn bg-indigo waves-effect" style="    margin-left: 2%;" id="add_new" href="{{ url('/getAllSales')}}"> 
                                    All Sales Record
                                </a> --}}
                            </h2>
                            
                           
                        </div>
                        
                        <div class="body table-responsive">
                            <form id="form_filter" name = "form" method="GET" action="{{ url('/getFilterDateReturnSales') }}">
                                <div class="row clearfix">
                                
                                 {{ csrf_field() }}    
                             
                                    <div class="col-md-3" id="div_start_date">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">date_range</i>
                                            </span>
                                            <div class="form-line">
                                            <input type="text" id="start_date" name="start_date" class="form-control" placeholder="Start date (dd/mm/yyyy)" tabindex='1' required>
                                            </div>
                                        </div>
                
                                    </div>
                
                                    <div class="col-md-3" id="div_end_date">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">date_range</i>
                                                 
                                            </span>
                                            <div class="form-line">
                                            <input type="text" id="end_date" name="end_date" class="form-control" placeholder="End date (dd/mm/yyyy)" tabindex='2'  required >
                                           
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="div_end_date">
                                        <div class="input-group">
                                            
                                            <div class="form-line">
                                                
                                                <select  id="warehouse" name="warehouse" class="form-control show-tick" data-live-search="true" required>
                                                    <option value="" selected="selected" disabled="disabled">Select Branch</option>
                                                    @foreach ($warehouses as $warehouse)    
                                                        <option value="{{$warehouse->id}}" >{{$warehouse->warehouse_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="div_end_date">
                                        <div class="input-group">
                                            
                                            <div class="form-line">
                                                
                                                <select  id="biller" name="biller" class="form-control show-tick" data-live-search="true" >

                                                    <option value="" selected="selected">Select Biller</option>
                                                
                                                    <option value="19" >Pos Montessori</option>
                                                   
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                 
                                    <div class="col-md-8">
                                        <div class="form-group form-float">
                                                                            
                                            <button class="btn btn-primary waves-effect" type="submit">Search</button>
                                            
                                       </div>
                                    </div>
                                   
                                </div>
                            </form> 
                            <?php   $i=1;  ?>
                            <table class="table table-striped table-hover" id="product_table1">
                                <thead>
                                    <tr style="background: #f44336;color: #fff;">
                                       
                                        <th>Date</th>
                                        
                                        <th>Warehouse</th>

                                        <th>Biller</th>

                                        <th>Total </th>

                                        <th>Print</th>
                                    </tr>
                                </thead>
                                <tbody id="render">
                                @foreach($return_sales as $sale)
                                    <tr>
                                        
                                        <td>{{$sale->created_at}}</td>

                                        <td>{{$sale->warehouse_name}}</td>

                                        <td>{{$sale->empName}}</td>

                                        <td>{{$sale->totalAmount}}</td>

                                        <td><a href="#" class="printInvoice" data-id="{{$sale->id}}" ><i class="material-icons">print</i></a></td>
                                       {{--  <td> {{$product->id}}</td> --}}
                                    </tr>
                                @endforeach
                                
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan='2' ><b>Total</b></td>
                                        <td> <span style="float:right;"id ='totalAmount'></span> </td>
                                        
                                    </tr>
                              </tfoot>
                            </table>
                          {{--   {{ $productList->links() }} --}}
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        <!-- #END# Bordered Table -->
    </section>
    <form id="checkout" method="POST" action="" target="_blank" style="display:none;">
        <input type="hidden" id="obj" name="obj" value="">
                <div class="modal-header"  style="background: #563d7c;">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></button>
                    <h4   style="color: #FFF!important;"   id="decModalLabel">letterhead or Invoice </h4>
                </div>
                    <!-- <div class="modal-body">

                    </div> -->
                <div class="modal-footer">
                        <button  type="submit" class="btn" id="letterhead">Laser Print</button>
                            <!--<button class="btn btn-success" id="submit-sale">Submit</button>-->
                        <button  type="submit" id="invoice" class="btn btn-primary" accesskey="3" title="Shortcut: (alt+3)" >Thermal Print</button>
                </div>
    </form>
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
    <!-- Slimscroll Plugin Js -->
    <script src="{{asset('public/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>

    <!-- Wait Me Plugin Js -->
    <script src="{{asset('public/plugins/waitme/waitMe.js')}}"></script>

    <!-- Input Mask  Plugin Js -->
    <script src="{{asset('public/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
    
    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <script src="{{asset('public/js/pages/cards/colored.js')}}"></script>
    
    <!--Typeahead -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#start_date').inputmask({ mask: "99/99/9999"});
            $('#end_date').inputmask({ mask: "99/99/9999"});
            $('#product_table1').DataTable({
                "sPaginationType": "full_numbers",
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;	 
                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                          return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ?	i : 0;
                        };
                  
                     

                        total_amount = api.column( 3 ).data().reduce( function (a, b) {
                          return intVal(a) + intVal(b);
                        },0 );
                        
                      

                        total_page_amount = api.column( 3, { page: 'current'} ).data().reduce( function (a, b) {
                          return intVal(a) + intVal(b);
                        }, 0 );
                        
                    
                        total_page_amount=parseFloat(total_page_amount);

                       
                        total_amount = parseFloat(total_amount);
                        // Update footer
                  
                        $('#totalAmount').html(total_page_amount.toFixed(2)+" / <b>"+total_amount.toFixed(2)+"</b>");				
                      },		
            });

           
        });
        $(document).on('click','.printInvoice',function(e){
            /* e.preventDefault(); */
            var data = $(this).data('id');
            //alert(data);
            $.ajax({

            
            url:"{{ url('/printReturnInvoice')}}?id="+data,
            type: "GET",
            //data:data,


            }).done(function(data){

                $('#obj').val(JSON.stringify(data));
                $('#checkout').attr('action',"{{asset('public/invoice/returnInvoice.php')}}");
                //$('#inv'+id).remove();
                            
                $( "#invoice" ).trigger( "click" );
                            //newIndex= newIndex-1;
             

            });

        });

    
    </script>
@endsection