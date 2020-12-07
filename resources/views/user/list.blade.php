@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="box">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ ucwords(trans_choice('messages.user_table', 1)) }}</h3>
                <div class="card-options">
                    <div class="btn-group ml-5 mb-0">
                        <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-plus"></i> {{ ucwords(__('messages.options')) }}</button>
                        <div class="dropdown-menu">
                            @if(Auth::user()->userLevel->id === 4)
                            <a class="dropdown-item" href="{{route('user.create')}}"><i class="fa fa-plus mr-2"></i>{{ ucwords(__('messages.new_user')) }}</a>
                            @endif

                            <a class="dropdown-item" href="{{route('invite')}}" >{{ ucwords(trans_choice('messages.invite', 2)) }}</a>

                            {{-- <a class="dropdown-item" href="#"><i class="fa fa-edit mr-2"></i>Edit Page</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-eye mr-2"></i>View all new tab</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"><i class="fa fa-cog mr-2"></i> Settings</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <i class="fab fa-product-hunt fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
                <div class="float-right">
                    {{-- <a type="submit" class="btn btn-success">{{ ucwords(__('messages.new_customer')) }}</a> --}}
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="example" class="table table-bordered text-nowrap key-buttons">
                            <thead>
                                <th>{{ ucwords(trans_choice('messages.email', 2)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.first_name', 2)) }}</th>
                                <th class="text-center">{{ ucwords(trans_choice('messages.last_name', 1)) }}</th>
                                <th class="text-center">{{ ucwords(trans_choice('messages.owner', 1)) }}</th>
                                <th class="text-center">{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                                <th class="text-center">{{ ucwords(trans_choice('messages.action', 2)) }}</th>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td style="width: 1px; white-space: nowrap;">
                                        {{$user['email']}}
                                    </td>
                                    <td style="width: 1px; white-space: nowrap;">
                                        {{$user['first_name']}}
                                    </td>
                                    <td class="text-center">
                                        {{$user['last_name']}}
                                    </td>
                                    <td class="text-center">
                                        {{$user['provider']['company_name'] }}
                                        {{$user['reseller']['company_name'] }}
                                        {{$user['customer']['company_name'] }}
                                    </td>
                                    <td class="text-center">
                                        {{-- @dd($user->status->name); --}}
                                        {{ ucwords(trans_choice($user->status->name,1)) }}
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
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
