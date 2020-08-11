<!--================ Bread Area =================-->
@auth
<div class="container">
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-end">
            <div class="container">
                <div class="banner_content text-left">
                    <div class="page_link">
                        <a href="{{ route('home') }}">Home</a>
                        @foreach ($segments = request()->segments() as $index => $segment)
                        @if($segment !== "home")
                        <a href=" {{ url(implode(array_slice($segments, 0, $index +1), '/')) }} ">
                            {{isset($model) && $index == count($segments) - 1 ? $model->title : title_case($segment)}}
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endauth
<!--================ Bread Area =================-->