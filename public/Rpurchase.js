$(document).on('click', '#submit', function(e) {

    e.preventDefault();

    if($('#project_id').find(":selected").val() == 0) {
        swal("Please select Project!");
       // e.preventDefault(); //prevent the default action
        return false;
    }
    if($('#pdate').val() == "") {
        swal("Please Enter the Date!");
       // e.preventDefault(); //prevent the default action
        return false;
    }
    if($('#rdate').val() == "") {
        swal("Please Enter Required Delivery Date !");
       // e.preventDefault(); //prevent the default action
        return false;
    }
    var chkdate=$('#pdate').val();
        if(moment(chkdate, 'DD/MM/YYYY',true).isValid()==false) {
            swal("Wrong Date");
            e.preventDefault(); //prevent the default action
            return false;
        }
    var chkdate=$('#rdate').val();
        if(moment(chkdate, 'DD/MM/YYYY',true).isValid()==false) {
            swal("Wrong Required Date");
            e.preventDefault(); //prevent the default action
            return false;
        }
    var submitEntry = {};
    submitEntry.product=[];
    submitEntry.quantity=[];
    submitEntry.projectId =  $('#project_id').find(":selected").val();
    submitEntry.datePost =  $('#pdate').val();
    submitEntry.rDate =  $('#rdate').val();
    submitEntry.description =  $('#description').val();
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
            selection = $tds.eq(0).find("select").val();
            pName=$tds.eq(0).find("option:selected").text();
            //alert(selection);
            submitEntry.product[i-1]=selection;
            prod[i-1]=selection;
            prodName[i-1]=pName;
            qty = $tds.eq(1).find("input").val();
            //alert(debit);
            submitEntry.quantity[i-1]=qty;
            
            
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
        var urllink=newURL+'/ERP1/insertRequestPurchase';
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
            if(data.message="inserted"){
                //alert('hello');
                $("#num").val(data.rpNumber);
                $("#msg").text('Data have been saved');
                $("#download").removeClass("download");
                
            }
           

            }
        });

});




