@extends('layouts.app')

@section('css')



    <!-- Bootstrap Core Css -->
    <link href="{{asset('public/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet" />

    <!-- Waves Effect Css -->
    <link href="{{asset('public/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('public/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="{{asset('public/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />

     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{asset('public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="{{asset('public/plugins/waitme/waitMe.css')}}" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="{{asset('public/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />


    <!-- Custom Css -->
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('public/css/themes/all-themes.css')}}" rel="stylesheet" />

    <style>
        .download{
            display:none;
        }
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>

    
@endsection

@section('content')
   
    @if(isset($purchaseorders))
    
        <section class="content">

            

                <div class="body">
                        <ol class="breadcrumb breadcrumb-bg-red">
                            <li><a href="{{url('/home')}}">Home</a></li>
                            <li><a href="{{url('/getPurchaseOrders')}}">Purchase Orders</a></li>
                            <li class="active"><a>Edit Purchase Order</a></li>
                        </ol>
                </div>
        

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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                        <div class="card">
                                <div class="header">
                            
                                    <h2>
                                    Edit Purchase Order
                                    </h2>
                            
                                
                            </div>
                            <div class="body">
                                <form id="form_validation" name ="form" action="{{ url('/purchase/print') }}" target="_blank" method="POST">
                                    {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                            <select  id="vendor_id" name="vendor_id" class="form-control show-tick" data-live-search="true"  tabindex="1" required>
                                                    <option value="0" selected="selected" disabled="disabled"><strong>Select Vendor</strong></option>
                                                    @foreach ($vendors as $vendor)    
                                                    <option value="{{$vendor->id}}" {{ $purchaseorders[0]->vendorId == $vendor->id ? "selected":"" }}>{{$vendor->name}}</option>
                                                    @endforeach
                                            </select>
                                    </div>
                                    <div class="col-sm-6" id="div_project">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                        <select  id="project_id" name="project_id" class="form-control show-tick" data-live-search="true" tabindex="2"  required>
                                            <option value="0" selected="selected" disabled="disabled">Select Project</option>
                                            @foreach ($projects as $project)    
                                            <option value="{{$project->id}}" {{ $purchaseorders[0]->projectId == $project->id ? "selected":"" }}>{{$project->title}}</option>
                                            @endforeach
                                        </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text"  name="pdate" id="pdate" tabindex="3" class="form-control date" value="{{date("d-m-Y",strtotime($purchaseorders[0]->poDate))}}">
                                                    <label class="form-label">Date (dd/mm/yyyy)</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text"  name="rdate" id="rdate" tabindex="3" class="form-control date" value="{{date("d-m-Y",strtotime($purchaseorders[0]->requiredDate))}}">
                                                    <label class="form-label">REQUIRED DATE (dd/mm/yyyy)</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" id="description" tabindex="4" name="description" value="{{$purchaseorders[0]->description}}" required>
                                                    <label class="form-label">Description</label>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-sm-12">  
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="checkbox" id="isRFQ" name="isRFQ" {{ $purchaseorders[0]->isRFQ == "on" ? "checked":"" }} >
                                                    <label for="isRFQ">Is RFQ</label>
                                                </div>
                                            </div>
                                        </div>
                                          
                                </div>
                                <input type="hidden" class="form-control" id="rowTotal" name="rowTotal" value="{{sizeof($purchaseorders)}}">
                                <input type="hidden" class="form-control" id="id" name="id" value="{{$purchaseorders[0]->poId}}">
                                <input type="hidden" class="form-control" id="num" name="num" value="">
                                <!-- <div class="table-responsive"> -->

                                    <table id="example"  class="table  table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th style='text-align:center'>Product Quantity</th>
                                                <th style='text-align:center'>Unit Price</th>
                                                <th style='text-align:center'>Tax %</th>
                                                <th style='text-align:center'>Sub Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr id="total">
                                                <th colspan="2" style="text-align:center">Total</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                        
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                            

                                                <td colspan="5" >
                                                    <a class="btn btn-default waves-effect" id ="appendRow" accesskey="a" style="float: left;"> 
                                                    <i class="material-icons">add</i>
                                                </a>    
                                                
                                                </td>
                                            
                                            </tr>
                                            @foreach($purchaseorders as $i=>$purchaseorder)
                                            <tr>
                                                <td>
                                                    <select id='product{{$i+1}}' name='product[{{$i+1}}]' class='form-control'   required>
                                                            @foreach ($products as $product)    
                                                                <option value="{{$product->id}}" {{ $purchaseorder->productId == $product->id ? "selected":"" }}>{{$product->name}}</option>
                                                            @endforeach       
                                                    </select> 
                                                </td>
                                                <td><input type='number' data-id='{{$i+1}}' name='quantity[{{$i+1}}]' id='quantity{{$i+1}}' class='form-control quantity' value='{{$purchaseorder->productQuantity}}' ></td>
                                                <td><input type='number' data-id='{{$i+1}}' name='unit[{{$i+1}}]' id='unit{{$i+1}}' class='form-control unit' value='{{$purchaseorder->unitPrice}}' ></td>
                                                <td><input type='number' data-id='{{$i+1}}' name='tax[{{$i+1}}]' id='tax{{$i+1}}' class='form-control tax' value='{{$purchaseorder->tax}}' ></td>
                                                <td><input type='number' data-id='{{$i+1}}' name='sub[{{$i+1}}]' id='sub{{$i+1}}' class='form-control sub' value='{{$purchaseorder->subTotal}}' readonly ></td>
                                                <td style='text-align:center'><a id='icon-toggle-delete2' class='removebutton'>  <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a></td>
                                            </tr>
                                                
                                            @endforeach
                                        
                                        </tbody>
                                    </table>
                                            <center><b id="msg" style="color:red; font-size:16px;"></b></center>
                                <!-- </div> -->
                                <button class="btn btn-primary waves-effect" id="submit" accesskey="s">SUBMIT</button>
                                <button class="btn btn-primary waves-effect download" type="submit"  id="download" >Print</button>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Exportable Table -->
            </div>
        </section>
    @else
        <section class="content">

        

                <div class="body">
                        <ol class="breadcrumb breadcrumb-bg-red">
                            <li><a href="{{url('/home')}}">Home</a></li>
                            <li><a href="{{url('/getPurchaseOrders')}}">Purchase Orders</a></li>
                            <li class="active"><a>New Purchase Order</a></li>
                        </ol>
                </div>
        

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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                        <div class="card">
                                <div class="header">
                            
                                    <h2>
                                    New Purchase Order
                                    </h2>
                            
                                
                            </div>
                            <div class="body">
                                <form id="form_validation" name ="form" action="{{ url('/purchase/print') }}" target="_blank" method="POST">
                                    {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <select  id="vendor_id" name="vendor_id" class="form-control show-tick" data-live-search="true"  tabindex="1" required>
                                            <option value="0" selected="selected" disabled="disabled"><strong>Select Vendor</strong></option>
                                            @foreach ($vendors as $vendor)    
                                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6" id="div_project">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                        <select  id="project_id" name="project_id" class="form-control show-tick" data-live-search="true" tabindex="2"  required>
                                            <option value="0" selected="selected" disabled="disabled">Select Project</option>
                                            @foreach ($projects as $project)    
                                            <option value="{{$project->id}}">{{$project->title}}</option>
                                            @endforeach
                                        </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                <input type="text"  name="pdate" id="pdate" tabindex="3" class="form-control date" >
                                                <label class="form-label">ORDER DATE (dd/mm/yyyy)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text"  name="rdate" id="rdate" tabindex="3" class="form-control date" >
                                                    <label class="form-label">REQUIRED DATE (dd/mm/yyyy)</label>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="description" tabindex="4" name="description" required>
                                                <label class="form-label">Description</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">  
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="checkbox" id="isRFQ" name="isRFQ"  >
                                                <label for="isRFQ">Is RFQ</label>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                
                                <input type="hidden" class="form-control" id="rowTotal" name="rowTotal">
                                <input type="hidden" class="form-control" id="id" name="id" value="">
                                <input type="hidden" class="form-control" id="num" name="num" value="">
                                <!-- <div class="table-responsive"> -->

                                    <table id="example"  class="table  table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th style='text-align:center'>Product Quantity</th>
                                                <th style='text-align:center'>Unit Price</th>
                                                <th style='text-align:center'>Tax %</th>
                                                <th style='text-align:center'>Sub Total</th>
                        
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr id="total">
                                                <th colspan="2" style="text-align:center">Total</th>
                                            <th></th>
                                            <th></th>
                                                <th></th>
                                                
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                            {{-- <td colspan="5" >
                                                    <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#New-Entry-Modal" tabindex="5" accesskey="+" style="float: left;"> 
                                                    <i class="material-icons">add</i>
                                                </a>    
                                                
                                                </td>  --}}

                                                <td colspan="6" >
                                                    <a class="btn btn-default waves-effect" id ="appendRow" accesskey="a" style="float: left;"> 
                                                    <i class="material-icons">add</i>
                                                </a>    
                                                
                                                </td>
                                            
                                            </tr>
                                        
                                        </tbody>
                                    </table>
                                            <center><b id="msg" style="color:red; font-size:16px;"></b></center>
                                <!-- </div> -->
                                <button class="btn btn-primary waves-effect" id="submit" accesskey="s">SUBMIT</button>
                                <button class="btn btn-primary waves-effect download" type="submit"  id="download" >Print</button>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Exportable Table -->
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

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('public/plugins/node-waves/waves.js')}}"></script>

    <!-- SweetAlert Plugin Js -->
    <script src="{{asset('public/plugins/sweetalert/sweetalert.min.js')}}" ></script>

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
<!--     <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script> -->
    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

    {{--  <script src="{{asset('public/myscript.js')}}"></script>  --}}
    <script src="{{asset('public/purchase.js')}}"></script>
  
    <script type="text/javascript">
        var selectOpt = ""; 
        @if(isset($purchaseorders))
          var ndata=$('#rowTotal').val();
        @else
        var ndata=0;

        @endif

        $(document).ready(function() {
               $('.date').inputmask({ mask: "99/99/9999"});
                 
                @foreach ($products as $product)    
                selectOpt += "<option value='{{$product->id}}'>{{$product->name}}</option>";
                @endforeach
                calculate2();
            
                
       });

        
        $('#appendRow').on('click', function () {
            var table = $("table tbody");
            var i = $('#example tbody tr').length;
            rdata=$('#rowTotal').val();
           /* prod=[];
            //console.log(rowCount);
            table.find('tr').each(function (i) {
                if(i>0){
                  
                    var $tds = $(this).find('td');
                    selection = $tds.eq(0).find("select").val();
                    //alert(selection);
                    prod[i-1]=selection;
        
                    
                }
            });
            console.log(prod);
            size=prod.lenght;
            for(chk=0;chk<size;chk++){
                if(prod[chk]==$("#product"+rdata).val()){
                    swal("Last entered value already exists");
                   
                    return false;
                }
            }*/
            if(i>1){
                var product=$("#product"+rdata).val();
                var quantity=$("#quantity"+rdata).val();
                var unit=$("#unit"+rdata).val();
                var tax=$("#tax"+rdata).val();
                var sub=$("#sub"+rdata).val();
                //alert(debit);
                //alert(credit);
                if(quantity=="0"||quantity==""||unit=="0"||unit==""||tax==""||sub=="0"||sub==""){
                    swal("PLease Enter the values Properly");
                   
                    return false;
                }
               
            }

            ndata++;
         
         


        row = "<tr><td> <select  id='product"+ndata+"' name='product["+ndata+"]' class='form-control show-tick' data-live-search='true'  required>"
                                   +selectOpt+
                                    "</select></td><td><input type='number' data-id='"+ndata+"' name='quantity["+ndata+"]' id='quantity"+ndata+"' class='form-control quantity' value='0' ></td><td style='text-align:center'><input type='number' data-id='"+ndata+"' name='unit["+ndata+"]' id='unit"+ndata+"' class='form-control unit' value='0' ></td><td style='text-align:center'><input type='number'  data-id='"+ndata+"' name='tax["+ndata+"]' id='tax"+ndata+"' class='form-control tax' value='0'></td><td style='text-align:center'><input type='number'  data-id='"+ndata+"' name='sub["+ndata+"]' id='sub"+ndata+"' class='form-control sub' value='0' readonly></td><td style='text-align:center'><a id='icon-toggle-delete2' class='removebutton'>  <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a></td></tr>";
                            $('#example tbody').append(row);

                            $('#rowTotal').val(ndata);
        });

        /*$( ".key" ).keypress(function() {
            var entry=$('#rowTotal').val();
            if ( event.which == 13 ) {
                event.preventDefault();
                
             }
          });*/
          $(document).on('click', '#icon-toggle-delete2', function () {
    
            $(this).closest('tr').remove();
            row=$('#rowCount').val()-1;
            $('#rowCount').val(row);
            console.log($(this).closest('tr').attr('id'));
           
            calculate2();
             return false;
         });
         dataID=$('#rowTotal').val();
         //selector='#tax,';
         //$('#rowTotal').val();
        $('body').on('change','.quantity,.quantity,.unit,.tax',function(event){
            var rdata=$(this).attr('data-id');
            var quantity=$("#quantity"+rdata).val();
            var unit=$("#unit"+rdata).val();
            var taxPrecent=$("#tax"+rdata).val();
            var sub=0
            taxRate=0;
            tax=(taxPrecent/100);
            //alert(tax);
            if(tax>0){
                taxRate=tax;
                netPrice=quantity*unit;
                sub=netPrice*taxRate;
                sub=sub+netPrice;
            }
            else{
                netPrice=quantity*unit;
                sub=netPrice;
            }
               
            $("#sub"+rdata).val(sub);
            
            var i = $('#example tbody tr').length;
            calculate2(); 
            //alert('calculating');
        });
        
        function calculate2(){

           
            var total=0;
            var sub=0;
            var table = $("table tbody");
            var rowCount = $('#example tbody tr').length;
            //console.log(rowCount);
            table.find('tr').each(function (i) {
                if(i>0){
                    
                   var $tds = $(this).find('td');
                   
                   var quantity=$tds.eq(1).find("input").val();
                   //alert(quantity);
                   var unit=$tds.eq(2).find("input").val();
                   //alert(unit);
                   var taxPrecent=$tds.eq(3).find("input").val();
                   taxRate=0;
                   tax=(taxPrecent/100);
                   //alert(tax);
                   if(tax>0){
                    taxRate=tax;
                    netPrice=quantity*unit;
                    sub=netPrice*taxRate;
                    sub=sub+netPrice;
                   }else{
                    netPrice=quantity*unit;
                    sub=netPrice;
                   }
                   total=total+sub;
                   //alert(sub);
                   //$tds.eq(4).find("input").val(sub);
                   //var sub=$("#sub"+rdata).val();
                    // = $tds.eq(2).find("input").val();
                    
                   // debitAmt = parseFloat(debit) + debitAmt;

                   // credit = $tds.eq(3).find("input").val();
                  //  creditAmt = parseFloat(credit) + creditAmt;

                }
            });
            $('#total').closest('tr').remove();
            var tbody = $("#example tfoot");
            var row = "<tr id='total'><th colspan='4' style='text-align:center'>Total</th><th style='text-align:center' id='total'>" + total +"</th></tr><input type='hidden' name='total' class='form-control ' value='" +  total  +"' >";
             tbody.append(row);
            //debitTotal=$('#debitAmt').text();
            //creditTotal=$('#creditAmt').text();
            

        }

         
        
       </script>
@endsection