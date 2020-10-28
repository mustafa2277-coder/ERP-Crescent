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
                        <li><a href="{{url('/customer_list')}}">Customer List</a></li>
                        <li class="active"><a>Customer Detail</a></li>
                    </ol>
            </div>
            
        <!-- Bordered Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 30px;">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Customer Sale Details 
                                {{-- <a href="javascript:void(0);" class="js-search" data-close="true" title="Search"><i class="material-icons">search</i></a> --}}
                                {{-- <a class="btn bg-light-green waves-effect" style="    margin-left: 2%;" id="add_new" href="{{ url('/getTodaySales')}}"> 
                                    Today's Sale Record
                                </a> --}}
                               {{--  <a class="btn btn-danger btn-circle waves-effect waves-circle waves-float" style="margin-bottom: 14px;float:right;" target='_blank' id="add_new" href="http://crescent.cherryberry.website/import_product/"> 
                                    <i class="material-icons" title="import">import_export</i>
                                </a> --}}
                                {{-- <a class="btn bg-indigo waves-effect" style="    margin-left: 2%;" id="add_new" href="{{ url('/getAllSales')}}"> 
                                    All Sales Record
                                </a> --}}
                            </h2>
                            
                           
                        </div>
                        
                        <div class="body table-responsive">
                            
                            <?php   $i=1;  ?>
                            <table class="table table-striped table-hover" id="product_table">
                                <thead>
                                    <tr style="background: #f44336;color: #fff;">
                                       
                                        <th>Date</th>
                                       
                                        <th>Customer</th>
                                        <th>Mobile No.</th>
                                        <th>Total </th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Invoice No.</th>
                                        <th>Payment Method</th>
                                        <th>Warehouse</th>
                                        <th>Biller</th>
                                        <th>Print</th>
                                    </tr>
                                </thead>
                                <tbody id="render">
                                @foreach($sales as $sale)
                                    <tr>
                                        
                                        <td>{{date('Y-m-d',strtotime($sale->created_at))}}</td>
                                        
                                        <td>{{$sale->firstName}} {{$sale->lastName}}</td>
                                        <td>{{$sale->contactNo}}</td>
                                        <td>{{$sale->totalPrice}}</td>
                                        <td>{{$sale->paid}}</td>
                                        <td>{{$sale->chnge}}</td>
                                        <td>{{$sale->id}}</td>
                                        <td>{{$sale->paymentMethod}}</td>
                                        <td>{{$sale->warehouse_name}}</td>
                                        <td>{{$sale->empName}}</td>
                                        <td>
                                            <a href="#" class="printInvoice" data-id="{{$sale->id}}" ><i class="material-icons">print</i></a>
                                            <a href="{{ url('/printA4')}}/{{$sale->id}}" class="printA4" data-id="{{$sale->id}}" title="A4 Print" target="_blank" ><i class="material-icons">insert_drive_file</i></a>
    
                                        </td>
                                       {{--  <td> {{$product->id}}</td> --}}
                                    </tr>
                                @endforeach
                               
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan='3' ><b>Total</b></td>
                                        <td colspan='3'> <span style="float:right;"id ='totalAmount'></span> </td>
                                        
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
            $('#product_table').DataTable({
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

            
            url:"{{ url('/printInvoice')}}?id="+data,
            type: "GET",
            //data:data,


            }).done(function(data){

                $('#obj').val(JSON.stringify(data));
                $('#checkout').attr('action',"{{asset('public/invoice/invoice.php')}}");
                //$('#inv'+id).remove();
                            
                $( "#invoice" ).trigger( "click" );
                            //newIndex= newIndex-1;
             

            });

        });

    
    </script>
@endsection