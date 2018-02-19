{{--  <a class="btn btn-success waves-effect" href="{{url('/getPurchaseOrderPdf')}}?end={{$end}}&start={{$start}}&vendorId={{$vendorId}}&projectId={{$projectId}}" target='_blank'>Download Purchase Orders</a>  --}}
{{--  <a class="btn btn-success waves-effect" href="{{url('/getOrderDetailPdf')}}?end={{$end}}&start={{$start}}&vendorId={{$vendorId}}&projectId={{$projectId}}" target='_blank'>Download Orders Details</a>  --}}
<table id="example"  class="table  table-striped table-hover dataTable js-exportable">
    
        <thead>
            <tr style="background: #f44336;color: #fff;">
                <th style="text-align:center">Date</th>
                <th style="text-align:center">Request Number</th>
                <th>Project</th>
                <th style="">Status</th>
                <th style="text-align:center">Action</th>
    
            </tr>
        </thead>
    <tbody>
        @foreach ($purchaseorders as $purchaseorder)
        <tr>
            <td style="text-align:center"> {{date('d/m/Y', strtotime($purchaseorder->rpDate))}} </td>
            <td style="text-align:center">{{$purchaseorder->rpNum}} </td>
            <td>{{$purchaseorder->title}} </td>
            <td >{{$purchaseorder->stname}} </td>
            <td style="text-align:center"><a href="{{ url('/getRequestPurchase') }}/{{$purchaseorder->rpId}}" ><i class="material-icons">edit</i></a>
                <a href="{{ url('/deleteRequestPurchase') }}/{{$purchaseorder->rpId}}" ><i class="material-icons">delete</i></a> </td>
        </tr>
    
        @endforeach  
    
    
    
    </tbody>
    </table>
    {{$purchaseorders->links()}}
    