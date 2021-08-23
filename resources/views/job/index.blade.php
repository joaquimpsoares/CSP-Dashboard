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
{{-- <div>
    <div x-data="{ resellerOpen: false , isOpen: false }" class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.queue_monitor', 2)) }}</h4>
                    </div>
                    <div class="flex items-center justify-between">

                        <div>
                            <div class="flex justify-center flex-1 lg:justify-end">
                                <!-- Search section -->
                                <div class="w-full max-w-lg lg:max-w-xs">
                                    <label for="search" class="sr-only">Search</label>
                                    <div class="relative text-gray-400 focus-within:text-gray-500">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <!-- Heroicon name: solid/search -->
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input wire:model="search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"wire:click="exportSelected()" href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                </svg>
                                {{ ucwords(trans_choice('messages.export', 1)) }}
                            </a>
                        </div>

                        <div>
                            <a  href="{{ route('customer.create') }}" class="px-2 py-2 ml-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                {{ ucwords(trans_choice('messages.create', 1)) }}
                            </a>
                        </div>
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
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

                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">ids</th>
                                        <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">Status</th>
                                        <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">Job</th>
                                        <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">Details</th>
                                        @if(config('queue-monitor.ui.show_custom_data'))
                                        <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">Custom Data</th>
                                        @endif
                                        <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">Progress</th>
                                        <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">Duration</th>
                                        <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">Started</th>
                                        <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">Error</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse($jobs as $job)
                                    <tr class="hover:bg-gray-100" >
                                        <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">{{$job->id}}</td>
                                        <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
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
                                        <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                            {{ $job->getBaseName() }}
                                            <span class="ml-1 text-xs text-gray-600">
                                                #{{ $job->job_id }}
                                            </span>
                                        </td>
                                        <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
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
                                        <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                            <textarea rows="4"
                                            class="w-64 p-1 text-xs border rounded"
                                            readonly>{{ json_encode($job->getData(), JSON_PRETTY_PRINT) }}
                                        </textarea>
                                    </td>
                                    @endif
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
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
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                        {{ sprintf('%02.2f', (float) $job->time_elapsed) }} s
                                    </td>
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                        {{ $job->started_at }}
                                        {{ $job->started_at->diffForHumans() }}
                                    </td>
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
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
                        {{-- <table id="example" class="table table-striped table-bordered" id="customers">
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
                        </table> --}}
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
