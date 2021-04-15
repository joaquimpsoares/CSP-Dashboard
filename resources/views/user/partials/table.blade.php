@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

<div class="col-lg-12">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="md-form">
                    <div style="display: flex;">
                        <div style="flex-grow: 31;">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered text-nowrap key-buttons">
                            <thead>
                                <tr>
                                    <th>{{ ucwords(trans_choice('messages.avatar', 1)) }}</th>
                                    <th>{{ ucwords(trans_choice('messages.email', 1)) }}</th>
                                    <th>{{ ucwords(trans_choice('messages.name', 1)) }}</th>
                                    <th>{{ ucwords(trans_choice('messages.last_name', 1)) }}</th>
                                    <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                                    <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td><img src="{{$user->avatar}}" class="rounded-circle z-depth-0" alt="avatar image"  width='50' Height ='auto'></td>
                                    <td><a href="{{ route('user.edit', $user) }}">{{ $user['email'] }}</a></td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['last_name'] }}</td>
                                    <td>{{ ucwords(trans_choice($user->status->name, 1)) }}</td>
                                    <div x-cloak x-data="{ open: false }">
                                        <div class="dropdown show d-inline-block">
                                            <a class="btn btn-icon" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                <a href="{{ route('user.show', $user) }}" class="text-gray-500 dropdown-item">
                                                    <i class="mr-2 fa fa-eye"></i>
                                                    @lang('View User')
                                                </a>
                                                @canBeImpersonated($user)
                                                <a href="{{ route('impersonate', $user) }}" class="text-gray-500 dropdown-item impersonate">
                                                    <i class="mr-2 fa fa-user-secret"></i>
                                                    @lang('Impersonate')
                                                </a>
                                                @endCanBeImpersonated
                                            </div>
                                        </div>
                                        <a href="{{ route('user.edit', $user) }}" class="btn btn-icon edit" title="@lang('Edit User')" data-toggle="tooltip" data-placement="top"> <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-icon" title="@lang('Delete User')" data-toggle="tooltip" data-placement="top" @click="open = true"> <i class="fa fa-trash"></i>
                                        </a>
                                        <div x-cloak x-show="open" class="fixed z-10 items-center justify-center overflow-y-auto inset-20" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                                                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                    <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                                                        <div class="sm:flex sm:items-start">
                                                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                                                <!-- Heroicon name: outline/exclamation -->
                                                                <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                </svg>
                                                            </div>
                                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                                                    Delete account
                                                                </h3>
                                                                <div class="mt-2">
                                                                    <p class="text-sm text-gray-500">
                                                                        Are you sure you want to <strong>Delete {{$user->name}} </strong> account? All of your data will be permanently removed. This action cannot be undone.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                                                        <form action="{{ route('user.destroy', $user) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($users->total() >= 10)
                    {!! $users->render() !!}
                    @endif
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
