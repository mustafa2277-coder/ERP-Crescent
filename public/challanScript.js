var rowindexcha=1; // commont for row index
var tableDataChallan = [];
var newURL = window.location.protocol + "//" + window.location.host;
$('#delivery_challan_date').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
$('#challan_date_edit').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});


$(document).on('click', '#icon-toggle-deleteChallanRow', function () {
        //alert("here");
        $(this).closest('tr').remove();

        console.log($(this).closest('tr').attr('id'));
        ii =  $.each(tableDataChallan,function(e){

        return e.tableindex == $(this).attr('id'); 

        });
       
        tableDataChallan.splice(ii,1);
         return false;
     });






function addChallan(){
    if($('#delivery_challan_no').val() == "") {
        swal("Please challan No!");
        
        return false;
    }

    
    if($('#challan_project').find(":selected").val() == 0) {
        swal("Please select project!");
       
        return false;
    }
    if($('#challan_warehouse').find(":selected").val() == 0) {
        swal("Please select warehouse!");
       
        return false;
    }
    if($('#delivery_challan_date').val() == "") {
        swal("Please select Date!");
       
        return false;
    }
    if($('#challan_isValidated').val() == "") {
        swal("Please select Date!");
        
        return false;
    }


    var rowCount = $('#exampleChallan tbody tr').length;

        if(rowCount-1 == 0){
            swal("No item is added!");
            
            return false;
        }

    var submitEntry = {};
    submitEntry.challanDetail = tableDataChallan;
    submitEntry.project =  $('#challan_project').find(":selected").val();
    submitEntry.warehouse =  $('#challan_warehouse').find(":selected").val();
    submitEntry.challan_no =  $('#delivery_challan_no').val();
    submitEntry.challan_date=  $('#delivery_challan_date').val();
    submitEntry.isValidated =  $('#challan_isValidated').val();

    //console.log(tableData);
        
        $.ajax({
        url: newURL+"/ERP1/insertChallan",
        type: "POST",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        data: submitEntry,
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            if (data.success=="inserted") {
                tableDataChallan = [];
                rowindexcha=1; 
                window.location = newURL+"/ERP1/challan";
            }
            else if (data[0]==1) {
                swal("You do not have much quantity of "+ data[1] +" in hand !!!");
        
                return false;
            }
            else if(data){
                
                swal("You do not have much quantity of "+ data[0] +" in hand !!!");
        
                return false;
            }
            
        }

    });    
}



function addChallanDetail(){
	if($('#challan_product_id').find(":selected").val() == 0) {

        swal("Product is not selected!");
       
        //$('#New-Entry-Modal').modal('hide');
        return false;
    }
    if($('#challan_modal_product_quantity').val() =="" ) {

        swal("Product Quantity Field is Required!");
        return false;

    }
    
    
    $.each(tableDataChallan,function(e,val){
        if(val.productId == $('#challan_product_id option:selected').val()){
            swal("Product is already added !");
            e.preventDefault();
            return false;
        }   
    });

    var rows = "";
    rowindexcha=1+rowindexcha;
    var productName=$('#challan_product_id option:selected').text();
    var modalProductQuantity = $('#challan_modal_product_quantity').val();

    rows += "<tr id="+rowindexcha+"><td>" + productName + "</td><td>" + modalProductQuantity + '</td></tr>' ;

    var tbody = $("#exampleChallan tbody");
    tbody.prepend(rows);
     
    tableDataChallan.push({
        tableindex : rowindexcha,    
        productId : $('#challan_product_id option:selected').val() ,
        productName : $('#challan_product_id option:selected').text() ,
        ProductQuantity: modalProductQuantity,
         
    });
	 $('#challanModal').modal('hide');
	 $('#challanPopupForm')[0].reset(); 


}



function addChallanDetailEditTime(){
    if($('#product_id').find(":selected").val() == 0) {

        swal("Product is not selected!");
        e.preventDefault();
       
        //$('#New-Entry-Modal').modal('hide');
        return false;
    }
    if($('#modal_product_quantity').val() =="" ) {

        swal("Product Quantity Field is Required!");
        e.preventDefault();
        return false;

    }
    


    var table = $("#exampleChallanEdit tbody");
    table.find('tr').each(function (i, el) {
        var $tds = $(this).find('td');
        
        
        if($tds.eq(0).text()== $('#product_id').find(":selected").val()){
            swal("Product is already added !");
            e.preventDefault();
            return false;
        }   
    });





    var rows = "";
    rowindexcha=1+rowindexcha;
    var productName=$('#product_id option:selected').text();
    var modalProductQuantity = $('#modal_product_quantity').val();

    rows += "<tr id="+rowindexcha+"><td>" + productName + "</td><td>" + modalProductQuantity + '</td></tr>' ;

    var tbody = $("#exampleChallanEdit tbody");
    tbody.prepend(rows);
     
    tableDataChallan.push({
        tableindex : rowindexcha,    
        productId : $('#product_id option:selected').val() ,
        productName : $('#product_id option:selected').text() ,
        ProductQuantity: modalProductQuantity,
         
    });
     $('#challanModal').modal('hide');
     $('#challanPopupForm')[0].reset(); 


}


function editChallanDetail(id){
    //alert (id);
    $.ajax({
        url: newURL+"/ERP1/editChallanDetail?id="+id,
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
                $('#product_id_edit_challan  option[value="'+data.product_id+'"]').attr("selected", "selected");
                $("#product_id_edit_challan").val(data.product_id).change();
                $("#modal_product_quantity_edit_challan").val(data.product_quantity);
                $('#challan_modal_save_edit_btn').attr('onClick', 'updateChallanDetail('+data.id+');');
            }
            
        }

    });  
}


function deleteChallanDetail(id){

    $.ajax({
        url: newURL+"/ERP1/getChallanDetailBeforeDelete?id="+id,
        type: "GET",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            if (data.success=="true") {
                $.ajax({
                    url: newURL+"/ERP1/deleteChallanDetail?id="+id,
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



function deleteChallanDetailPlus(id){
     $.ajax({
                    url: newURL+"/ERP1/deleteChallanDetail?id="+id,
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




function updateChallanDetail(id){
    if($('#product_id_edit_challan').find(":selected").val() == 0) {

        swal("Product is not selected!");
       
        //$('#New-Entry-Modal').modal('hide');
        return false;

    }
    if($('#modal_product_quantity_edit_challan').val() =="" ) {

        swal("Product Quantity Field is Required!");
        return false;

    }

    $.each(tableDataChallan,function(e,val){
        if(val.productId == $('#product_id_edit_challan option:selected').val()){
            swal("Product is already added !");
            e.preventDefault();
            return false;
        }   
    });


    var rows = "";
    rowindexcha=1+rowindexcha;
    var productName=$('#product_id_edit_challan option:selected').text();
    var modalProductQuantity = $('#modal_product_quantity_edit_challan').val();

    rows += "<tr id="+rowindexcha+"><td>" + productName + "</td><td>" + modalProductQuantity + '</td></tr>' ;

    var tbody = $("#exampleChallanEdit tbody");
    tbody.prepend(rows);
     
    tableDataChallan.push({
        tableindex : rowindexcha,    
        productId : $('#product_id_edit_challan option:selected').val() ,
        productName : $('#product_id_edit_challan option:selected').val() ,
        ProductQuantity: modalProductQuantity,
         
    });
    
    $.ajax({
        url: newURL+"/ERP1/getChallanDetailBeforeDelete?id="+id,
        type: "GET",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            if (data.success=="true") {
                deleteChallanDetailPlus(id);
                 $('#challanDetailEditModal').modal('hide');
                 $('#challanPopupFormEdit')[0].reset();
            }
            if (data.success=="true") {
                deleteChallanDetailPlus(id);
                 $('#challanDetailEditModal').modal('hide');
                 $('#challanPopupFormEdit')[0].reset();
            }

            
        }

    });
    
}




function updateChallan(id){
    if($('#challan_no_edit').val() == "") {
        swal("Please challan No!");
        
        return false;
    }

    
    if($('#challan_project_edit').find(":selected").val() == 0) {
        swal("Please select project!");
       
        return false;
    }
    if($('#challan_warehouse_edit').find(":selected").val() == 0) {
        swal("Please select warehouse!");
       
        return false;
    }
    if($('#challan_date_edit').val() == "") {
        swal("Please select Date!");
       
        return false;
    }
    if($('#challan_isValidated_edit').val() == "") {
        swal("Please select Date!");
        
        return false;
    }


    var rowCount = $('#exampleChallanEdit tbody tr').length;

        if(rowCount-1 == 0){
            swal("No item is added!");
            
            return false;
        }

    var submitEntry = {};
    submitEntry.challanDetail = tableDataChallan;
    submitEntry.project =  $('#challan_project_edit').find(":selected").val();
    submitEntry.warehouse =  $('#challan_warehouse_edit').find(":selected").val();
    submitEntry.challan_no =  $('#challan_no_edit').val();
    submitEntry.challan_date=  $('#challan_date_edit').val();
    submitEntry.isValidated =  $('#challan_isValidated_edit').val();
    submitEntry.ChallanId = id;
    //console.log(tableData);
   
        $.ajax({
        url: newURL+"/ERP1/updateChallan",
        type: "POST",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        data: submitEntry,
        //crossDomain: true,
        dataType: "json",
           
        success: function(data) {
            if (data.success=="inserted") {
                tableDataChallan = [];
                rowindexcha=1; 
                window.location = newURL+"/ERP1/challan";
            }
            else if (data[0]==1) {
                swal("You do not have much quantity of "+ data[1] +" in hand !!!");
        
                return false;
            }
            
        }

    });    
}