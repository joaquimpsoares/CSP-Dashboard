<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>



<div class="level">
    <div class="level-left">
        <div class="title">Azure</div>
    </div>
</div>
<table id="azure" class="table display responsive nowrap"  width="100%">
    <thead>
        <tr>
            <th>{{ ucwords(trans_choice('messages.customer', 1)) }}</th>                      
            <th>{{ ucwords(trans_choice('messages.subscription', 1)) }}</th>
            <th>{{ ucwords(trans_choice('messages.current_cost', 1)) }}</th>
            <th>{{ ucwords(trans_choice('messages.percentage', 1)) }}</th>
            <th>{{ ucwords(trans_choice('messages.budget', 1)) }}</th>

        </tr>
    </thead>
    <tbody>
        <tr> 
            <td> CASA PRESTATIONS </td>
        <td style="width: 150px"> <a href="{{route("analytics.list")}}"> Microsoft Azure</a> </td>
            <td>${{ $costSum }}</td>
            <td><font color="green" , size="3">{{ (int)$average}}% Used</font></td>
            <td>${{ $budget }}</td>
        </tr>
    </tbody>
</table>

@section('scripts')
<script type="text/javascript">
    $(document).ready( function () {
        $('#azure').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>
@endsection