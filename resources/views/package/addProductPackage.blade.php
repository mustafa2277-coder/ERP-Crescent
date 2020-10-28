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

        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 115px;
        }
    </style>

    
@endsection

@section('content')
   
    @if(isset($packageProducts))
    
        <section class="content">

            

                <div class="body">
                        <ol class="breadcrumb breadcrumb-bg-red">
                            <li><a href="{{url('/home')}}">Home</a></li>
                            <li><a href="{{url('/packageList')}}">Product Package</a></li>
                            <li class="active"><a>Edit Product Package</a></li>
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
                                        Edit Product Package
                                    </h2>
                            
                                
                            </div>
                            <div class="body">
                                <form id="form_validation" name ="form" action="{{ url('/requestPurchase/print') }}" target="_blank" method="POST">
                                    {{ csrf_field() }}
                                <div class="row clearfix">
                                    
                                    <div class="col-sm-12" id="div_project">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select  id="package_id" name="package_id" class="form-control show-tick" data-live-search="true" tabindex="2"  required>
                                                    <option value="0" selected="selected" disabled="disabled">Select Package Name</option>
                                                    @foreach ($pkgs as $pkg)  
                                                    <option value="{{$pkg->id}}" {{ $packageProducts[0]->pkgId == $pkg->id ? "selected":"" }}>{{$pkg->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                          
                                </div>
                                <input type="hidden" class="form-control" id="rowTotal" name="rowTotal" value="{{sizeof($packageProducts)}}">
                                <input type="hidden" class="form-control" id="id" name="id" value="{{$packageProducts[0]->pkgId}}">
                                <input type="hidden" class="form-control" id="num" name="num" value="">
                                <!-- <div class="table-responsive"> -->
                                        <div class="col-sm-8" style="    margin-top: 24px;">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label><i class="material-icons">search</i> Search</label>
                                                        <input type="text" class="typeahead form-control" placeholder="Search Products...">
                                                    </div>
                                                </div>
                                                    
                                            </div>
                                    <table id="example"  class="table  table-striped table-hover dataTable js-exportable">
                                        <thead>
                                            <tr>
                                                <th style="">Product</th>
                                                <th style='text-align:center; width: 5%;'>Quantity</th>
                                                <th style='text-align:center; width: 5%;'>Unit_Price</th>
                                                <th style='text-align:center'>Product Type</th>
                                                <th style='text-align:center'>Boys Branch</th>
                                                <th style='text-align:center'>Girls Branch</th>
                                                <th style='text-align:center'>Iqbal Town Branch</th>
                                                <th style='text-align:center'>Johar Town Branch</th>
                        
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr>
                                            

                                                {{-- <td colspan="5" >
                                                    <a class="btn btn-default waves-effect" id ="appendRow" accesskey="a" style="float: left;"> 
                                                        <i class="material-icons">add</i>
                                                    </a>    
                                                
                                                </td> --}}
                                            
                                            </tr>
                                            @foreach($packageProducts as $i=>$packageProduct)
                                            <tr>
                                                <td><input type='text' data-id='{{$packageProduct->product_id}}' title='{{$packageProduct->product_name}}' id='product{{$i+1}}' name='product[{{$i+1}}]' class='form-control quantity' value='{{$packageProduct->product_name}}' readonly ></td>
                                                <td><input type='number' data-id='{{$i+1}}' name='quantity[{{$i+1}}]' id='quantity{{$i+1}}' class='form-control quantity' value='{{$packageProduct->qty}}' min='1' ></td>
                                                <td><input type='number' data-id='{{$i+1}}' name='unit[{{$i+1}}]' id='unit{{$i+1}}' class='form-control quantity' value='{{$packageProduct->unit}}' min='0' ></td>
                                                <td>
                                                    <select name='product_type[{{$i+1}}]' id='product_type[{{$i+1}}]'>

                                                        <option value="1" {{ $packageProduct->product_type == '1' ? "selected":"" }}>Book</option>
                                                        <option value="2" {{ $packageProduct->product_type == '2' ? "selected":"" }}>Copy</option>
                                                        <option value="3" {{ $packageProduct->product_type == '3' ? "selected":"" }}>Stationary</option>

                                                    </select>
                                                </td>
                                                @if(isset($qtyBoy[$i][0]->quantity_in_hand))
                                                    <td>{{$qtyBoy[$i][0]->quantity_in_hand}}</td>
                                                @else
                                                    <td>0</td>
                                                @endif
                                                @if(isset($qtyGirl[$i][0]->quantity_in_hand))
                                                    <td>{{$qtyGirl[$i][0]->quantity_in_hand}}</td>
                                                @else
                                                    <td>0</td>
                                                @endif
                                                @if(isset($qtyIqbal[$i][0]->quantity_in_hand))
                                                    <td>{{$qtyIqbal[$i][0]->quantity_in_hand}}</td>
                                                @else
                                                    <td>0</td>
                                                @endif
                                                @if(isset($qtyJohar[$i][0]->quantity_in_hand))
                                                    <td>{{$qtyJohar[$i][0]->quantity_in_hand}}</td>
                                                @else
                                                    <td>0</td>
                                                @endif
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
                            <li><a href="{{url('/packageList')}}">Product Package</a></li>
                            <li class="active"><a>New Product Package</a></li>
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
                                        New Product Package
                                    </h2>
                            
                                
                            </div>
                            <div class="body">
                                <form id="form_validation" name ="form" action="{{ url('/requestPurchase/print') }}" target="_blank" method="POST">
                                    {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-sm-12" id="div_project">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select  id="package_id" name="package_id" class="form-control show-tick" data-live-search="true" tabindex="2"  required>
                                                    <option value="0" selected="selected" disabled="disabled">Select Package Name</option>
                                                    @foreach ($pkgs as $pkg)    
                                                    <option value="{{$pkg->id}}">{{$pkg->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                
                                <input type="hidden" class="form-control" id="rowTotal" name="rowTotal">
                                <input type="hidden" class="form-control" id="id" name="id" value="">
                                <input type="hidden" class="form-control" id="num" name="num" value="">
                                <!-- <div class="table-responsive"> -->
                                        <div class="col-sm-12" style="    margin-top: 24px;">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label><i class="material-icons">search</i> Search</label>
                                                        <input type="text" class="typeahead form-control" placeholder="Search Products...">
                                                    </div>
                                                </div>
                                                    
                                            </div>
                                  
                                        <table id="example"  class="table  table-striped table-hover dataTable js-exportable">
                                            <thead>
                                                <tr>
                                                    <th style="">Product</th>
                                                    <th style='text-align:center; width: 5%;  '>Quantity</th>
                                                    <th style='text-align:center; width: 5%;'>Unit_Price</th>
                                                    <th style='text-align:center'>Product Type</th>
                                                    <th style='text-align:center'>Boys Branch</th>
                                                    <th style='text-align:center'>Girls Branch</th>
                                                    <th style='text-align:center'>Iqbal Town Branch</th>
                                                    <th style='text-align:center'>Johar Town Branch</th>
                            
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <tr>

                                                
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

     <!--Typeahead -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 
    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>

    {{--  <script src="{{asset('public/myscript.js')}}"></script>  --}}
    <script src="{{asset('public/package.js')}}"></script>
  
    <script type="text/javascript">
        var selectOpt = ""; 
        @if(isset($purchaseorders))
          var ndata=$('#rowTotal').val();
        @else
        var ndata=0;

        @endif

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

                                // console.log(resultList);

                                return process(resultList);

                            }
                        });
                    }

        });
        $('.form-line').on("click","ul.typeahead li", function() {
            var data = $('ul.typeahead li.active').data().value;
            id=data.id;
            name=data.name;
            $('.typeahead').val('')
            //$(this).data('id', id);
            var table = $("table tbody");
            var i = $('#example tbody tr').length;
            rdata=$('#rowTotal').val();
           
            if(i>1){
                var product=$("#product"+rdata).val();
                var quantity=$("#quantity"+rdata).val();
                
                if(quantity=="0"||quantity==""){
                    swal("PLease Enter the values Properly");
                   
                    return false;
                }
               
            }

            ndata++;

            $.ajax({
                url: "{{ url('/getWarehouseProduct')}}",
                type: "GET",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                data: {id:id},
                //crossDomain: true,
                dataType: "json",
            
                success: function(data) {
                    console.log(data);
                    // console.log(data[3].quantity_in_hand);
                    boy=0;
                    girl=0;
                    iqbal=0;
                    johar=0;

                    if(data[0][0]){
                        boy=data[0][0].quantity_in_hand;
                    }
                    if(data[1][0]){
                        girl=data[1][0].quantity_in_hand;
                    }
                    if(data[2][0]){
                        iqbal=data[2][0].quantity_in_hand;
                    }
                    if(data[3][0]){
                        johar=data[3][0].quantity_in_hand;
                    }

                    row = "<tr><td> <input type='text' id='product"+ndata+"' name='product["+ndata+"]' title='"+name+"' data-id='"+id+"'class='form-control' value='"+name+"' readonly></td><td><input type='number' data-id='"+ndata+"' name='quantity["+ndata+"]' id='quantity"+ndata+"' class='form-control quantity' value='1'  min='1' ></td><td><input type='number' data-id='"+ndata+"' name='unit["+ndata+"]' id='unit"+ndata+"' class='form-control quantity' value='0'  min='0' ></td><td><select id='product_type"+ndata+"' name='product_type["+ndata+"]' ata-id='"+ndata+"' class='form-control' ><option value='1'>Book</option><option value='2'>Copy</option><option value='3'>Stationary</option></select></td><td>"+boy+"</td><td>"+girl+"</td><td>"+iqbal+"</td><td>"+johar+"</td><td style='text-align:center'><a id='icon-toggle-delete2' class='removebutton'>  <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a></td></tr>";
                                $('#example tbody').append(row);

                                $('#rowTotal').val(ndata);
                }
            });

            
        });

        
       

        
        $(document).on('click', '#icon-toggle-delete2', function () {
    
            $(this).closest('tr').remove();
            row=$('#rowCount').val()-1;
            $('#rowCount').val(row);
            console.log($(this).closest('tr').attr('id'));
           
            //calculate2();
             return false;
         });
         dataID=$('#rowTotal').val();
         
        
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
                   

                }
            });
            $('#total').closest('tr').remove();
            var tbody = $("#example tfoot");
            var row = "<tr id='total'><th colspan='4' style='text-align:center'>Total</th><th style='text-align:center' id='total'>" + total +"</th></tr><input type='hidden' name='total' class='form-control ' value='" +  total  +"' >";
             tbody.append(row);
            
        }

         
        
    </script>
@endsection