$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
        });



$(document).ready(function() {

//alert("We are in Transfer Notes Script");
console.log("We are in Transfer Notes Script");

var localurl=window.location.protocol+"//"+ window.location.hostname + '/ERP1/';

var oldvalue=0;
var oldvalueedit=0;

$('.modal-content').on("click","ul.typeahead li",function (e) {
    e.preventDefault();
    var trigger=0;
    var data = $('ul.typeahead li.active').data().value;
    //alert(data.id);
     console.log(data.id);
    //alert("Inside");
    var value=data.id;
     $('#searchproduct').val(value);
     //alert("Inside click function: " + value);

        var searchproduct=$('#searchproduct').val();
        var from_warehouse_id=$('#from_warehouse_id').val();
       // alert(searchproduct + " Hello: " + from_warehouse_id);
        if(from_warehouse_id!='' && searchproduct!='')
         {
            //alert("Product: " + searchproduct + " from_warehouse_id: " + from_warehouse_id + " to_warehouse_id: " + to_warehouse_id);
        
            $.ajax({
                url: localurl + "gettransfernotescredentials",
                type: 'GET',
                data: { SearchProduct:searchproduct , Warehouse:from_warehouse_id  },
                dataType: 'json',
                success: function(response){
                    //alert(response);
                    $('#from_warehouse_quantity').val(response);
                    oldvalue=$('#from_warehouse_quantity').val();
                 //   alert("Old Value: " + oldvalue);
                }

            });
        }
        


});


/*
    $('#search').on('change',function()
    {
    
        var searchproduct=$('#searchproduct').val();
        var from_warehouse_id=$('#from_warehouse_id').val();
        alert(searchproduct + " Hello: " + from_warehouse_id);
        if(from_warehouse_id!='' && searchproduct!='')
         {
            //alert("Product: " + searchproduct + " from_warehouse_id: " + from_warehouse_id + " to_warehouse_id: " + to_warehouse_id);
        
            $.ajax({
                url: localurl + "gettransfernotescredentials",
                type: 'GET',
                data: { SearchProduct:searchproduct , Warehouse:from_warehouse_id  },
                dataType: 'json',
                success: function(response){
                    //alert(response);
                    $('#from_warehouse_quantity').val(response);
                    oldvalue=$('#from_warehouse_quantity').val();
                }

            });
        }
            

    });
*/

/*
$('#to_warehouse_id').on('change',function()
{
    var searchproduct=$('#searchproduct').val();
    var to_warehouse_id=$('#to_warehouse_id').val();

    if(to_warehouse_id!='' )
    {
        //alert("Product: " + searchproduct + " from_warehouse_id: " + from_warehouse_id + " to_warehouse_id: " + to_warehouse_id);
        
            $.ajax({
                url: localurl + "gettransfernotescredentials",
                type: 'GET',
                data: { SearchProduct:searchproduct , Warehouse:to_warehouse_id  },
                dataType: 'json',
                success: function(response){
                    //alert(response);
                    $('#to_warehouse_quantity').val(response);
                    /*
                    var to_warehouse_quantity=$('#to_warehouse_quantity').val();
                    
                   //alert(to_warehouse_quantity);
                   
                   var from_warehouse_quantity=$('#from_warehouse_quantity').val();
                    
                   //alert(to_warehouse_quantity + " " + from_warehouse_quantity);
                   var modify=from_warehouse_quantity - to_warehouse_quantity;
                    //alert(modify);

                   $('#from_warehouse_quantity').val(modify);
                    
                }

            });
    }
            

});
*/

$('#to_warehouse_quantity').on('change',function(){

    var to_warehouse_quantity=$('#to_warehouse_quantity').val();
                    
    //alert(to_warehouse_quantity);
    
    var from_warehouse_quantity=$('#from_warehouse_quantity').val();
    //alert(to_warehouse_quantity + " " + from_warehouse_quantity);
    var modify=oldvalue - to_warehouse_quantity;
     //alert(modify);

        $('#from_warehouse_quantity').val(modify);
    
    

});


$('#search').on('change',function(){

    var search=$('#search').val();

    if(search=='')
        {
            //$('#from_warehouse_id').val('').change();
            //$('#to_warehouse_id').val('').change();
            $('#from_warehouse_quantity').val('');
            $('#to_warehouse_quantity').val('');
        }

});

$('#close').on('click',function(){

    //$('#to_warehouse_id').val('').change();
    $('#from_warehouse_quantity').val('');
    $('#to_warehouse_quantity').val('');
    $('#search').val('');
    $('#searchproduct').val('');
});

var transfer_details=[];
var i=0;
$('#frontsubmit').on('click',function(){

    var from_warehouse_quantity=$('#from_warehouse_quantity').val();
    var to_warehouse_quantity=$('#to_warehouse_quantity').val();
    var searchproduct=$('#searchproduct').val();
    var from_warehouse_id=$('#from_warehouse_id').val();
    var to_warehouse_id=$('#to_warehouse_id').val();

    var warehouse='';
    var product='';
    if($("#myModalForm").validate().form())
    {
    $.ajax({
        url: localurl + "/transfer_credentials_append",
        type: 'GET',
        data: { SearchProduct:searchproduct , Warehouse:from_warehouse_id , WarehouseTo:to_warehouse_id },
        dataType: 'json',
        success: function(response){
        //    var value= JSON.parse(response);
        //     //alert('Product :' + response.product + "Warehouse: " + response.warehouse);
        //     alert(value);
        //     product=value.product;
        //     warehouse=value.warehouse;

                product=response.product;
                warehouse=response.warehouse;
                i++;        
                var tr='<tr class="' + i + '" style="text-align:center"><td style="text-align:center; display:none"   data-id=' + i + '>'  + '<td style="text-align:center" class="productname" >' + product +  '</td>' + '<td style="text-align:center; display:none" class="prodid">' + searchproduct + '</td><td style="text-align:center;display:none" class="from_warehouse_quantity_col">' + from_warehouse_quantity + '</td>'+ '<td style="text-align:center" class="to_warehouse_quantity_col">' + to_warehouse_quantity + '</td>' + '<td>' + '<a href="" class="myEdit" data-toggle="modal" data-target="#myModalEdit"><i class="material-icons">edit</i></a><button type="button"  class="btn btn-danger delete"><i class="material-icons">delete</i><span class="icon-name"></span></button>' + '</td></tr>';

                $('#example').append(tr);
            transfer_details.push({TransferSearchProduct:searchproduct , TransferFromWarehouseQuantity:from_warehouse_quantity , TransferToWarehouseQuantity:to_warehouse_quantity});            
            
        
        }

    });
    }
    //alert("Product:" + product + " warehouse: " + warehouse);

});


//This code for My Edit Modal. Start from here.

var current_edit_row_index=0;
$(document).on('click','.myEdit', function(){ 
    //alert("We are in dynamic button function!");
    var original= $(this);
    var prodname = $(this).closest('tr').find('.productname').text();
    var prodid=$(this).closest('tr').find('.prodid').text();
    var from_quantity=$(this).closest('tr').find('.from_warehouse_quantity_col').text();
    var to_quantity=$(this).closest('tr').find('.to_warehouse_quantity_col').text();
    var row_id=$(this).closest('tr').attr('class');
    //var rowid=$(this).data('tr').('id');
    //current_edit_row_index=rowid;
    //alert(row_id);

    var from_quantity=parseInt(from_quantity) + parseInt(to_quantity);
    oldvalueedit=from_quantity;
    //alert("Product Name: " + prodname + " Product Id: " + prodid + " From Quantity: " + from_quantity + " To Quantity: " +to_quantity);
    console.log("We are in myEdit function!");

    $('#searchedit').val(prodname);
    $('#searchproductedit').val(prodid);
    $('#from_warehouse_quantity_edit').val(from_quantity);
    $('#to_warehouse_quantity_edit').val(to_quantity);
    $('#row').val(row_id);
});


$('.close_edit').on('click',function(){

    //$('#to_warehouse_id').val('').change();
    $('#searchedit').val('');
    $('#searchproductedit').val('');
    $('#from_warehouse_quantity_edit').val('');
    $('#to_warehouse_quantity_edit').val('');
});


var j=0;
$('.frontsubmit_edit').on('click',function(){

    var from_warehouse_quantity=$('#from_warehouse_quantity_edit').val();
    var to_warehouse_quantity=$('#to_warehouse_quantity_edit').val();
    var searchproduct=$('#searchproductedit').val();
    var from_warehouse_id=$('#from_warehouse_id').val();
    var to_warehouse_id=$('#to_warehouse_id').val();
    var row_id=$('#row').val();
    var warehouse='';
    var product='';
    
    if($("#myModalFormEdit").validate().form())
    {
        
    $.ajax({
        url: localurl + "/transfer_credentials_append",
        type: 'GET',
        data: { SearchProduct:searchproduct , Warehouse:from_warehouse_id , WarehouseTo:to_warehouse_id },
        dataType: 'json',
        success: function(response){
        //    var value= JSON.parse(response);
        //     //alert('Product :' + response.product + "Warehouse: " + response.warehouse);
        //     alert(value);
        //     product=value.product;
        //     warehouse=value.warehouse;
                j++;        
                product=response.product;
                warehouse=response.warehouse;  
                var updatetr='<td style="text-align:center; display:none"  data-id=' + j + '>'  + 
                '<td style="text-align:center" class="productname" >' + product +  '</td>' + 
                '<td style="text-align:center; display:none" class="prodid">' + searchproduct + 
                '</td><td style="text-align:center;display:none" class="from_warehouse_quantity_col">' 
                + from_warehouse_quantity + '</td>'+ 
                '<td style="text-align:center" class="to_warehouse_quantity_col">' + 
                to_warehouse_quantity + '</td>' + '<td>' + 
                '<a href="" class="myEdit" data-toggle="modal" data-target="#myModalEdit"> <i class="material-icons">edit</i></a> <button type="button"  class="btn btn-danger delete"><i class="material-icons">delete</i><span class="icon-name"></span></button>' + 
                '</td>';
                //var updatetr='<tr style="text-align:center"><td style="text-align:center; display:none"  id='+ i + ' data-id=' + i + '>'  + '<td style="text-align:center" id="productname" >' + product +  '</td>' + '<td style="text-align:center; display:none" id="prodid">' + searchproduct + '</td><td style="text-align:center;display:none" id="from_warehouse_quantity_col">' + from_warehouse_quantity + '</td>'+ '<td style="text-align:center" id="to_warehouse_quantity_col">' + to_warehouse_quantity + '</td>' + '<td>' + '<a href="" id="myEdit" data-toggle="modal" data-target="#myModalEdit"><i class="material-icons">edit</i></a>' + '</td>';                
                
                //alert("Index :" + i + " To quantity" + to_warehouse_quantity);
                var index=row_id;
                index--;
                //alert("Index: " + index);
                for(var k=0; k<transfer_details.length; k++)
                    {
                                
                                if(k==index)
                                    {
                                        transfer_details[k].TransferSearchProduct=searchproduct;
                                        transfer_details[k].TransferFromWarehouseQuantity=from_warehouse_quantity;
                                        transfer_details[k].TransferToWarehouseQuantity=to_warehouse_quantity;
                                        //alert(transfer_details[k]);
                                    }
                    }
                
                var currentrow=$("." + row_id).closest('tr').html(updatetr);
                console.log(updatetr);
                
                //alert(currentrow.productname);
                console.log(currentrow);  
                //alert(currentrow);              
                //currentrow.replaceWith('23');
                /*
                $('#example').append(tr);
            transfer_details.push({TransferSearchProduct:searchproduct , TransferFromWarehouseQuantity:from_warehouse_quantity , TransferToWarehouseQuantity:to_warehouse_quantity});            
                */   
               
        }
        
    });
    
    
    }
    

});


$('#to_warehouse_quantity_edit').on('change',function(){

    var to_warehouse_quantity=$('#to_warehouse_quantity_edit').val();
                    
    //alert(to_warehouse_quantity);
    
    var from_warehouse_quantity=$('#from_warehouse_quantity_edit').val();
    //alert(to_warehouse_quantity + " " + from_warehouse_quantity);
    var modify=oldvalueedit - to_warehouse_quantity;
     //alert(modify);

        $('#from_warehouse_quantity_edit').val(modify);
    
    

});







//Code for My Edit Modal End Here.

//Code for Delete row.



$(document).on('click','.delete',function(){

    //alert("We are in delete function.");
    $(this).closest('tr').remove();
    var index=$(this).closest('tr').attr('class');
    index--;
    //alert(index);
    transfer_details.splice(index, 3);
    
});


$('#from_warehouse_id').on('change',function(){

    $('#example tbody').empty();
    transfer_details=[];
});


$('#to_warehouse_id').on('change',function(){

    $('#example tbody').empty();
    transfer_details=[];
});




/*
$.validator.addMethod("regex", function (value, element, regexp) {
    var check = false;
    return regexp.test(value);

}, "No zero and negative amount or any alphanumeric value and no decimal value. ");
*/

jQuery.validator.addMethod("notEqual", function (value, element, param) { // Adding rules for Amount(Not equal to zero)
    return this.optional(element) || value != '0';
});



$('#myModalForm').validate({

    rules:{
        'from_warehouse_quantity':{
            required:true,
            digits:true,
            notEqual: '0',
            
        },
        'to_warehouse_quantity':{
            required:true,
            digits:true,
            notEqual: '0',
        }
    },

    messages: {
        'from_warehouse_quantity':{
            notEqual: "Amount cannot be zero."
        },
        'to_warehouse_quantity': {
            notEqual: "Amount cannot be zero."
        },
    },

    highlight: function (input) {
        $(input).parents('.form-line').addClass('error');
    },
    unhighlight: function (input) {
        $(input).parents('.form-line').removeClass('error');
    },
    errorPlacement: function (error, element) {
        $(element).parents('.form-group').append(error);
    }
});


$('#myModalFormEdit').validate({

    rules:{
        'from_warehouse_quantity_edit':{
            required:true,
            digits:true,
            notEqual: '0',
            
        },
        'to_warehouse_quantity_edit':{
            required:true,
            digits:true,
            notEqual: '0',
        }
    },

    messages: {
        'from_warehouse_quantity_edit':{
            notEqual: "Amount cannot be zero."
        },
        'to_warehouse_quantity_edit': {
            notEqual: "Amount cannot be zero."
        },
    },

    highlight: function (input) {
        $(input).parents('.form-line').addClass('error');
    },
    unhighlight: function (input) {
        $(input).parents('.form-line').removeClass('error');
    },
    errorPlacement: function (error, element) {
        $(element).parents('.form-group').append(error);
    }
});







$('#transfernotesform').validate({

    rules:{
        'from_warehouse_id':{
            required:true,
            
        },
        'to_warehouse_id':{
            required:true,
        },
        'entry_date':{
            required:true,
        }
    },

    highlight: function (input) {
        $(input).parents('.form-line').addClass('error');
    },
    unhighlight: function (input) {
        $(input).parents('.form-line').removeClass('error');
    },
    errorPlacement: function (error, element) {
        $(element).parents('.form-group').append(error);
    }
});






$('#transfernotesform').on('submit',function(e){

    e.preventDefault();

    var from_warehouse_id=$('#from_warehouse_id').val();
    var to_warehouse_id=$('#to_warehouse_id').val();
    var entry_date=$('#entry_date').val();
    var i=0;
    /*
    alert('From Warehouse id: ' + from_warehouse_id + " To Warehouse id: " + to_warehouse_id + " Entry Date: " + entry_date);
    
    for(i=0; i<transfer_details.length; i++)
        {
            alert(i + "Product: " + transfer_details[i].TransferSearchProduct + " FromWarehouseQuantity: " + transfer_details[i].TransferFromWarehouseQuantity + " ToWarehouseQuantity: " + transfer_details[i].TransferToWarehouseQuantity);
        }
    */
   
if(transfer_details!='')
{
   $.ajax({
    url: localurl + "/transfernotescreated",
    type: 'POST',
    data: { FromWarehouse:from_warehouse_id , ToWarehouse:to_warehouse_id , EntryDate:entry_date , TransferDetails:transfer_details },
    dataType: 'json',
    success: function(response){
        alert("Success. Your transfer notes have been added!");
        
    }

});
}

else
{
    alert("Please Enter Transfer Details!!!");
}


});


});

