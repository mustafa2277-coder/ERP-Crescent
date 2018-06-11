var rowindex=1; // commont for row index
var tableDataInv = [];

$('#grn_date').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
$('#grn_date_edit').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});


    $(document).on('click', '#icon-toggle-deleteInvRow', function () {
    	//alert("here");
        $(this).closest('tr').remove();

        console.log($(this).closest('tr').attr('id'));
        ii =  $.each(tableDataInv,function(e){

        return e.tableindex == $(this).attr('id'); 

        });
       
        tableDataInv.splice(ii,1);
         return false;
     });



$(document).on('click', 'form button[type=submit]', function(e) {
    e.preventDefault();
    

    if($('#bill_no').val() == "") {
        swal("Please select Bill No!");
        e.preventDefault(); //prevent the default action
        return false;
    }

    if($('#vendor').find(":selected").val() == 0) {
        swal("Please select vendor!");
        e.preventDefault(); //prevent the default action
        return false;
    }
    if($('#project').find(":selected").val() == 0) {
        swal("Please select project!");
        e.preventDefault(); //prevent the default action
        return false;
    }
    if($('#warehouse').find(":selected").val() == 0) {
        swal("Please select warehouse!");
        e.preventDefault(); //prevent the default action
        return false;
    }
    if($('#grn_date').val() == "") {
        swal("Please select Date!");
        e.preventDefault(); //prevent the default action
        return false;
    }
    


    var rowCount = $('#exampleInv tbody tr').length;

        if(rowCount-1 == 0){
            swal("No item is added!");
            e.preventDefault(); //prevent the default action
            return false;
        }

    var submitEntry = {};
    submitEntry.grnDetail = tableDataInv;
    submitEntry.Vendor =  $('#vendor').find(":selected").val();
    submitEntry.project =  $('#project').find(":selected").val();
    submitEntry.warehouse =  $('#warehouse').find(":selected").val();
    submitEntry.bill_no =  $('#bill_no').val();
    submitEntry.grn_no =  $('#grn_no').val();
    submitEntry.grn_date=  $('#grn_date').val();
    submitEntry.isValidated =  $('#isValidated').val();

    //console.log(tableData);
    e.preventDefault();
        $.ajax({
        url: "http://localhost/ERP1/insertGrn",
        type: "POST",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        data: submitEntry,
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            if (data.success=="inserted") {
                tableDataInv = [];
                rowindex=1; 
                window.location = "http://localhost/ERP1/grn";
            }
            
        }

    });    
});





function addGrnDetail(){
	if($('#product_id').find(":selected").val() == 0) {

        swal("Product is not selected!");
       
        //$('#New-Entry-Modal').modal('hide');
        return false;

    }
    if($('#modal_product_quantity').val() =="" ) {

        swal("Product Quantity Field is Required!");
        return false;

    }
    if($('#modal_product_price').val() =="" ) {

        swal("Purchased Price Field is Required!");
        return false;

    }
    if($('#modal_purchased_currency').val() =="" ) {

        swal("Purchased Currency Field is Required!");
        return false;

    }
    if($('#modal_exchange_rate').val() =="" ) {

        swal("Exchange Rate Field is Required!");
        return false;

    }
    if($('#modal_price_in_pkr').val() =="" ) {

        swal("Price in PKR Field is Required!");
        return false;

    }



    $.each(tableDataInv,function(e,val){
        if(val.productId == $('#product_id').find(":selected").val()){
            swal("Product is already added !");
            e.preventDefault();
            return false;
        }   
    });



    var rows = "";
    rowindex=1+rowindex;
    var productName=$('#product_id option:selected').text();
    var modalProductQuantity = $('#modal_product_quantity').val();
    var modalProductPrice = $('#modal_product_price').val();
    var modalPurchasedCurrency = $('#modal_purchased_currency').val();
    var modalExchangeRate = $('#modal_exchange_rate').val();
    var modalPriceInPkr = $('#modal_price_in_pkr').val();

    rows += "<tr id="+rowindex+"><td>" + productName + "</td><td>" + modalProductQuantity + "</td><td >" + modalProductPrice + "</td><td>" + modalPurchasedCurrency + "</td><td>" + modalExchangeRate + "</td><td>" + modalPriceInPkr + '</td><td style="text-align:center"><a id="icon-toggle-deleteInvRow" class="removebutton">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td></tr>' ;

    var tbody = $("#exampleInv tbody");
    tbody.prepend(rows);
     
    tableDataInv.push({
        tableindex : rowindex,    
        productId : $('#product_id option:selected').val() ,
        productName : $('#product_id option:selected').text() ,
        ProductQuantity: modalProductQuantity,
        ProductPrice: modalProductPrice,
        PurchasedCurrency: modalPurchasedCurrency,
        ExchangeRate: modalExchangeRate,
        PriceInPkr: modalPriceInPkr, 
    });
	 $('#inventryModal').modal('hide');
	 $('#invPopupForm')[0].reset(); 


}


