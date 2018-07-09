var dataFirst=[];
var dataTwo=[];
var tableDataRecord=[];
var totalValues=[];
var newURL = window.location.protocol + "//" + window.location.host; 
$('select[name="report_vendor"]').change(function(){
    var mainId=$(this).val();
        $.ajax({
        url: newURL+"/ERP1/getVendorReport?id="+$(this).val(),
        type: "GET",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
        
        success: function(data) {
            
            if(data!="false") {
                
                var tbody = $("#listofProductsByVendor tbody");
                tbody.empty();
                var rows = "";
                for (var i = 0; i < data.length; i++) {
                    rows += "<tr ><td style='text-align:center'>" +data[i].name + "</td><td style='text-align:center'>" + data[i].sumqaunt + '</td><td class="col-sm-3" style="text-align:center">'+ data[i].purchased_price +'</td></tr>' ;
                }
                
                tbody.prepend(rows);
                $('#vendorReportPrint').attr('href', newURL+"/ERP1/vendorReportPdf/"+mainId);
            }
            else{
                    var tbody = $("#listofProductsByVendor tbody");
                    tbody.empty();
                    $('#vendorReportPrint').attr('href', '');
                }
        }

    }); 
            
});