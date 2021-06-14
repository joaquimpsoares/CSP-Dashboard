@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
{{-- <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet"> --}}
@endsection
@section('content')
@livewire('job.job-table')
{{--
<div class="pl-4 mb-6 border-l-4 border-blue-600">
    <form action="" method="get">
        <div class="flex items-center my-2">
            <input type="checkbox" name="only_failed" id="only-failed" @if($filters['onlyFailed']) checked @endif>
            <label for="only-failed" class="ml-2 text-sm text-gray-900">
                Only show failed jobs
            </label>
        </div>
        <div>
            <button type="submit" class="btn btn-secondary">
                Filter
            </button>
        </div>
    </form>
</div>
<div class="overflow-hidden card">
    <div class="card-header">
        <h3 class="card-title">{{ ucwords(trans_choice('messages.queue_monitor', 1)) }}</h3>
    </div>
    <div class="card-body">
        <table id="example" class="table table-bordered text-nowrap key-buttons">
            <thead class="bg-gray-100">
                <tr>
                    <th class="">ids</th>
                    <th class="">Status</th>
                    <th class="">Job</th>
                    <th class="">Details</th>
                    @if(config('queue-monitor.ui.show_custom_data'))
                    <th class="">Custom Data</th>
                    @endif
                    <th class="">Progress</th>
                    <th class="">Duration</th>
                    <th class="">Started</th>
                    <th class="">Error</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($jobs as $job)
                <tr class="leading-relaxed font-sm">
                    <td>{{$job->id}}</td>
                    <td class="">
                        @if(!$job->isFinished())
                        <div class="">
                        </div>
                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 md:mt-2 lg:mt-0">
                            <span>Running</span>
                        </div>
                        @elseif($job->hasSucceeded())
                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                            <span>Success</span>
                        </div>
                        @else
                        <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 md:mt-2 lg:mt-0">
                            <span>Failed</span>
                        </div>
                        @endif
                    </td>
                    <td class="p-4 text-sm font-medium leading-5 text-gray-800 border-b border-gray-200">
                        {{ $job->getBaseName() }}
                        <span class="ml-1 text-xs text-gray-600">
                            #{{ $job->job_id }}
                        </span>
                    </td>
                    <td class="p-4 text-sm leading-5 text-gray-800 border-b border-gray-200">
                        <div class="text-xs">
                            <span class="font-medium text-gray-600">Queue:</span>
                            <span class="font-semibold">{{ $job->queue }}</span>
                        </div>
                        <div class="text-xs">
                            <span class="font-medium text-gray-600">Attempt:</span>
                            <span class="font-semibold">{{ $job->attempt }}</span>
                        </div>
                    </td>
                    @if(config('queue-monitor.ui.show_custom_data'))
                    <td class="p-4 text-sm leading-5 text-gray-800 border-b border-gray-200">
                        <textarea rows="4"
                        class="w-64 p-1 text-xs border rounded"
                        readonly>{{ json_encode($job->getData(), JSON_PRETTY_PRINT) }}
                    </textarea>
                </td>
                @endif
                <td class="p-4 text-sm leading-5 text-gray-800 border-b border-gray-200">
                    @if($job->progress !== null)
                    <div class="w-32">
                        <div class="mb-3 progress progress-md">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style={{"width:".$job->progress.'%'}}></div>
                        </div>
                        <div class="flex justify-center mt-1 text-xs font-semibold text-gray-800">
                            {{ $job->progress }}%
                        </div>
                    </div>
                    @else
                    -
                    @endif
                </td>
                <td class="p-4 text-sm leading-5 text-gray-800 border-b border-gray-200">
                    {{ sprintf('%02.2f', (float) $job->time_elapsed) }} s
                </td>
                <td class="p-4 text-sm leading-5 text-gray-800 border-b border-gray-200">
                    {{ $job->started_at }}
                    {{ $job->started_at->diffForHumans() }}
                </td>
                <td class="p-4 text-sm leading-5 text-gray-800 border-b border-gray-200">
                    @if($job->hasFailed() && $job->exception_message !== null)
                    <button type="button" class="mr-2 btn btn-info" data-container="body" data-toggle="popover" data-popover-color="popinfo" data-placement="top" title="alert error" data-content="{{ $job->exception_message }}">
                        Show Error
                    </button>
                    <a type="button" class="btn btn-secondary" href="/jobs/retry/{{$job->job_id}}">retry job</a>
                    @else
                    -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100" class="">
                    <div class="my-6">
                        <div class="text-center">
                            <div class="text-lg text-gray-500">
                                No Jobs
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <table id="example" class="table table-striped table-bordered" id="customers">
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
            <tr>
                <td><a href="·">{{ $failedJob->id }}</a></td>
                <td>{{ $failedJob->queue }}</td>
                <td style="width: 15px">{{ Str::limit($failedJob->payload, 100, $end='[...]')  }}</td>
                <td style="width: 15px">{{ Str::limit($failedJob->exception, 100, $end='[...]') }}</td>
                <td ><div class="col-2">
                        <a href="{{route('jobs.retry', $failedJob->id)}}">
                            <i class="fas fa-redo-alt text-primary }}"></i>
                        </a>
                    </div>
                    <div class="col-2">
                        <a href="{{route('jobs.destroy', $failedJob->id)}}">
                            <i class="fas fa-trash-alt text-primary }}"></i>
                        </a>
                    </div></td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Empty</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div> --}}
@endsection

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