function editGrnDetail(id){
    //alert (id);
    $.ajax({
        url: "http://localhost/ERP1/editGrnDetail?id="+id,
        type: "GET",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        // data: id,
        //crossDomain: true,
        // dataType: "json",
           
        success: function(data) {
            if (data) {
                console.log(data);
                $('#product_id_edit  option[value="'+data.product_id+'"]').attr("selected", "selected");
                $("#product_id_edit").val(data.product_id).change();
                $("#modal_product_quantity_edit").val(data.product_quantity);
                $("#modal_product_price_edit").val(data.purchased_price);
                $("#modal_purchased_currency_edit").val(data.purchased_currency);
                $("#modal_exchange_rate_edit").val(data.exchange_rate);
                $("#modal_price_in_pkr_edit").val(data.price_in_pkr);
                $('#modal_save_edit_btn').attr('onClick', 'updateGrnDetail('+data.id+');');
            }
            
        }

    });  
}


function deleteGrnDetail(id){
    $.ajax({
        url: "http://localhost/ERP1/getGrnDetailBeforeDelete?id="+id,
        type: "GET",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            if (data.success=="true") {
                $.ajax({
                    url: "http://localhost/ERP1/deleteGrnDetail?id="+id,
                    type: "GET",
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                    // data: id,
                    //crossDomain: true,
                    // dataType: "json",
                       
                    success: function(data) {
                        if (data) {
                            //alert(id);
                            $("#"+id).remove();
                            console.log("deleted");
                        }
                        
                    }

                });   
            }
            
        }

    });

}


function deleteGrnDetailPlus(id){
    $.ajax({
                    url: "http://localhost/ERP1/deleteGrnDetail?id="+id,
                    type: "GET",
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                    // data: id,
                    //crossDomain: true,
                    // dataType: "json",
                       
                    success: function(data) {
                        if (data) {
                            //alert(id);
                            $("#"+id).remove();
                            console.log("deleted");
                        }
                        
                    }

                });
}



function updateGrnDetail(id){

    if($('#product_id_edit').find(":selected").val() == 0) {

        swal("Product is not selected!");
       
        //$('#New-Entry-Modal').modal('hide');
        return false;

    }
    if($('#modal_product_quantity_edit').val() =="" ) {

        swal("Product Quantity Field is Required!");
        return false;

    }
    if($('#modal_product_price_edit').val() =="" ) {

        swal("Purchased Price Field is Required!");
        return false;

    }
    if($('#modal_purchased_currency_edit').val() =="" ) {

        swal("Purchased Currency Field is Required!");
        return false;

    }
    if($('#modal_exchange_rate_edit').val() =="" ) {

        swal("Exchange Rate Field is Required!");
        return false;

    }
    if($('#modal_price_in_pkr_edit').val() =="" ) {

        swal("Price in PKR Field is Required!");
        return false;

    }


    var rows = "";
    rowindex=1+rowindex;
    var productName=$('#product_id_edit option:selected').text();
    var modalProductQuantity = $('#modal_product_quantity_edit').val();
    var modalProductPrice = $('#modal_product_price_edit').val();
    var modalPurchasedCurrency = $('#modal_purchased_currency_edit').val();
    var modalExchangeRate = $('#modal_exchange_rate_edit').val();
    var modalPriceInPkr = $('#modal_price_in_pkr_edit').val();

    rows += "<tr id="+rowindex+"><td>" + productName + "</td><td>" + modalProductQuantity + "</td><td >" + modalProductPrice + "</td><td>" + modalPurchasedCurrency + "</td><td>" + modalExchangeRate + "</td><td>" + modalPriceInPkr + '</td><td style="text-align: right"><a id="icon-toggle-deleteInvRow" class="removebutton">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td></tr>' ;

    
     
    tableDataInv.push({
        tableindex : rowindex,    
        productId : $('#product_id_edit option:selected').val() ,
        ProductQuantity: modalProductQuantity,
        ProductPrice: modalProductPrice,
        PurchasedCurrency: modalPurchasedCurrency,
        ExchangeRate: modalExchangeRate,
        PriceInPkr: modalPriceInPkr, 
    });

    
    var tbody = $("#exampleInvEdit tbody");
    tbody.prepend(rows);
    $.ajax({
        url: "http://localhost/ERP1/getGrnDetailBeforeDelete?id="+id,
        type: "GET",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            if (data.success=="true") {
                deleteGrnDetailPlus(id);
                console.log(tableDataInv);
                $('#inventryDetailEditModal').modal('hide');
                $('#invPopupFormEdit')[0].reset(); 
            }
            
        }

    });


     
}




