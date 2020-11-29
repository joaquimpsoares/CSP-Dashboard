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

