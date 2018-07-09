var dataFirst=[];
var dataTwo=[];
var newURL = window.location.protocol + "//" + window.location.host; 

$('select[name="report_warehouse"]').change(function(){
    var mainId=$(this).val();
        $.ajax({
        url: newURL+"/ERP1/getWarehouseReport?id="+$(this).val(),
        type: "GET",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        
        success: function(data) {
            // console.log(data);
            if(data) {
                // console.log(data);
                var tbody = $("#listofProductsByWarehouse tbody");
                tbody.empty();
                var rows = "";
                for (var i = 0; i < data.length; i++) {
                    // console.log(dataFirst[i].pName);
                    rows += "<tr ><td class='col-sm-3' style='text-align:center'>" +data[i].pName + "</td><td class='col-sm-3' style='text-align:center'>" + data[i].quantity_in_hand + '</td><td class="col-sm-3" style="text-align:center">'+ data[i].purchased_price +'</td><td class="col-sm-3" style="text-align:center">'+ data[i].weight +' '+ data[i].uName+'</td></tr>' ;
                }
                tbody.prepend(rows);
                $('#wareHouseReportPrint').attr('href', newURL+"/ERP1/warehouseReportPdf/"+mainId);
            }
            else{
                    var tbody = $("#listofProductsByWarehouse tbody");
                    tbody.empty();
                    $('#wareHouseReportPrint').attr('href', '');
                    // $("#wareHouseReportPrint").prop("onclick", null);
                }
        }

    }); 
            
});