function addGrnDetailEditTime(){
    if($('#product_id').find(":selected").val() == 0) {

        swal("Product is not selected!");
       
        //$('#New-Entry-Modal').modal('hide');
        return false;

    }
    if($('#modal_product_quantity').val() =="" ) {

        swal("Product Quantity Field is Required!");
        return false;

    }
    if($('#modal_product_price').val() =="" ) {

        swal("Purchased Price Field is Required!");
        return false;

    }
    if($('#modal_purchased_currency').val() =="" ) {

        swal("Purchased Currency Field is Required!");
        return false;

    }
    if($('#modal_exchange_rate').val() =="" ) {

        swal("Exchange Rate Field is Required!");
        return false;

    }
    if($('#modal_price_in_pkr').val() =="" ) {

        swal("Price in PKR Field is Required!");
        return false;

    }


    var table = $("#exampleInvEdit tbody");
    table.find('tr').each(function (i, el) {
        var $tds = $(this).find('td');
        // console.log($tds.eq(0).text());
        
        if($tds.eq(0).text()== $('#product_id').find(":selected").val()){
            swal("Product is already added !");
            e.preventDefault();
            return false;
        }   
    });



    var rows = "";
    rowindex=1+rowindex;
    var productName=$('#product_id option:selected').text();
    var modalProductQuantity = $('#modal_product_quantity').val();
    var modalProductPrice = $('#modal_product_price').val();
    var modalPurchasedCurrency = $('#modal_purchased_currency').val();
    var modalExchangeRate = $('#modal_exchange_rate').val();
    var modalPriceInPkr = $('#modal_price_in_pkr').val();

    rows += "<tr id="+rowindex+"><td style='display:none'>"+$('#product_id option:selected').val()+"<td>" + productName + "</td><td>" + modalProductQuantity + "</td><td >" + modalProductPrice + "</td><td>" + modalPurchasedCurrency + "</td><td>" + modalExchangeRate + "</td><td>" + modalPriceInPkr + '</td><td style="text-align:center"><a id="icon-toggle-deleteInvRow" class="removebutton">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td></tr>' ;

    var tbody = $("#exampleInvEdit tbody");
    tbody.prepend(rows);
     
    tableDataInv.push({
        tableindex : rowindex,    
        productId : $('#product_id option:selected').val() ,
        productName : $('#product_id option:selected').text() ,
        ProductQuantity: modalProductQuantity,
        ProductPrice: modalProductPrice,
        PurchasedCurrency: modalPurchasedCurrency,
        ExchangeRate: modalExchangeRate,
        PriceInPkr: modalPriceInPkr, 
    });
   
     $('#inventryModal').modal('hide');
     $('#invPopupForm')[0].reset(); 


}




function updateGrn(id){
    //alert(id);
    if($('#bill_no_edit').val() == "") {
        swal("Please select Bill No!");
        e.preventDefault(); //prevent the default action
        return false;
    }

    if($('#vendor_edit').find(":selected").val() == 0) {
        swal("Please select vendor!");
        e.preventDefault(); //prevent the default action
        return false;
    }
    if($('#project_edit').find(":selected").val() == 0) {
        swal("Please select project!");
        e.preventDefault(); //prevent the default action
        return false;
    }
    if($('#warehouse_edit').find(":selected").val() == 0) {
        swal("Please select warehouse!");
        e.preventDefault(); //prevent the default action
        return false;
    }
    if($('#grn_date_edit').val() == "") {
        swal("Please select Date!");
        e.preventDefault(); //prevent the default action
        return false;
    }
    if($('#isValidated_edit').val() == "") {
        swal("Please select Date!");
        e.preventDefault(); //prevent the default action
        return false;
    }


    // var rowCount = $('#exampleInvEdit tbody tr').length;

    //     if(rowCount-1 == 0){
    //         swal("No item is added!");
    //         // e.preventDefault(); //prevent the default action
    //         return false;
    //     }

    var submitEntry = {};
    submitEntry.grnDetail = tableDataInv;
    submitEntry.Vendor =  $('#vendor_edit').find(":selected").val();
    submitEntry.project =  $('#project_edit').find(":selected").val();
    submitEntry.warehouse =  $('#warehouse_edit').find(":selected").val();
    submitEntry.bill_no =  $('#bill_no_edit').val();
    submitEntry.grn_no =  $('#grn_no_edit').val();
    submitEntry.grn_date=  $('#grn_date_edit').val();
    submitEntry.isValidated =  $('#isValidated_edit').val();
    submitEntry.GrnId = id;


    //console.log(tableData);
    // e.preventDefault();
        $.ajax({
        url: "http://localhost/ERP1/updateGrn",
        type: "POST",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        data: submitEntry,
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            if (data.success=="inserted") {
                tableDataInv = [];
                rowindex=1; 
                window.location = "http://localhost/ERP1/grn";
            }
            
        }

    });    
}