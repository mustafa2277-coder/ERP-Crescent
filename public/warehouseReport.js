var dataFirst=[];
var dataTwo=[];


$('select[name="report_warehouse"]').change(function(){
    var mainId=$(this).val();
        $.ajax({
        url: "http://localhost/ERP/getWarehouseReport?id="+$(this).val(),
        type: "GET",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        
        success: function(data) {
            
            if(data[0] && data[1]) {
                dataFirst=data[0];
                dataTwo=data[1];
                
                var tbody = $("#listofProductsByWarehouse tbody");
                tbody.empty();
                var rows = "";
                for (var i = 0; i < data.length; i++) {
                    rows += "<tr ><td class='col-sm-3' style='text-align:center'>" +dataFirst[i].pName + "</td><td class='col-sm-3' style='text-align:center'>" + dataTwo[i].quantity_in_hand + '</td><td class="col-sm-3" style="text-align:center">'+ dataFirst[i].purchased_price +'</td><td class="col-sm-3" style="text-align:center">'+ dataFirst[i].weight +' '+ dataFirst[i].name+'</td></tr>' ;
                }
                tbody.prepend(rows);
                $('#wareHouseReportPrint').attr('href', "http://localhost/ERP/warehouseReportPdf/"+mainId);
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