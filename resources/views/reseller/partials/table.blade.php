<div x-data="{ resellerOpen: false , isOpen: false }" class="relative z-0 flex-col flex-1 overflow-y-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ ucwords(trans_choice('messages.reseller_table', 2)) }}</h3>
            <div class="card-options">
                <div class="mb-0 ml-5 btn-group">
                    <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-plus"></i> {{ ucwords(__('messages.options')) }}</button>
                    <div class="dropdown-menu">
                        @if(Auth::user()->userLevel->id === 3)
                        <a class="dropdown-item" href="{{route('reseller.create')}}"><i class="mr-2 fa fa-plus"></i>{{ ucwords(__('messages.new_reseller')) }}</a>
                        @endif
                        {{-- <a class="dropdown-item" href="#"><i class="mr-2 fa fa-eye"></i>View all new tab</a>
                        <a class="dropdown-item" href="#"><i class="mr-2 fa fa-edit"></i>Edit Page</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="mr-2 fa fa-cog"></i> Settings</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered key-buttons">
                        <thead>
                            <tr>
                                <th>{{ ucwords(trans_choice('messages.#', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.customer', 2)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.provider', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.country', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.mpn', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.created_at', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resellers as $reseller)
                            <tr class="odd gradeX">
                                <td width="3%" class="f-s-600"><a href="{{ $reseller['path'] }}">{{ $reseller['id'] }}</a></td>
                                <td><a href="{{ $reseller['path'] }}">{{ $reseller['company_name'] }}</a></td>
                                <td>{{ $reseller['customers'] }}</td>
                                <td><a href="{{$reseller['provider']->format()['path']}}">{{ $reseller['provider']['company_name'] }}</a></td>
                                <td>{{ $reseller['country'] }}</td>
                                <td>{{ $reseller['mpnid'] }}</td>
                                <td>{{ $reseller['created_at'] }}</td>
                                <td style="width: 150px">
                                    <div class="row text-nowrap">
                                        <div class="align-top btn-group">
                                            @if(Auth::user()->can('edit'))
                                            {{-- <a href="{{$reseller['path']}}/edit" class="btn btn-sm btn-white btn-svg">{{ ucwords(trans_choice('messages.edit', 1)) }} </a> --}}
                                            <a @click="resellerOpen = !resellerOpen" wire.model class="btn btn-sm btn-white btn-svg">{{ ucwords(trans_choice('messages.edit', 1)) }} </a>
                                            @endif
                                            @canImpersonate
                                            @if(!empty($reseller['mainUser']))
                                            <a class="btn btn-sm btn-white btn-svg" href="{{ route('impersonate', $reseller['mainUser']->id) }}"><i class="fa fa-user-secret text-muted"></i></a>
                                            @endif
                                            @endCanImpersonate
                                        </div>
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
    {{-- </div> --}}
    <div x-cloak :class="resellerOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'" class="fixed top-0 right-0 z-40 w-screen h-full max-w-2xl px-6 py-4 transition duration-300 transform bg-white border-l-2 border-gray-300">
        <div class="absolute inset-0 overflow-hidden">
            <div x-description="Background overlay, show/hide based on slide-over state." class="absolute inset-0" @click="resellerOpen = !resellerOpen" aria-hidden="true"></div>
            <div class="fixed inset-y-0 right-0 flex pl-10 sm:pl-16">
                <div x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-2xl" x-description="Slide-over panel, show/hide based on slide-over state.">
                    <div class="flex flex-col h-full py-6 overflow-y-scroll bg-white shadow-xl">
                        <div class="px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                    Panel title
                                </h2>
                                <div class="flex items-center ml-3 h-7">
                                    <button class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="resellerOpen = !resellerOpen">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="w-6 h-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="relative flex-1 px-4 mt-6 sm:px-6">
                            {{-- @livewire('reseller.edit-reseller', ['reseller' => $reseller]) --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
