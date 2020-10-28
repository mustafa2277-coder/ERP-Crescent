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
@section("content")
<section class="content">
            <div class="body">
                    <ol class="breadcrumb breadcrumb-bg-red">
                        <li><a href="{{url('/home')}}">Home</a></li>
                        <li><a href="{{url('/transfernotes')}}">Transfer Notes</a></li>
                        <li><a href="{{ url('/transfernotesadd') }}">Add Transfer Notes</a></li>
                    </ol>
            </div>

            <div class="container-fluid">
                    <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                                <div class="card" style="height:auto;padding:15px;float:left;width:100%">
                                    <div class="header">
                                        <h2>Add Transfer Notes</h2>
                                    </div>

                                    <div class="body">
                                    
                                        <form action="{{-- url('/transfernotescreated') --}}" method="POST" name="transfernotesform" id="transfernotesform">
                                            {{ csrf_field() }}
                                            {{--  
                                            <div class="col-md-12" >
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label><i class="material-icons">search</i> Search</label>
                                                            <input type="text" class="typeahead form-control" placeholder="Search Products..." id="search" name="search">
                                                        </div>
                                                    </div>
                                            </div>
                                            --}}
                                            
                                            <div class="col-md-6">
                                                <label for="program_id">From Warehouse</label>
                                                <div class="form-group">    
                                                    <select type="text" name="from_warehouse_id" id="from_warehouse_id" class="form-control show-tick">
                                                        <option value="">Select Warehouse</option>
                                                            @foreach($inv_warehouse as $warehouse)
                                                                <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
                                                            @endforeach
                                                    </select>                                       
                                                </div>
                                            </div>

                                            
                                            <div class="col-md-6">
                                                <label class="form-label">To Warehouse</label>
                                                <div class="form-group">    
                                                    <select type="text" name="to_warehouse_id" id="to_warehouse_id" class="form-control show-tick">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach($inv_warehouse as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
                                                    @endforeach
                                                    </select>                                       
                                                </div>
                                            </div>
                                              
                                            
                                          {{--    <label class="form-label" id="from_warehouse_quantity_label" name="from_warehouse_quantity_label"></label> --}}

                                              
                                            <div class="col-md-6">
                                                <label class="entry_date">Entry Date</label>
                                                <div class="form-group"> 
                                                    <div class="form-line">
                                                        <input type="date" name="entry_date" id="entry_date" class="form-control" >                                        
                                                    </div> 
                                                </div>
                                            </div>
                                            
                                          {{--    <label class="form-label" name="to_warehouse_quantity_label" id="to_warehouse_quantity_label"></label> --}}
                                            <table id="example"  class="table  table-striped table-hover dataTable js-exportable">
                                                <thead>
                                                        <tr>
                                                            <th style="text-align:center">Product</th>
                                                            <th style='text-align:center'>To Warehouse Quantity</th>
                                                            <th style='text-align:center'>Action</th>
                                                            <th style='text-align:center'>
                                                                
                                                                <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#myModal" accesskey="a" style="float: left;"> 
                                                                    <i class="material-icons">add</i>
                                                                </a>
                                                            </th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                        {{-- <td colspan="5" >
                                                                <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#New-Entry-Modal" tabindex="5" accesskey="+" style="float: left;"> 
                                                                <i class="material-icons">add</i>
                                                            </a>    
                                                            
                                                            </td>  --}}
                                                            <!--    
                                                            <td colspan="6" >
                                                                <a class="btn btn-default waves-effect" data-toggle="modal" data-target="#myModal" accesskey="a" style="float: left;"> 
                                                                <i class="material-icons">add</i>
                                                            </a>    
                                                            
                                                            </td>
                                                            -->
                                                        </tr>
        
                                                </tbody>
                                            </table>
        
                                            <input type="submit" value="submit" name="submit" id="submit" class="btn btn-primary m-t-15 waves-effect">
                                        </form>

                                        <!-- Modal -->
                                        <div id="myModal" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
      
                                        <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Transfer Notes Details</h4>
                                                </div>
                                                <form id="myModalForm" name="myModalForm">    
                                                    <div class="modal-body">
                                                        <div class="col-md-12" >
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <label><i class="material-icons">search</i> Search</label>
                                                                    <input type="text" class="typeahead form-control" placeholder="Search Products..." id="search" name="search">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="searchproduct" id="searchproduct">


                                                        <div class="col-md-12">    
                                                            <div class="col-md-6">
                                                                <label class="form-label">From Warehouse Quantity</label>
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" name="from_warehouse_quantity" id="from_warehouse_quantity" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            
                                                            <input type="hidden" id="row" name="row">

                                                            <div class="col-md-6">
                                                                <label class="form-label">To Warehouse Quantity</label>
                                                                 <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" name="to_warehouse_quantity" id="to_warehouse_quantity" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                        
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" id="frontsubmit" name="frontsubmit" value="frontsubmit" >Submit</button>
                                                        <button type="button" class="btn btn-danger" id="close" name="close" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                        <!---MyModal End --->
                                        <!--MyModalEditStart --->
                                        
                                        <div id="myModalEdit" class="modal fade" role="dialog">
                                            <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Edit Transfer Notes Details</h4>
                                                </div>
                                            <form id="myModalFormEdit" name="myModalFormEdit">    
                                                <div class="modal-body">
                                                    <div class="col-md-12" >
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label><i class="material-icons">search</i> Search</label>
                                                                    <input type="text" class="typeahead form-control" placeholder="Search Products..." id="searchedit" name="searchedit" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <input type="hidden" name="searchproductedit" id="searchproductedit">


                                                <div class="col-md-12">    
                                                    <div class="col-md-6">
                                                        <label class="form-label">From Warehouse Quantity</label>
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" name="from_warehouse_quantity_edit" id="from_warehouse_quantity_edit" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    
                                                    <input type="hidden" id="row" name="row">
                
                                                    <div class="col-md-6">
                                                        <label class="form-label">To Warehouse Quantity</label>
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" name="to_warehouse_quantity_edit" id="to_warehouse_quantity_edit" class="form-control">
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>

                                                </div>
        
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary frontsubmit_edit"  name="frontsubmit_edit" value="frontsubmitedit" >Submit</button>
                                                    <button type="button" class="btn btn-danger close_edit"  name="close_edit" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
    
                    </div>
            </div>
    </div>
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

    
    <!-- Custom Js -->
    <script src="{{asset('public/js/admin.js')}}"></script>
    <script src="{{asset('public/js/transfer_notes_script.js')}}"></script>
    <script src="{{asset('public/js/pages/forms/basic-form-elements.js')}}"></script>
    
    <!--Typeahead -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 

    <!-- Demo Js -->
    <script src="{{asset('public/js/demo.js')}}"></script>
    <script src="{{asset('public/invScript.js')}}"></script>

    <script>
        
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



    </script>

    {{--   
   <script>
        $('#modal_product_quantity,#modal_product_price').change(function(){
            //alert('hello');
            total=$('#modal_product_quantity').val()*$('#modal_product_price').val();
            
            //alert(total);
            $('#modal_price_in_pkr').val(total);
            $('#modal_price_in_pkr').focus();
            $('#modal_purchased_currency').val('pkr');
            $('#modal_purchased_currency').focus();
            $('#modal_exchange_rate').val('0');
            $('#modal_exchange_rate').focus();
            $('#modal_product_price').focus();
            

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
                                        var aItem = { id: item.id, name: item.code+' '+item.name };
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
            //id=data.id;
            //alert(data);
            //console.log(data);
            $('.productId').val(data.id);
            $('.productName').val(data.name);
            //window.location.replace("{{url('/getSearchProductList')}}?id="+id);
        });

         $(".typeahead").on('keyup', function(e){

            if(e.which == 13) {
                
            //onsole.log($('.input-group > ul.dropdown-menu').css('display'));

            $('ul.typeahead li.active').on().trigger('click'); // for treiggering of click evetn of typhead for selec an item

            }

        });
        // $('ul.typeahead li').live("click", function() {
        //     var data = $('ul.typeahead li.active').data().value;
        //     //id=data.id;
        //     //console.log(data);
        //     $('.productId').val(data.id);
        //     $('.productName').val(data.name);
        //     //window.location.replace("{{url('/getSearchProductList')}}?id="+id);
        // });

        // $(".typeahead").on('keyup', function(e){

        //     if(e.which == 13) {
                
        //     //onsole.log($('.input-group > ul.dropdown-menu').css('display'));

        //     $('ul.typeahead li.active').live().trigger('click'); // for treiggering of click evetn of typhead for selec an item

        //     }

        // });
        
        // $('.form-line').keypress(function (e) {
        //     //alert(e.which);
        //     if (e.which == '13') {
        //         alert('hello');
        //         var data = $('ul.typeahead li.active').data();
        //         alert(data);
        //         //id=data.id;
        //         //console.log(data);
        //         $('.productId').val(data.id);
        //         $('.productName').val(data.name);
        //     }
        // });

    </script>
    --}}

    <script>
        var selectOpt = ""; 
        @if(isset($purchaseorders))
          var ndata=$('#rowTotal').val();
        @else
        var ndata=0;

        @endif

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

