<div>
    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.active_task', 2)) }}</a></h4>
    <section class="dark-grey-text">
        <div class="table-responsive">
            <table id="example" class="table table-bordered text-nowrap key-buttons">
                <thead class="thead-dark">
                    <tr>
                        <th>{{ ucwords(trans_choice('messages.id', 2)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.queue_name', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.customer', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.tenant', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.attempts', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.started_at', 1)) }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                    <tr>
                        <td><a href="#">{{ $job->id }}</a></td>
                        <td>{{ $job->queue }}</td>
                        @if (!empty($order[$job->id]->customer->company_name) )
                        <td>{{ $order[$job->id]->customer->company_name}}</td>
                        <td>{{ $order[$job->id]->domain}}</td>
                        @elseif(empty($order[$job->id]->customer->company_name) )
                        <td></td>
                        <td></td>
                        @endif
                        <td>{{ $job->attempts }}</td>
                        <td>{{ date('d-M-Y', strtotime($job->available_at)) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Empty</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>


@section('js')
<!-- Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables.js')}}"></script>
<!-- Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection
