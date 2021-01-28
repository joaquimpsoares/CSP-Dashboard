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
                                    <td><a href="/user/{{$user->id }}">{{ $user['email'] }}</a></td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['last_name'] }}</td>
                                    <td>{{ ucwords(trans_choice($user->status->name, 1)) }}</td>
                                    <td>
                                        @include('partials.actions', ['model' => $user, 'modelo' => 'user'])
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
