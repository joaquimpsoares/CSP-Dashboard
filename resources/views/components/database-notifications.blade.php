@auth
<div x-data="{ dropdownOpen: false }" class="inline-block">
    <button @click="dropdownOpen = !dropdownOpen" class="p-2 bg-white rounded-md relativeblock focus:outline-none">
        <span class="text-base tracking-tighter">
            <x-icon.bell class="-mr-1 align-text-top origin-top animate-swing"/>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <sup>{{ auth()->user()->unreadNotifications->count() }}</sup>
            @endif
        </span>
    </button>
    <div x-cloak x-show="dropdownOpen" class="absolute right-0 z-20 mt-2 overflow-hidden bg-white rounded-md shadow-lg" style="width:20rem;">
        @foreach (auth()->user()->notifications->take(5) as $notification)
        <div class="py-2 border-b">
            <a href="#" class="flex items-center px-4 py-3 -mx-2 hover:bg-gray-100">
                <p class="mx-2 text-sm text-gray-600">
                    <span class="font-bold" href="#">
                        {{$notification->data['data']}}
                    </span>
                </p>
                <p class="mx-2 text-sm text-gray-600">
                    <small>{{$notification->created_at}} ago</small>
                </p>
            </a>
        </div>
        @endforeach
        <h6 class="dropdown-header">
            @if (auth()->user()->unreadNotifications->count())
            <a class="text-primary" href="{{ route('databasenotifications.markasread') }}">Mark All as Read</a>
            @endif
        </h6>
        <a href="#" class="block py-2 font-bold text-center text-white bg-gray-800">See all notifications</a>
    </div>
</div>

@endauth
