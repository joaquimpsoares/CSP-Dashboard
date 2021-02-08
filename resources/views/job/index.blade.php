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

<div class="mb-6 pl-4 border-l-4 border-blue-600">
    <form action="" method="get">
        <div class="flex items-center my-2">
            <input type="checkbox" name="only_failed" id="only-failed" @if($filters['onlyFailed']) checked @endif>
            <label for="only-failed" class="text-sm ml-2 text-gray-900">
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
<div class="card overflow-hidden">
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
                <tr class="font-sm leading-relaxed">
                    <td>{{$job->id}}</td>
                    <td class="">
                        @if(!$job->isFinished())
                        <div class="">
                            <span class="badge badge-info mt-2">Running</span>
                        </div>
                        @elseif($job->hasSucceeded())
                        <div class="inline-flex flex-1 px-2 text-xs font-medium leading-5 rounded-full bg-green-200 text-green-800">
                            <span class="badge badge-success mt-2">Success</span>
                        </div>
                        @else
                        <div class="inline-flex flex-1 px-2 text-xs font-medium leading-5 rounded-full bg-red-200 text-red-800">
                            <span class="badge badge-danger mt-2">Failed</span>
                        </div>
                        @endif
                    </td>
                    <td class="p-4 text-gray-800 text-sm leading-5 font-medium border-b border-gray-200">
                        {{ $job->getBaseName() }}
                        <span class="ml-1 text-xs text-gray-600">
                            #{{ $job->job_id }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-800 text-sm leading-5 border-b border-gray-200">
                        <div class="text-xs">
                            <span class="text-gray-600 font-medium">Queue:</span>
                            <span class="font-semibold">{{ $job->queue }}</span>
                        </div>
                        <div class="text-xs">
                            <span class="text-gray-600 font-medium">Attempt:</span>
                            <span class="font-semibold">{{ $job->attempt }}</span>
                        </div>
                    </td>
                    @if(config('queue-monitor.ui.show_custom_data'))
                    <td class="p-4 text-gray-800 text-sm leading-5 border-b border-gray-200">
                        <textarea rows="4"
                        class="w-64 text-xs p-1 border rounded"
                        readonly>{{ json_encode($job->getData(), JSON_PRETTY_PRINT) }}
                    </textarea>
                </td>
                @endif
                <td class="p-4 text-gray-800 text-sm leading-5 border-b border-gray-200">
                    @if($job->progress !== null)
                    <div class="w-32">
                        <div class="progress progress-md mb-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style={{"width:".$job->progress.'%'}}></div>
                        </div>
                        <div class="flex justify-center mt-1 text-xs text-gray-800 font-semibold">
                            {{ $job->progress }}%
                        </div>
                    </div>
                    @else
                    -
                    @endif
                </td>
                <td class="p-4 text-gray-800 text-sm leading-5 border-b border-gray-200">
                    {{ sprintf('%02.2f', (float) $job->time_elapsed) }} s
                </td>
                <td class="p-4 text-gray-800 text-sm leading-5 border-b border-gray-200">
                    {{ $job->started_at }}
                    {{-- {{ $job->started_at->diffForHumans() }} --}}
                </td>
                <td class="p-4 text-gray-800 text-sm leading-5 border-b border-gray-200">
                    @if($job->hasFailed() && $job->exception_message !== null)
                    <button type="button" class="btn btn-info mr-2" data-container="body" data-toggle="popover" data-popover-color="popinfo" data-placement="top" title="alert error" data-content="{{ $job->exception_message }}">
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
                            <div class="text-gray-500 text-lg">
                                No Jobs
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
        {{-- <tfoot class="bg-white">
            <tr>
                <td colspan="100" class="px-6 py-4 text-gray-700 font-sm border-t-2 border-gray-200">
                    <div class="flex justify-between">
                        <div>
                            Showing
                            @if($jobs->total() > 0)
                            <span class="font-medium">{{ $jobs->firstItem() }}</span> to
                            <span class="font-medium">{{ $jobs->lastItem() }}</span> of
                            @endif
                            <span class="font-medium">{{ $jobs->total() }}</span> result
                        </div>
                        <div>
                            <a class="py-2 px-4 mx-1 text-xs font-medium @if(!$jobs->onFirstPage()) bg-gray-200 hover:bg-gray-300 cursor-pointer @else text-gray-600 bg-gray-100 cursor-not-allowed @endif rounded"
                                @if(!$jobs->onFirstPage()) href="{{ $jobs->previousPageUrl() }}" @endif>
                                Previous
                            </a>
                            <a class="py-2 px-4 mx-1 text-xs font-medium @if($jobs->hasMorePages()) bg-gray-200 hover:bg-gray-300 cursor-pointer @else text-gray-600 bg-gray-100 cursor-not-allowed @endif rounded"
                                @if($jobs->hasMorePages()) href="{{ $jobs->url($jobs->currentPage() + 1) }}" @endif>
                                Next
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        </tfoot> --}}
    </table>
</div>
</div>
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
