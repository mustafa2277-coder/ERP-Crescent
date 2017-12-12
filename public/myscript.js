    
    var rowi=1; // commont for row index
    var tableData = [];

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


           
        if($('#journal_id').find(":selected").val() == 0) {
            swal("Please select Journal!");
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

        $.each(tableData,function(e,val){

            debitTotal += parseFloat(val.debit);  
            creditTotal += parseFloat(val.credit);  

        });

        if(debitTotal != creditTotal) {
            swal("Unbalanced Journal Entry!");
            e.preventDefault(); //prevent the default action
            return false;
        }
        
        var submitEntry = {};
        submitEntry.entryDetail = tableData;
        submitEntry.journalId =  $('#journal_id').find(":selected").val();
        submitEntry.datePost =  $('#date_post').text();

        //console.log(tableData);
          e.preventDefault();
          $.ajax({
            url: "http://localhost/ERP/erp1/insertJournalEntry",
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

   });

 

  
  function AddData() {

     if($('#acc_id').find(":selected").val() == 0) {

        swal("Account is not selected!");
       
        //$('#New-Entry-Modal').modal('hide');
        return false;

       }
 
            var rows = "";
            var partner = "";
            rowi=1+rowi;
                var debitAmt = $('#modal_debit').val();
                var creditAmt = $('#modal_credit').val();
                if(debitAmt =="" || debitAmt == null)
                    debitAmt = 0;
                  
                if(creditAmt =="" || creditAmt == null)
                    creditAmt = 0;

                var account = $('#acc_id').find(":selected").text().trim();
                
                if($('#partner_id').find(":selected").val() != 0) {

                partner =  $('#partner_id').find(":selected").text().trim();
                
                
                }
                 
                rows += "<tr id="+rowi+"><td>" + account + "</td><td>" + partner + "</td><td style='text-align:center'>" + debitAmt + "</td><td style='text-align:center'>" + creditAmt + '</td><td style="text-align:center"><a id="icon-toggle-delete2" class="removebutton">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a></td></tr>' ;
                
                var tbody = $("#example tbody");
                
                //var tr = document.createElement("tr");
                //tr.innerHTML = rows;
                //tbody.appendChild(tr)
                tbody.prepend(rows);
                
                tableData.push({
                tableindex : rowi,    
                accountName : account ,
                accountId: $('#acc_id').find(":selected").val(),
                partner: partner,
                partnerId: $('#acc_id').find(":selected").val(),
                debit: debitAmt, 
                credit: creditAmt, 
                });



                //
            document.getElementById("person").reset();
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

     
        
     