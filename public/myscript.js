    
    var rowi=1; // commont for row index
    var tableData = [];
    $('#date_post').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
    $('#date_post1').bootstrapMaterialDatePicker({  weekStart : 0, time: false ,format : 'DD/MM/YYYY'});
    // for changing dateformat
    $(document).ready(function() {
     
     

    $(document).on('click', '#icon-toggle-delete2', function () {
    
        $(this).closest('tr').remove();

        console.log($(this).closest('tr').attr('id'));
        ii =  $.each(tableData,function(e){

        return e.tableindex == $(this).attr('id'); 

        });
       
        tableData.splice(ii,1);
        calculate();
         return false;
     });

    $(document).on('click', 'form button[type=submit]', function(e) {

         e.preventDefault();
           
        if($('#journal_id').find(":selected").val() == 0) {
            swal("Please select Journal!");
            e.preventDefault(); //prevent the default action
            return false;
        }

        if($('#date_post').val() == "") {
            swal("Please select Date!");
            e.preventDefault(); //prevent the default action
            return false;
        }

        if($('#date_post1').val() == "") {
            swal("Please select Date!");
            e.preventDefault(); //prevent the default action
            return false;
        }


        if($('#reference').val() == "") {
            swal("Empty Reference Field!");
            e.preventDefault(); //prevent the default action
            return false;
        }

        var rowCount = $('#example tbody tr').length;

        if(rowCount-1 == 0){
            swal("No item is added!");
            e.preventDefault(); //prevent the default action
            return false;
        }

        var debitTotal = 0;
        var creditTotal = 0;
        var invalidentry = 0; 
        var countAcc = 1; // for checking there are more than two accounts

        $.each(tableData,function(e,val){

            if((parseFloat(val.debit) !=0 && parseFloat(val.credit) ==0) || (parseFloat(val.debit) ==0 && parseFloat(val.credit) !=0 )){

            debitTotal += parseFloat(val.debit);  
            creditTotal += parseFloat(val.credit); 

            } 
            else{

                invalidentry = 1; return false;      
            }

        });

        // for checking there are more than two accounts
        $.each(tableData,function(e,val){

            $.each(tableData,function(e2,val2){
            if(val.accountId != val2.accountId){
                countAcc +=1;
                return false;
            }    
            });

        });



        if(invalidentry ==1 || countAcc == 1 ){
            swal("Invalid entry!");
            return false;
        }

        if(debitTotal != creditTotal) {
            swal("Unbalanced Journal Entry!");
            e.preventDefault(); //prevent the default action
            return false;
        }
        
        var submitEntry = {};
        submitEntry.entryDetail = tableData;
        submitEntry.journalId =  $('#journal_id').find(":selected").val();
        submitEntry.datePost =  $('#date_post').val();
        submitEntry.reference =  $('#reference').val();

        //console.log(tableData);
          e.preventDefault();
          $.ajax({
            url: "http://localhost/ERP/insertJournalEntry",
            type: "POST",
            headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
            data: submitEntry,
            //crossDomain: true,
            dataType: "json",
           
            success: function(data) {
             window.location = "http://localhost/ERP/getJournalEntries";
           

            }

         });
    



    });

   });

 

  
  function AddData() {

     if($('#acc_id').find(":selected").val() == 0) {

        swal("Account is not selected!");
       
        //$('#New-Entry-Modal').modal('hide');
        return false;

       }
 
            var rows = "";
            var project = "";
            rowi=1+rowi;
                var debitAmt = $('#modal_debit').val();
                var creditAmt = $('#modal_credit').val();
                if(debitAmt =="" || debitAmt == null)
                    debitAmt = 0;
                  
                if(creditAmt =="" || creditAmt == null)
                    creditAmt = 0;

                var account = $('#acc_id').find(":selected").text().trim();
                
                if($('#project_id').find(":selected").val() != 0) {

                project =  $('#project_id').find(":selected").text().trim();
                
                
                }
                 
                rows += "<tr id="+rowi+"><td>" + account + "</td><td>" + project + "</td><td style='text-align:center'>" + debitAmt + "</td><td style='text-align:center'>" + creditAmt + '</td><td style="text-align:center"><a id="icon-toggle-delete2" class="removebutton">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td></tr>' ;
                
                var tbody = $("#example tbody");
                
                //var tr = document.createElement("tr");
                //tr.innerHTML = rows;
                //tbody.appendChild(tr)
                tbody.prepend(rows);
                
                tableData.push({
                tableindex : rowi,    
                accountName : account ,
                accountId: $('#acc_id').find(":selected").val(),
                project: project,
                projectId: $('#project_id').find(":selected").val(),
                debit: debitAmt, 
                credit: creditAmt, 
                });



                //
            //document.getElementById("person").reset();
            $('#New-Entry-Modal').modal('hide');    
            calculate();

        }

        function calculate(){

            var debitAmt = 0;
            var creditAmt = 0;


            var table = $("table tbody");
            var rowCount = $('#example tbody tr').length;
            //console.log(rowCount);
            table.find('tr').each(function (i) {
                if(i<rowCount-1){
                  
                   var $tds = $(this).find('td'),
                    
                    debit = $tds.eq(2).text();
                    debitAmt = parseFloat(debit) + debitAmt;

                    credit = $tds.eq(3).text();
                    creditAmt = parseFloat(credit) + creditAmt;

                }
            });
            $('#total').closest('tr').remove();
            var tbody = $("#example tfoot");
            var row = "<tr id='total'><th colspan='2' style='text-align:center'>    Total</th><th style='text-align:center'>" + debitAmt +"</th><th style='text-align:center'>" + creditAmt +"</th><th></th></tr>";
                tbody.append(row);

        }

     
        
     