@extends('layouts.master')
@section('css')

@endsection
@section('content')

@livewire('instance.show-instance', ['instance' => $instance, 'expiration'=> $expiration], key($instance->id))

@endsection


@section('scripts')
{{--
<script>
    //redirect to specific tab
    $(document).ready(function () {
        $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
    });
</script> --}}

@endsection

