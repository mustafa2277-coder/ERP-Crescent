

<div class="table-responsive">
    <!-- <a href="#" class="exportcsv">Export Table data into Excel</a>                              -->
    <table id="example"  class="table  table-striped table-hover">
        <thead>
            <tr style="background: #f44336;color: #fff;">
                <th style="text-align:center; width: 265px;" colspan="5">ACCOUNT</th>
                <th style="text-align:center">DEBIT</th>
                <th style="text-align:center">CREDIT</th>
                <th style="text-align:center">BALANCE</th>
            </tr>
        </thead> 
        <tbody>
            <tr>
                <td colspan="8">
                    <div class="panel-group" id="accordion_4" role="tablist" aria-multiselectable="true">
                    @foreach ($ledgerAccounts as $ledgerAccount)
                    <?php $sumDebit=$sumCredit=0; $balance=0;?>        
                        <div class="panel">
                             <div class="panel-heading" role="tab" id="{{$ledgerAccount->id}}">
                                <h4 class="panel-title">
                                    <a  role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapse_{{$ledgerAccount->id}}" aria-expanded="false" aria-controls="collapse_{{$ledgerAccount->id}}">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span id="head">{{$ledgerAccount->code}}  {{$ledgerAccount->name}}</span>
                                        <span id="bal" style="float: right;border-left solid: 1px;border-left: solid #b9b6b6 1px;width: 14%; display: inline-block;text-align: center; font-size: 12px;"></span>
                                        <span id="cre" style="float: right;border-left: solid #b9b6b6 1px;width: 14%;display: inline-block;
                                        text-align: center;font-size: 12px;"></span>
                                        <span id="deb" style="float: right;border-left: solid #b9b6b6 1px;width: 13%;display: inline-block;
                                        text-align: center;font-size: 12px;"></span>
                                    </a>
                                </h4>
                            </div>

                            <div id="collapse_{{$ledgerAccount->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$ledgerAccount->id}}">
                                <div class="panel-body">
                                    <table id="example2"  class="table  table-striped table-hover">
                                        <thead>
                                            <tr style="background: #f44336;color: #fff;">
                                                <th>DATE</th>
                                                <th>NUMBER</th>
                                                <th>PROJECT</th>
                                                <th style="text-align:center">DEBIT</th>
                                                <th style="text-align:center">CREDIT</th>
                                                <th style="text-align:center">BALANCE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">Initial Balance</td>
                                                <td style="text-align:center">0</td>
                                                <td style="text-align:center">0</td>
                                                <td style="text-align:center">{{$ledgerAccount->Balance}}</td>
                                            </tr>
                                            <?php if(isset($ledgerAccount->Balance))$balance+=$ledgerAccount->Balance; ?>
                                            @foreach ($ledgers as $ledger)
                                            
                                            @if ($ledger->id==$ledgerAccount->id)
                                            <tr class="detailModal" style="cursor:  pointer;" title="View" >

                                                <td> {{date('d/m/Y', strtotime($ledger->date_post))}} </td>
                                                <td>{{$ledger->entryNum}} </td>
                                                <td>{{$ledger->project}} </td>
                                                @if ($ledger->Debit!=null)
                                                <td style="text-align:center">{{$ledger->Debit}}</td>
                                                @else                        
                                                <td style="text-align:center">0</td>
                                                @endif    
                                                @if ($ledger->Credit!=null)
                                                <td style="text-align:center">{{$ledger->Credit}}</td>
                                                @else                        
                                                <td style="text-align:center">0</td>
                                                @endif                          
                                            <?php $sumDebit += $ledger->Debit; $sumCredit += $ledger->Credit; $balance = $balance + $ledger->Debit - $ledger->Credit ;?>
                                                <td style="text-align:center">{{$balance}}</td> 
                                            </tr>
                                            @endif
                                            @endforeach 
                                            <tr id="total">
                                                <th colspan="3" style="text-align:center">Total:</th>
                                                <th style="text-align:center">{{$sumDebit}}</th>
                                                <th style="text-align:center">{{$sumCredit}}</th>
                                                <th style="text-align:center">{{$balance}}</th>
                                            </tr>

                                         </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                     @endforeach    
                    </div>



                </td>
            </tr>
        </tbody>
    </table>
    
</div>

