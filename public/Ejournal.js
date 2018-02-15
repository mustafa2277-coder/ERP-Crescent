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
    var submitEntry = {};
    submitEntry.acc=[];
    submitEntry.debit=[];
    submitEntry.credit=[];
    submitEntry.journalId =  $('#journal_id').find(":selected").val();
    submitEntry.projectId =  $('#project_id').find(":selected").val();
    submitEntry.datePost =  $('#pdate').val();
    submitEntry.reference =  $('#reference').val();
    submitEntry.id= $('#id').val();
    var table = $("table tbody");
    var rowCount = $('#example tbody tr').length;
    //alert(rowCount);
    row=rowCount-1;
    submitEntry.rowTotal=rowCount-1;

    table.find('tr').each(function (i) {
        if(i>0){
          
            var $tds = $(this).find('td');
            selection = $tds.eq(0).find("select").val();
            //alert(selection);
            submitEntry.acc[i-1]=selection;

            debit = $tds.eq(2).find("input").val();
            //alert(debit);
            submitEntry.debit[i-1]=debit
            //debitAmt = parseFloat(debit) + debitAmt;

            credit = $tds.eq(3).find("input").val();
            //creditAmt = parseFloat(credit) + creditAmt;
            //alert(credit);
            submitEntry.credit[i-1]=credit;
        }
    });
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
            if(data.message="inserted"){
                alert('hello');
                $("#num").val(data.entryNumber);
                $("#msg").text('Data Inserted');
                $("#download").removeClass("download");
                 /* $("#reset").removeClass("download");  */
            }
           

            }
        });

});




