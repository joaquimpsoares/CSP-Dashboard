<div>
    <nav aria-label="Sections" class="flex-shrink-0 hidden bg-white border-r w-96 border-blue-gray-200 xl:flex xl:flex-col">
        <div class="flex items-center flex-shrink-0 h-16 px-6 border-b border-blue-gray-200">
            <p class="text-lg font-medium text-blue-gray-900">Settings</p>
        </div>
        <div class="flex-1 min-h-0 overflow-y-auto">

            <a href="{{route('user.edit',$user->id)}}" class="@if(Request::path() == 'user/'.$user->id.'/edit') bg-indigo-50 @endif flex p-6 bg-opacity-50 border-b  border-blue-gray-200" aria-current="page" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-blue-50 bg-opacity-50&quot;, Default: &quot;hover:bg-blue-50 hover:bg-opacity-50&quot;">
                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400" x-description="Heroicon name: outline/cog" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <div class="ml-3 text-sm">
                    <p class="font-medium text-blue-gray-900">{{ucwords(trans_choice('messages.user_profile', 1))}}</p>
                    <p class="mt-1 text-blue-gray-500">Ullamcorper id at suspendisse nec id volutpat vestibulum enim. Interdum blandit.</p>
                </div>
            </a>

            <a href="{{route('profile.showprofile',$user->id)}}" class="@if(Request::path() == 'profile/'.$user->id.'/show-profile') bg-indigo-50 @endif flex p-6 bg-opacity-50 border-b  border-blue-gray-200" aria-current="page" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-blue-50 bg-opacity-50&quot;, Default: &quot;hover:bg-blue-50 hover:bg-opacity-50&quot;">
                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400" x-description="Heroicon name: outline/cog" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <div class="ml-3 text-sm">
                    <p class="font-medium text-blue-gray-900">{{ucwords(trans_choice('messages.account', 1))}}</p>
                    <p class="mt-1 text-blue-gray-500">Ullamcorper id at suspendisse nec id volutpat vestibulum enim. Interdum blandit.</p>
                </div>
            </a>

            <a href="{{route('user.notifications',$user->id)}}" class="@if(Request::path() == 'user/'.$user->id.'/notifications') bg-indigo-50 @endif flex p-6 border-b hover:bg-blue-50 hover:bg-opacity-50 border-blue-gray-200" x-state-description="undefined: &quot;bg-blue-50 bg-opacity-50&quot;, undefined: &quot;hover:bg-blue-50 hover:bg-opacity-50&quot;">
                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400" x-description="Heroicon name: outline/bell" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <div class="ml-3 text-sm">
                    <p class="font-medium text-blue-gray-900">{{ucwords(trans_choice('messages.notifications', 1))}}</p>
                    <p class="mt-1 text-blue-gray-500">Enim, nullam mi vel et libero urna lectus enim. Et sed in maecenas tellus.</p>
                </div>
            </a>

            <a href="#" class="flex p-6 border-b hover:bg-blue-50 hover:bg-opacity-50 border-blue-gray-200" x-state-description="undefined: &quot;bg-blue-50 bg-opacity-50&quot;, undefined: &quot;hover:bg-blue-50 hover:bg-opacity-50&quot;">
                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400" x-description="Heroicon name: outline/key" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
                <div class="ml-3 text-sm">
                    <p class="font-medium text-blue-gray-900">{{ucwords(trans_choice('messages.security', 1))}}</p>
                    <p class="mt-1 text-blue-gray-500">Semper accumsan massa vel volutpat massa. Non turpis ut nulla aliquet turpis.</p>
                </div>
            </a>

            <a href="#" class="flex p-6 border-b hover:bg-blue-50 hover:bg-opacity-50 border-blue-gray-200" x-state-description="undefined: &quot;bg-blue-50 bg-opacity-50&quot;, undefined: &quot;hover:bg-blue-50 hover:bg-opacity-50&quot;">
                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400" x-description="Heroicon name: outline/photograph" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <div class="ml-3 text-sm">
                    <p class="font-medium text-blue-gray-900">Appearance</p>
                    <p class="mt-1 text-blue-gray-500">Magna nulla id sed ornare ipsum eget. Massa eget porttitor suscipit consequat.</p>
                </div>
            </a>

            <a href="{{route('invoices.index')}}" class="@if(Request::path() == 'invoices/index') bg-indigo-50 @endif flex p-6 border-b hover:bg-blue-50 hover:bg-opacity-50 border-blue-gray-200" x-state-description="undefined: &quot;bg-blue-50 bg-opacity-50&quot;, undefined: &quot;hover:bg-blue-50 hover:bg-opacity-50&quot;">
                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400" x-description="Heroicon name: outline/cash" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <div class="ml-3 text-sm">
                    <p class="font-medium text-blue-gray-900">Billing</p>
                    <p class="mt-1 text-blue-gray-500">Orci aliquam arcu egestas turpis cursus. Lectus faucibus netus dui auctor mauris.</p>
                </div>
            </a>

            <a href="{{route('instances.index')}}" class="@if(Request::path() == 'instances') bg-indigo-50 @endif flex p-6 border-b hover:bg-blue-50 hover:bg-opacity-50 border-blue-gray-200" x-state-description="undefined: &quot;bg-blue-50 bg-opacity-50&quot;, undefined: &quot;hover:bg-blue-50 hover:bg-opacity-50&quot;">
                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400" x-description="Heroicon name: outline/view-grid-add" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                </svg>
                <div class="ml-3 text-sm">
                    <p class="font-medium text-blue-gray-900">{{ucwords(trans_choice('messages.integrations', 1))}}</p>
                    <p class="mt-1 text-blue-gray-500">Nisi, elit volutpat odio urna quis arcu faucibus dui. Mauris adipiscing pellentesque.</p>
                </div>
            </a>

            <a href="#" class="flex p-6 border-b hover:bg-blue-50 hover:bg-opacity-50 border-blue-gray-200" x-state-description="undefined: &quot;bg-blue-50 bg-opacity-50&quot;, undefined: &quot;hover:bg-blue-50 hover:bg-opacity-50&quot;">
                <svg class="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400" x-description="Heroicon name: outline/search-circle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-3 text-sm">
                    <p class="font-medium text-blue-gray-900">Additional Resources</p>
                    <p class="mt-1 text-blue-gray-500">Quis viverra netus donec ut auctor fringilla facilisis. Nunc sit donec cursus sit quis et.</p>
                </div>
            </a>

        </div>
    </nav>
</div>
