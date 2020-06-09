@extends('layouts.app')


@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>


<div class="container">
    <section class="section">
        <div class="card">
            <div class="">
                <i class="fas fa-tasks fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active btn blue-gradient" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true"><span class="badge badge-pill badge-success" style="float:right;margin-bottom:-10px;">{{ $running }}</span>Active Tasks</a>
                        </li>
                        <li class="nav-item">
                            
                            <a class="nav-link btn peach-gradient" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                            aria-controls="pills-profile" aria-selected="false" ><span class="badge badge-pill badge-warning" style="float:right;margin-bottom:-10px;">{{ Auth::user()->unreadnotifications->count() }}</span>
                            {{ ucwords(trans_choice('messages.failed_task', 2)) }}</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-2 pl-1" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.active_task', 2)) }}</a></h4>
                            <table id="job" class="display responsive " width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(trans_choice('messages.id', 2)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.queue_name', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.customer', 1)) }}</th>
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
                                        <td>{{$order[$job->id]->customer->company_name}}</td>
                                        {{-- <td>{{dd($order[$job->id]->products->product)}}</td> --}}
                                        <td>{{$order[$job->id]->domain}}</td>
                                        <td>{{ $job->attempts }}</td>
                                        {{-- {{$job_date->format('Y-m-d H:i:s')}} --}}
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
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <h4 class="card-title"><a>  </a></h4>
                            <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.failed_tasks', 1)) }}</a></h4>
                            <table id="failedjob" class="display responsive " width="100%">
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
        $('#job').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>
<script type="text/javascript">
    $(document).ready( function () {
        $('#failedjob').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>
@endsection

