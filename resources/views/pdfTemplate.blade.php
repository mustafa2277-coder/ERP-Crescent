
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        body {
            background: black;
            color: #fff;;
        }
    </style>
</head>
<body>

        <table id="example"  class="table  table-striped table-hover dataTable js-exportable">
                <thead>
                    <tr style="background: #f44336;color: #fff;">
                        <th style="text-align:center">DATE</th>
                        <th style="text-align:center">NUMBER</th>
                        <th>PROJECT</th>
                        <th>JOURNAL</th>
                        <th style="text-align:center">AMOUNT</th>
            
                    </tr>
                </thead>
                <tfoot>
                  <tr id="total">
                    <th colspan="4" style="text-align:right">TOTAL:</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($journalentries as $journalentry)
                <tr>
                    <td style="text-align:center"> {{date('d/m/Y', strtotime($journalentry->entryDate))}} </td>
                    <td style="text-align:center">{{$journalentry->entryNum}} </td>
                    <td>{{$journalentry->project}} </td>
                    <td>{{$journalentry->journal}} </td>
                    <td style="text-align:center">{{$journalentry->amount}} </td>
                </tr>
            
                @endforeach  
            
            
            
            </tbody>
            </table>

</body>
</html>