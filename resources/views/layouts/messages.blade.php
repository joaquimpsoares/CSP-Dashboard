

<!-- Notifications  Css -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet" />

{{-- <button onclick="not5()" class="btn btn-primary">Default</button> --}}

<div>
    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session()->has('danger'))
    <script type="text/javascript">
    
        $(document).ready(function() {
          $('#not5()');
        });
     </script>
    <div class="alert alert-danger">
        {{ session('danger') }}
    </div>
    @endif
</div>
<script>
    var data = session('danger');
</script>

<!-- popover js -->
<script src="{{URL::asset('assets/js/popover.js')}}"></script>
<!-- Notifications js -->
<script src="{{URL::asset('assets/plugins/notify/js/rainbow.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/sample.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>

