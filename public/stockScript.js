$('#stock_date_edit').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
$('#stock_date').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});



$('select[name="stock_warehouse"]').change(function(){
        $.ajax({
        url: "http://localhost/ERP/getStockDetail?id="+$(this).val(),
        type: "GET",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        
        success: function(data) {
            if(data==1){
                    var tbody = $("#exampleStock tbody");
                    tbody.empty();
                }
            else {
                console.log(data);
                
                var rows = "";
                for (var i = 0; i < data.length; i++) {

                    rows += "<tr id="+data[i].id+"><td style='display:none'><input type='hidden' value="+data[i].product_id+" name='productId'></td><td class='col-sm-3' style='text-align:center'>" +data[i].pName + "</td><td class='col-sm-3' style='text-align:center'>" + data[i].quantity_in_hand + '</td><td class="col-sm-3" style="text-align:center"><input type="text" name="fname" class="form-control"></td><td class="col-sm-3" style="text-align:center"><input type="text" name="fname" class="form-control"></td></tr>' ;
                };
                var tbody = $("#exampleStock tbody");
                tbody.empty();
                tbody.prepend(rows);
                }
                
        }

    }); 
            
});
var tableDataStock = [];

// $(document).on('click', '#icon-toggle-deleteStockRow', function () {
//         //alert("here");
//         $(this).closest('tr').remove();

//         console.log($(this).closest('tr').attr('id'));
//         ii =  $.each(tableDataStock,function(e){

//         return e.tableindex == $(this).attr('id'); 

//         });
       
//         tableDataStock.splice(ii,1);
//          return false;
//      });


// function addStockDetail(){
// 	if($('#stock_product_id').find(":selected").val() == 0) {

//         swal("Product is not selected!");
       
//         //$('#New-Entry-Modal').modal('hide');
//         return false;
//     }
//     if($('#quantity_InStock').val() =="" ) {

//         swal("Product Quantity Field is Required!");
//         return false;

//     }
//     if($('#actual_quantity').val() =="" ) {

//         swal("Product Quantity Field is Required!");
//         return false;

//     }
//     if($('#reasonOf_difference').val() =="" ) {

//         swal("Product Quantity Field is Required!");
//         return false;

//     }
    


//     var rows = "";
//     rowindexstock=1+rowindexstock;
//     var productName=$('#stock_product_id option:selected').text();
//     var quantityInStock = $('#quantity_InStock').val();
//     var actualQuantity = $('#actual_quantity').val();
//     var reasonOfDifference = $('#reasonOf_difference').val();

//     rows += "<tr id="+rowindexstock+"><td>" + productName + "</td><td>" + quantityInStock + "</td><td>" + actualQuantity + "</td><td>" + reasonOfDifference + '</td><td style="text-align:center"><a id="icon-toggle-deleteStockRow" class="removebutton">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td></tr>' ;

//     var tbody = $("#exampleStock tbody");
//     tbody.prepend(rows);
     
//     tableDataStock.push({
//         tableindex : rowindexstock,    
//         productName : $('#stock_product_id option:selected').val() ,
//         quantityInStock: quantityInStock,
//         actualQuantity: actualQuantity,
//         reasonOfDifference: reasonOfDifference,
         
//     });
// 	 $('#stockModal').modal('hide');
// 	 $('#StockPopupForm')[0].reset(); 


// }



function addStock(){

    if($('#stock_warehouse').find(":selected").val() == 0) {
        swal("Please select warehouse!");
       
        return false;
    }
    if($('#stock_date').val() == "") {
        swal("Please select Date!");
       
        return false;
    }

    var table = $("#exampleStock tbody");
    table.find('tr').each(function (i, el) {
        var $tds = $(this).find('td');
        var values = $tds.find(":input").map(function() {
            return $(this).val()
           }).get()

        tableDataStock.push({
            productId:values[0],
            productName : $tds.eq(1).text(),
            quantityInStock: $tds.eq(2).text(),
            actualQuantity: values[1],
            reasonOfDifference: values[2], 
        });
            
    });
    // console.log(tableDataStock);
    var submitEntry = {};
    submitEntry.stockDetail = tableDataStock;
    submitEntry.warehouse =  $('#stock_warehouse').find(":selected").val();
    submitEntry.stock_date=  $('#stock_date').val();

    //console.log(tableData);
   
        $.ajax({
        url: "http://localhost/ERP/insertStock",
        type: "POST",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        data: submitEntry,
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            if (data.success=="inserted") {
                tableDataStock = []; 
                window.location = "http://localhost/ERP/stock";
            }
            
        }

    });    
}





// function addStockDetailEditTime(){
//     if($('#modal_stock_product_id').find(":selected").val() == 0) {

//         swal("Product is not selected!");
       
//         //$('#New-Entry-Modal').modal('hide');
//         return false;
//     }
//     if($('#modal_quantity_in_stock').val() =="" ) {

//         swal("Product Quantity Field is Required!");
//         return false;

//     }
//     if($('#modal_actual_quantity').val() =="" ) {

//         swal("Product Quantity Field is Required!");
//         return false;

//     }
//     if($('#modal_reason_of_diff').val() =="" ) {

//         swal("Product Quantity Field is Required!");
//         return false;

//     }
    


//     var rows = "";
//     rowindexstock=1+rowindexstock;
//     var productName=$('#modal_stock_product_id option:selected').text();
//     var modalQuantityInStock = $('#modal_quantity_in_stock').val();
//     var modalActualQuantity = $('#modal_actual_quantity').val();
//     var modalReasonOfDiff = $('#modal_reason_of_diff').val();

