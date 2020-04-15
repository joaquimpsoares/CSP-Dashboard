@extends('layouts.app')


@section('content')

<h1>Current Tasks</h1>

<table class="table table-striped table-bordered" id="customers">
    <thead>
        <tr>
            <th>id</th>
            <th>Queue Name</th>
            <th>Payload</th>
            <th>Attemps</th>
            <th>Reserved At</th>
        </tr>
    </thead>
    <tbody>
        @forelse($jobs as $job)
        {{-- @if($customer->status->name === 'message.active') --}}
        <tr>
            <col width="13">
            <col width="80">
            <td>
                <a href="·">{{ $job->id }}</a>
            </td>
            <td>{{ $job->queue }}</td>            
            <td style="width: 15px">{{ Str::limit($job->payload, 100, $end='[...]') }}</td>
            <td>{{ $job->attempts }}</td>
            <td>{{ date('d, m , Y', strtotime($job->reserved_at))}}</td>
            {{-- <td style="width: 150px">
                @include('partials.actions', ['model' => $jo, 'modelo' => 'customer'])
            </td> --}}
        </tr>
        {{-- @endif --}}
        @empty
        <tr>
            <td colspan="5">Empty</td>
        </tr>
        @endforelse
    </tbody>
</table>

<h1>Failed Tasks</h1>

<table class="table table-striped table-bordered" id="customers">
    <thead>
        <tr>
            <th>id</th>
            <th>Queue Name</th>
            <th>Payload</th>
            <th>Exception</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($failedJobs as $failedJob)
        {{-- @if($customer->status->name === 'message.active') --}}
        <tr>
            <col width="13">
            <col width="80">
            <td>
                <a href="·">{{ $failedJob->id }}</a>
            </td>
            <td>{{ $failedJob->queue }}</td>
            <td style="width: 15px">{{ Str::limit($failedJob->payload, 100, $end='[...]')  }}</td>
            <td style="width: 15px">{{ Str::limit($failedJob->exception, 100, $end='[...]') }}</td>
            <td >
                <div class="col-2"> 
                    <a href="{{route('jobs.retry', $failedJob->id)}}">
                        <i class="fas fa-redo-alt text-primary }}"></i>		
                    </a>
                </div>

                <div class="col-2"> 
                    <a href="{{route('jobs.destroy', $failedJob->id)}}">
                        <i class="fas fa-trash-alt text-primary }}"></i>		
                    </a>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">Empty</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection


@section('scripts')
<script type="text/javascript">
    $(document).ready( function () {
        $('#customers').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>
@endsection

