$(document).on('click', '#submit', function(e) {

    e.preventDefault();

    if($('#package_id').find(":selected").val() == 0) {
        swal("Please select Package Name!");
       // e.preventDefault(); //prevent the default action
        return false;
    }
    
    var submitEntry = {};
    submitEntry.product=[];
    submitEntry.quantity=[];
    submitEntry.unit=[];
    submitEntry.product_type=[];
    submitEntry.package_id =  $('#package_id').find(":selected").val();
    
    submitEntry.id= $('#id').val();
    var table = $("table tbody");
    var rowCount = $('#example tbody tr').length;
    //alert(rowCount);
    row=rowCount-1;
    submitEntry.rowTotal=rowCount-1;
    prod=[];
    prodName=[];
    //showProd=[];
    table.find('tr').each(function (i) {
        if(i>0){
          
            var $tds = $(this).find('td');
            selection = $tds.eq(0).find("input").data('id');
            pName=  $tds.eq(0).find("input").val();
            //alert(selection);
            submitEntry.product[i-1]=selection;
            prod[i-1]=selection;
            prodName[i-1]=pName;
            qty = $tds.eq(1).find("input").val();
            unit = $tds.eq(2).find("input").val();
            product_type = $tds.eq(3).find("select").val();
            //alert(debit);
            submitEntry.quantity[i-1]=qty;
            submitEntry.unit[i-1]=unit;
            submitEntry.product_type[i-1]=product_type;
            
            
        }
    });
    console.log(prod);
    
    for(f=0;f<prod.length;f++){
        count=0;
        for(s=0;s<prod.length;s++){
            if(prod[f]==prod[s]){
                count=count+1;
                if(count>1){
                    swal("Duplicate product "+prodName[f]);
                // e.preventDefault(); //prevent the default action
                    return false;
                }
            }
        }
    }
    

    
        console.log(submitEntry);
        e.preventDefault();
        var newURL = window.location.protocol + "//" + window.location.host;
        //alert(newURL);
        var urllink=newURL+'/ERP1/insertProductPakcage';
        redirect=newURL+'/ERP1/packageList';
        $.ajax({
            url: urllink,
            type: "POST",
            headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
            data: submitEntry,
            //crossDomain: true,
            dataType: "json",
           
            success: function(data) {
            console.log(data);
            if(data.message=="inserted"){
                window.location.replace(redirect);
                /* $("#num").val(data.rpNumber);
                $("#msg").text('Data have been saved');
                $("#download").removeClass("download"); */
                
            }else{
                swal("The Package is already in the record");
            }
           

            }
        });

});




