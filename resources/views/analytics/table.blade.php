
<div class="level">
    <div class="level-left">
        <div class="title">Azure</div>
    </div>
</div>
<table class="table table-hover responsive" id="subscriptions">
    <thead class="thead-dark">
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

<script type="text/javascript">
    $(document).ready( function () {
        $('#azure').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>
