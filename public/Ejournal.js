$(document).on('click', '#icon-toggle-delete2', function () {
    
    $(this).closest('tr').remove();
    row=$('#rowTotal').val()-1;
    $('#rowTotal').val(row);
    console.log($(this).closest('tr').attr('id'));
   /*  ii =  $.each(tableData,function(e){

    return e.tableindex == $(this).attr('id'); 

    });
   
    tableData.splice(ii,1); */
    calculate2();
     return false;
 });

$(document).on('click', '#submit', function(e) {

    e.preventDefault();
    if($('#journal_id').find(":selected").val() == 0) {
        swal("Please select Journal!");
       // e.preventDefault(); //prevent the default action
        return false;
    }

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
    var chkdate=$('#pdate').val();
        if(moment(chkdate, 'DD/MM/YYYY',true).isValid()==false) {
            swal("Wrong Date");
            e.preventDefault(); //prevent the default action
            return false;
        }
    var row=$('#rowTotal').val();
    if(!row || row=="0"){
        swal("Please Enter Debit Credit Entries");
         //prevent the default action
        return false; 
    }
        var submitEntry = {};
        submitEntry.acc=[];
        submitEntry.debit=[];
        submitEntry.credit=[];
        submitEntry.journalId =  $('#journal_id').find(":selected").val();
        submitEntry.projectId =  $('#project_id').find(":selected").val();
        submitEntry.datePost =  $('#pdate').val();
        submitEntry.reference =  $('#reference').val();
        submitEntry.rowTotal=row;
        for(var i=1;i<=row;i++){
            //var cat="$('#acc'"+i+
            submitEntry.acc[i-1] = $("#acc"+i).val();  
            submitEntry.debit[i-1] = $("#debit"+i).val();
            submitEntry.credit[i-1] = $("#credit"+i).val();
        }
        for(var j=0;j<row;j++){
            //var cat="$('#acc'"+i+
            if(submitEntry.debit[j]==""&&submitEntry.credit[j]=="" ){
                swal("Field cannot be remain empty");
               
                return false;
            }
            if(submitEntry.debit[j]==""&&submitEntry.credit[j]=="" || submitEntry.debit[j]=='0'&&submitEntry.credit[j]=='0'){
                swal("PLease Enter the values Properly");
               
                return false;
            }
            if(submitEntry.debit[j]=="0"&&submitEntry.credit[j]=="" || submitEntry.debit[j]==''&&submitEntry.credit[j]=='0'){
                swal("PLease Enter the values Properly");
               
                return false;
            }
            if(submitEntry.debit[j]>0 && submitEntry.credit[j]>0){
                swal("Invalid Entry");
               
                return false;
            }
            
            submitEntry.acc[i]  
            submitEntry.debit[i] 
            submitEntry.credit[i] 
        }
        if($('#creditAmt').text()!=$('#debitAmt').text()){
            swal("Unbalance Entry");
           
            return false;
        }
        console.log(submitEntry);
        e.preventDefault();
        $.ajax({
            url: "http://localhost/ERP/insertNJournalEntry",
            type: "POST",
            headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
            data: submitEntry,
            //crossDomain: true,
            dataType: "json",
           
            success: function(data) {
            console.log(data);
           

            }
        });

});




