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
    {{-- whitespace-nowrap --}}
    <div x-cloak x-show="dropdownOpen" class="absolute right-0 z-20 mt-2 overflow-hidden bg-white rounded-md shadow-lg" style="width:20rem;">
        @foreach (auth()->user()->notifications->take(5) as $notification)
        <li class="box-border relative flex items-center justify-start px-2 py-3 m-0 font-sans text-base font-normal leading-normal tracking-normal text-left text-gray-500 align-middle bg-transparent border-t-0 border-b border-gray-200 border-solid rounded-none appearance-none cursor-pointer border-x-0 hover:bg-transparent" tabindex="-1" role="menuitem" style="outline: 0px; border-width: 0px 0px 1px; border-image: initial; text-decoration: none; min-height: 48px; list-style: outside none none;">
            <div class="flex items-center w-full">
              {{-- <div class="relative flex items-center justify-center flex-shrink-0 w-10 h-10 overflow-hidden text-lg leading-none select-none" skin="filled" color="primary">
                <img alt="Flora" src="/demo/materialize-mui-react-nextjs-admin-template/demo-1/images/avatars/4.png" class="object-cover w-full h-full text-center text-transparent" style="text-indent: 10000px;" />
              </div> --}}
              <div class="flex flex-col flex-1 mx-4 overflow-hidden">
                <p class="flex-grow flex-shrink mx-0 mt-0 mb-1 text-xs font-semibold leading-normal text-gray-500" style="list-style: outside none none;">{{$notification->data['data']}}</p>
                {{-- <p class="flex-grow flex-shrink m-0 text-sm tracking-normal truncate basis-full text-slate-500" style="line-height: 1.429;">Won the monthly best seller badge</p> --}}
              </div>
              <span class="m-0 text-xs leading-tight tracking-wide text-stone-300">{{$notification->created_at->diffForHumans()}}</span>
            </div>
            <span class="absolute z-0 overflow-hidden pointer-events-none" style="inset: 0px;"
              ><span class="absolute w-64 opacity-30" style="width: 453.29px; height: 453.29px; top: -219.645px; left: -9.6451px; transform: scale(1); animation-name: animation-1taevns; animation-duration: 550ms; animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);"><span class="block w-full h-full opacity-0" style="background-color: currentcolor; animation-name: animation-5ich1p; animation-duration: 550ms; animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);"></span></span
            ></span>
          </li>

        {{-- <div class="py-2 border-b">
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
        </div> --}}
        @endforeach
        <h6 class="dropdown-header">
            @if (auth()->user()->unreadNotifications->count())
            <a class="text-primary" href="{{ route('databasenotifications.markasread') }}">Mark All as Read</a>
            @endif
        </h6>
        <li class="relative flex items-center justify-start px-4 py-3 m-0 font-sans text-base font-normal leading-normal tracking-normal text-left text-gray-500 align-middle bg-transparent rounded-none appearance-none cursor-pointer select-none hover:bg-transparent" tabindex="-1" role="menuitem" style="outline: 0px; border-image: initial; text-decoration: none; min-height: 48px; list-style: outside none none;">
            <button class="box-border relative inline-flex items-center justify-center w-full px-5 py-2 m-0 font-sans text-sm font-medium tracking-wide text-center text-white uppercase align-middle bg-indigo-500 border-0 rounded-lg appearance-none cursor-pointer select-none hover:bg-indigo-500" tabindex="0" type="button" style="outline: 0px; text-decoration: none; min-width: 64px; transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms; line-height: 1.715; box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px; list-style: outside none none;">
            Read All Notifications<span class="absolute z-0 overflow-hidden font-medium leading-6 text-white uppercase cursor-pointer pointer-events-none" style="inset: 0px; list-style: outside none none;"
              ><span class="absolute w-64 tracking-wide uppercase opacity-30" style="width: 654.575px; height: 654.575px; top: -299.287px; left: -2.28734px; transform: scale(1); animation-name: animation-1taevns; animation-duration: 550ms; animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1); list-style: outside none none;"><span class="block w-full h-full leading-6 uppercase opacity-0" style="border-radius: 50%; background-color: currentcolor; animation-name: animation-5ich1p; animation-duration: 550ms; animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1); list-style: outside none none;"></span></span
            ></span>
          </button>
          </li>
    </div>
</div>

@endauth
