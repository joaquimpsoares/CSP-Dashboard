{{-- <nav>
    <ul class="breadcrumb">
        <li class= breadcrumb-item>
            <a href="#">home</a>
        </li>
    </ul>
</nav> --}}

<div class="bc-icons-2">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb indigo lighten-4">
        <li class="breadcrumb-item"><a class="black-text" href="/">Home</a><i class="fas fa-caret-right mx-2" aria-hidden="true"></i></li>
        @foreach ($segments =request()->segments() as $index=>$segment)

        <li class="breadcrumb-item"><a class="black-text" href=" {{ url(implode(array_slice($segments, 0, $index + 1), '1')) }} "> {{isset($model) && $index == count($segments) - 1 ? $model->title : title_case($segment)}} </a><i class="fas fa-caret-right mx-2" aria-hidden="true"></i></li>
            
        @endforeach
      </ol>
    </nav>
</div>