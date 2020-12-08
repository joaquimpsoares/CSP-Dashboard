
@section('css')
<!-- Notifications  Css -->
<link href="{{URL::asset('assets/plugins/notify/css/jquery.growl.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet" />
@endsection
@section('content')



<div>
@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session()->has('danger'))
    <div class="alert alert-danger">
        {{ session('danger') }}
    </div>
    @endif
</div>

@endsection
@section('js')
<!-- popover js -->
<script src="{{URL::asset('assets/js/popover.js')}}"></script>
<!-- Notifications js -->
<script src="{{URL::asset('assets/plugins/notify/js/rainbow.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/sample.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/jquery.growl.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
@endsection
