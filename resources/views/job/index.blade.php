@extends('layouts.app')


@section('content')

<div class="box">
    <section class="section">
        <div class="card">
            <div class="">
                <i class="fas fa-tasks fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active btn blue-gradient" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true">Active Tasks</a>
                        </li>
                        <li class="nav-item">

                            <a class="nav-link btn peach-gradient" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                            aria-controls="pills-profile" aria-selected="false" ><span class="badge badge-pill badge-primary" style="float:right;margin-bottom:-10px;">{{ Auth::user()->unreadnotifications->count() }}</span>
                            Failed Tasks</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-2 pl-1" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <h4 class="card-title"><a>Active Tasks</a></h4>
                            <table class="table table-striped table-bordered" id="customers">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(trans_choice('messages.id', 2)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.queue_name', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.payload', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.attempts', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.started_at', 1)) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jobs as $job)
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
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">Empty</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <h4 class="card-title"><a>  </a></h4>
                            <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.failed_tasks', 1)) }}</a></h4>
                            <table class="table table-striped table-bordered" id="customers">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(trans_choice('messages.id', 2)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.queue_name', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.payload', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.exception', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.action', 2)) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($failedJobs as $failedJob)
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
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