//     rows += "<tr id="+rowindexstock+"><td>" + productName + "</td><td>" + modalQuantityInStock + "</td><td>" + modalActualQuantity + "</td><td>" + modalReasonOfDiff + '</td><td style="text-align:center"><a id="icon-toggle-deleteStockRow" class="removebutton">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td></tr>' ;

//     var tbody = $("#exampleStockEdit tbody");
//     tbody.prepend(rows);
     
//     tableDataStock.push({
//         tableindex : rowindexstock,    
//         productName : $('#modal_stock_product_id option:selected').val() ,
//         QuantityInStock: modalQuantityInStock,
//         ActualQuantity: modalActualQuantity,
//         ReasonOfDifference: modalReasonOfDiff,
         
//     });
//      $('#stockModal').modal('hide');
//      $('#stockPopupForm')[0].reset(); 


// }



// function editStockDetail(id){
//     //alert (id);
//     $.ajax({
//         url: "http://localhost/ERP/editStockDetail?id="+id,
//         type: "GET",
//         headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     },
//         // data: id,
//         //crossDomain: true,
//         // dataType: "json",
           
//         success: function(data) {
//             if (data) {
//                 console.log(data);
//                 $('#stock_product_id_edit  option[value="'+data.product_id+'"]').attr("selected", "selected");
//                 $("#stock_product_id_edit").val(data.product_id).change();
//                 $("#modal_quantity_in_stock_edit").val(data.quantity_in_stock);
//                 $("#modal_actual_quantity_edit").val(data.actual_quantity);
//                 $("#modal_reason_of_diff_edit").val(data.reason_of_diff);
//                 $('#stock_modal_save_edit_btn').attr('onClick', 'updateStockDetail('+data.id+');');
//             }
            
//         }

//     });  
// }


// function deleteStockDetail(id){

//      $.ajax({
//         url: "http://localhost/ERP/deleteStockDetail?id="+id,
//         type: "GET",
//         headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     },
//         // data: id,
//         //crossDomain: true,
//         // dataType: "json",
           
//         success: function(data) {
//             if (data) {
//                 //alert(id);
//                 $("#"+id).remove();
//                 console.log("deleted");
//             }
            
//         }

//     });  
// }


// function updateStockDetail(id){
// 	if($('#stock_product_id_edit').find(":selected").val() == 0) {

//         swal("Product is not selected!");
       
//         //$('#New-Entry-Modal').modal('hide');
//         return false;
//     }
//     if($('#modal_quantity_in_stock_edit').val() =="" ) {

//         swal("Product Quantity Field is Required!");
//         return false;

//     }
//     if($('#modal_actual_quantity_edit').val() =="" ) {

//         swal("Product Quantity Field is Required!");
//         return false;

//     }
//     if($('#modal_reason_of_diff_edit').val() =="" ) {

//         swal("Product Quantity Field is Required!");
//         return false;

//     }
    


//     var rows = "";
//     rowindexstock=1+rowindexstock;
//     var productName=$('#stock_product_id_edit option:selected').text();
//     var modalQuantityInStock = $('#modal_quantity_in_stock_edit').val();
//     var modalActualQuantity = $('#modal_actual_quantity_edit').val();
//     var modalReasonOfDiff = $('#modal_reason_of_diff_edit').val();

//     rows += "<tr id="+rowindexstock+"><td>" + productName + "</td><td>" + modalQuantityInStock + "</td><td>" + modalActualQuantity + "</td><td>" + modalReasonOfDiff + '</td><td style="text-align:center"><a id="icon-toggle-deleteStockRow" class="removebutton">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td></tr>' ;

//     var tbody = $("#exampleStockEdit tbody");
//     tbody.prepend(rows);
     
//     tableDataStock.push({
//         tableindex : rowindexstock,    
//         productName : $('#stock_product_id_edit option:selected').val() ,
//         QuantityInStock: modalQuantityInStock,
//         ActualQuantity: modalActualQuantity,
//         ReasonOfDifference: modalReasonOfDiff,
         
//     });
//     deleteStockDetail(id);
//      $('#StockDetailEditModal').modal('hide');
//      $('#stockPopupFormEdit')[0].reset();
// }

function updateStock(id){

	if($('#stock_warehouse_edit').find(":selected").val() == 0) {
        swal("Please select warehouse!");
       
        return false;
    }
    if($('#stock_date_edit').val() == "") {
        swal("Please select Date!");
       
        return false;
    }


    var table = $("#exampleStockEdit tbody");
    table.find('tr').each(function (i, el) {
        var $tds = $(this).find('td');
        var values = $tds.find(":input").map(function() {
            return $(this).val()
           }).get()

        tableDataStock.push({
            productId:values[0],
            stockTakingDeatilId:values[1],
            productName : $tds.eq(2).text(),
            quantityInStock: $tds.eq(3).text(),
            actualQuantity: values[2],
            reasonOfDifference: values[3], 
        });

            
    });
    // console.log(tableDataStock);
    // console.log(tableDataStock);
    var submitEntry = {};
    submitEntry.stockDetail = tableDataStock;
    submitEntry.warehouse =  $('#stock_warehouse_edit').find(":selected").val();
    submitEntry.stock_date=  $('#stock_date_edit').val();
    submitEntry.StockId = id;

    //console.log(tableData);
   
        $.ajax({
        url: "http://localhost/ERP/updateStock",
        type: "POST",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        data: submitEntry,
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            if (data.success=="inserted") {
                tableDataStock = [];
                window.location = "http://localhost/ERP/stock";
            }
            
        }

    });    
}