<script src="{{asset('public/plugins/print/jQuery.PrintArea.js')}}"></script> 
<script>
    $(document).ready(function(){


        $('.collapse').on('shown.bs.collapse', function(){
        $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }).on('hidden.bs.collapse', function(){
        $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
        });



        var divPanel = $(".panel");

        divPanel.each(function (item) {

            $(this).find('span#deb').text($(this).find('tr#total th').eq(1).text());
            $(this).find('span#cre').text($(this).find('tr#total th').eq(2).text());
            $(this).find('span#bal').text($(this).find('tr#total th').eq(3).text());
        });

     });
        $('.detailModal').on('click', function () {
       
           $.ajax({
                url: "http://localhost/ERP/getJournalEntryByEntrynum",
                type: "GET",
                headers: {
                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                             },
                data: {entrynum:$(this).find('td').eq(1).text()},
                //crossDomain: true,
                dataType: "json",
                beforeSend: function() { $('.page-loader-wrapper').fadeIn();},
                complete: function() { $('.page-loader-wrapper').fadeOut();},

                success: function(data) {


                    if(data.length !=0){
                        var inovDate = new Date(data[0].entryDate);
                        $('#modal_date').text( inovDate.getDate() + '/' + (inovDate.getMonth() + 1) + '/' +  inovDate.getFullYear());
                        $('#modal_journal').text(data[0].journal);
                        $('#modal_entrynum').text(data[0].entryNum);
                        $('#modal_ref').text(data[0].reference);
                        
                   
                        $('#defaultModal').modal('show');
                        var totalDebit = 0;
                        var totalCredit = 0;

                        $.each(data,function(i,val){

                            var row ="";
                            var debit=0;
                            var credit=0;
                            if(val.isDebit==0){
                              credit = val.amount;
                              debit = 0;
                            }
                             else{
                             debit = val.amount; 
                             credit = 0;  
                            }
                            totalDebit  += parseFloat(debit);
                            totalCredit += parseFloat(credit);

                            row = "<tr><td>"+val.accountheadCode+"</td><td>"+val.account+"</td><td>"+val.project+"</td><td>"+debit+"</td><td>"+credit+"</td></tr>";
                            $('#modalTable tbody').append(row);

                           

                       //  console.log(val);  

                        });

                         row = "<tr><th  colSpan='3' style='text-align:center'>Total</th><th>"+totalDebit+"</th><th>"+totalCredit+"</th></tr>";
                            $('#modalTable tbody').append(row);
                       
                        
                    //alert(data);
                }
                else{

                    swal('error');
                }
            }

             });

        
    });

    $('#defaultModal').on('hidden.bs.modal', function () {
        $('#modal_date').text('');
        $('#modal_journal').text('');
        $('#modal_entrynum').text('');
        $('#modalTable tbody').html('');

    });


       function exportTableToCSV($table, filename) {

        var rows = $table.find('tr:has(td)');



        var accHeads = [];
        var transactons = [];

        // JSONasParams = $.param($ledgers);
        // window.open("{{ asset('/public/exportcsv.php')}}?data=1&"+JSONasParams,"_blank");


        var divPanel = $(".panel");

        divPanel.each(function () {

            accHeads.push($(this).find('span#head').text());
            var tbody = $(this).find('table tbody');
 
            tbody.find('tr').each(function () {
            console.log($(this).find('td').eq(1).text());
            accHeads[$(this).find('span#head').text()] = $(this).find('td').eq(1).text();
          //  console.log(item.eq(1).text());
            //console.log(item.eq(2).text());
            // accHeads[$(this).find('span#head').text()] = rows[0].text();
           //  var w = $(this).find('span#head').text();
            console.log(accHeads);
            });
           return false;
        });


            // Temporary delimiter characters unlikely to be typed by keyboard
            // This is to avoid accidentally splitting the actual contents
//             tmpColDelim = String.fromCharCode(11); // vertical tab character
//             tmpRowDelim = String.fromCharCode(0); // null character

//             // actual delimiter characters for CSV format
//             colDelim = '","';
//             rowDelim = '"\r\n"';

//             // Grab text from table into CSV formatted string
//             csv = '"' + $rows.map(function (i, row) {
//                 var $row = $(row);
//                     $cols = $row.find('td');

//                 return $cols.map(function (j, col) {
//                     var $col = $(col);
//                         text = $col.text();

                       

//                     return text.replace(/"/g, '""'); // escape double quotes

//                 }).get().join(tmpColDelim);

//             }).get().join(tmpRowDelim)
//                 .split(tmpRowDelim).join(rowDelim)
//                 .split(tmpColDelim).join(colDelim) + '"';

// console.log(window.Blob && window.URL);
//                 // Deliberate 'false', see comment below
//         if (false && window.navigator.msSaveBlob) {

//                         var blob = new Blob([decodeURIComponent(csv)], {
//                   type: 'text/csv;charset=utf8'
//             });
            
//             // Crashes in IE 10, IE 11 and Microsoft Edge
//             // See MS Edge Issue #10396033: https://goo.gl/AEiSjJ
//             // Hence, the deliberate 'false'
//             // This is here just for completeness
//             // Remove the 'false' at your own risk
//             window.navigator.msSaveBlob(blob, filename);
            
//         } else if (window.Blob && window.URL) {
//                         // HTML5 Blob 
                       
                   
//             var blob = new Blob([csv], { type: 'text/csv;charset=utf8' });
//             var csvUrl = URL.createObjectURL(blob);


//             $(this)
//                     .attr({
//                         'download': filename,
//                         'href': csvUrl
//                     });
//                 } else {
//             // Data URI
//             var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

//                         $(this)
//                 .attr({
//                       'download': filename,
//                     'href': csvData,
//                     'target': '_blank'
//                     });
//         }
    }

    // This must be a hyperlink
    $(".exportcsv").on('click', function (event) {
        event.preventDefault();
        // CSV
        var args = [$('#example2'), 'export.csv'];
        
        exportTableToCSV.apply(this, args);
        
        // If CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });



       
$("#btnPrint").click(function(){

var mode = 'iframe';
var close = mode == "popup";
var options = {mode:mode,popClose:close};

$('div#printInv').printArea(options);

});
   

      

</script>
             