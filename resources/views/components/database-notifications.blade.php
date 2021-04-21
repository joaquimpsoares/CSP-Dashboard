@auth
<div class="btn-group">
    {{-- <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-2 mr-4 text-gray-500 rounded-full cursor-pointer nav-link hover:text-blue-600 hover:bg-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
            <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
        </svg>
    </a> --}}
    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-2 mr-4 text-gray-500 rounded-full cursor-pointer nav-link hover:text-blue-600 hover:bg-gray-200">
        @if (auth()->user()->unreadNotifications->count())
        <span class="sr-only">Notifications</span>
        <span class="absolute top-0 right-0 w-2 h-2 mt-1 mr-5 bg-red-500 rounded-full"></span>
        <span class="absolute top-0 right-0 w-2 h-2 mt-1 mr-5 bg-red-500 rounded-full animate-ping"></span>
        @endif
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
            <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
        </svg>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <!-- Dropdown header -->
        <h6 class="dropdown-header">
            You have <strong class="text-primary">{{auth()->user()->unreadNotifications->count()}}</strong> notifications.
            @if (auth()->user()->unreadNotifications->count())
            <a class="text-primary" href="{{ route('databasenotifications.markasread') }}">Mark All as Read</a>
            @endif
        </h6>
        <!-- List group -->
        <div class="list-group list-group-flush">
            @foreach (auth()->user()->notifications as $notification)
            <a href="#" class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-right text-muted">
                        <small>
                            @if (is_null($notification->read_at))
                            <i class="fa fa-check text-primary" aria-hidden="true"></i>
                            @else
                            <i class="fa fa-check text-danger" aria-hidden="true"></i>
                            @endif
                        </small>
                        <small>{{$notification->created_at}} ago</small>
                    </div>
                </div>
                <p class="mb-0 text-sm">{{$notification->data['data']}}</p>
            </a>
            @endforeach
        </div>
        <!-- View all -->
        <!-- <div class="dropdown-divider"></div>
            <a href="#!" class="text-center dropdown-item text-primary">View all</a> -->
        </div>
    </div>
    @endauth
