<!--================ Bread Area =================-->
@auth
<!--Page header-->
@section('page-header')

<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{ ucwords(request()->segment(1)) }}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        @if(Route::current()->getName() != 'home')
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
            @php
            $link = url('/');
            @endphp
            @foreach(request()->segments() as $segment)
            @php
            $link .= "/" . request()->segment($loop->iteration);
            @endphp
            @if(rtrim(request()->route()->getPrefix(), '/') != $segment && ! preg_match('/[0-9]/', $segment))
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                @if($loop->last)
                {{ title_case($segment) }}
                @else
                <a href="{{ $link }}">{{ title_case($segment) }}</a>
                @endif
            </li>
            @endif
            @endforeach
        </ol>
        @endif
    </div>
</div>
@endsection
<!--End Page header-->
@endauth
<!--================ Bread Area =================-->
