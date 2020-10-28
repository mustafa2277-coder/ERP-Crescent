$(document).ready(function(){

//alert("We are in dynamic view transfer script.");
var localurl=window.location.protocol+"//"+ window.location.hostname + '/ERP1/';


$('.view_transfer').on('click',function(){

var id=$(this).attr('data-id');

//alert("Current id: " + id);
/*Ajax Call Start */

$.ajax({
    url: localurl + "/showModalData/" + id,
    type: 'GET',
    data: { },
    success: function(response){
        var datarow ='<table class="table table-striped table-hover" id="product_table"><thead><tr style="background: #f44336;color: #fff;"><th>Product</th><th>Warehouse</th><th>Quantity</th></tr></thead><tbody>' ;
        for(var i=0; i<response.length; i++)
            {   
                datarow +=
                    '<tr>'+
                        '<td>' + response[i].prodName + '</td>' +
                        '<td>' + response[i].warehouse_name + '</td>' +
                        '<td>' + response[i].quantity + '</td>' +
                    '</tr></tbody>';
            }
            //alert(datarow);
        $('#showdataModal .loadmodal').html(datarow);
        $("#showdataModal").modal('show');
    }

});

/*Ajax Call End */



});





});