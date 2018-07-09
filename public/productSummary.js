var dataFirst=[];
var dataTwo=[];
var tableDataRecord=[];
var totalValues=[];
var newURL = window.location.protocol + "//" + window.location.host; 
$('select[name="by_category"]').change(function(){
    var mainId=$(this).val();
        $.ajax({
        url: newURL+"/ERP1/getProductSummaryByCategory?id="+$(this).val(),
        type: "GET",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        
        success: function(data) {
            
            if(data.length>0) {
                var tbody = $("#listofProductsSummary tbody");
                tbody.empty();
                var rows = "";
                for (var i = 0; i < data.length; i++) {
                    rows += "<tr ><td style='text-align:center'>" +data[i].name + "</td><td style='text-align:center'>" + data[i].code + '</td><td class="col-sm-3" style="text-align:center">'+ data[i].weight + data[i].uName+'</td><td class="col-sm-3" style="text-align:center">'+ data[i].cName +'</td></tr>' ;
                }

                $('#productSummaryByCategory').attr('href', newURL+"/ERP1/productSummaryByCategoryPdf/"+mainId);
                
                tbody.prepend(rows);

            }
            else{
                    var tbody = $("#listofProductsSummary tbody");

                    tbody.empty();
                    $('#productSummaryByCategory').attr('href', '');
                }
        }

    }); 
            
});