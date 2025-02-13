<div class="flex flex-col space-y-8 ">
    <div class="py-6 sm:py-24">
        <div class="ml-6 max-w-7xl">
            @php
            $hour = now()->format('H');
            $userName = Auth::user()->name;
            @endphp

            @if ($hour >= 5 && $hour < 12)
            <h1 class="mb-8 text-4xl font-bold text-gray-800">Good Morning, {{$userName}} welcome to {{ env('APP_NAME') }}!</h1>
            @elseif ($hour >= 12 && $hour < 17)
            <h1 class="mb-8 text-4xl font-bold text-gray-800">Good Afternoon, {{$userName}} welcome to {{ env('APP_NAME') }}!</h1>
            @else
            <h1 class="mb-8 text-4xl font-bold text-gray-800">Good Evening, {{$userName}} welcome to {{ env('APP_NAME') }}!</h1>
            @endif
        </div>
    </div>
</div>

<div class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="grid items-start max-w-2xl grid-cols-1 grid-rows-1 mx-auto gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
        <div class="lg:col-start-3 lg:row-end-1">
            <h2 class="sr-only">Summary</h2>
            <div class="rounded-lg shadow-sm bg-gray-50 ring-1 ring-gray-900/5">
                <dl class="flex flex-wrap">
                    <div class="flex-auto pt-6 pl-6">
                        <dt class="text-sm font-semibold leading-6 text-gray-900">Amount</dt>
                        <dd class="mt-1 text-base font-semibold leading-6 text-gray-900">$10,560.00</dd>
                    </div>
                    <div class="self-end flex-none px-6 pt-4">
                        <dt class="sr-only">Status</dt>
                        <dd class="px-2 py-1 text-xs font-medium text-green-600 rounded-md bg-green-50 ring-1 ring-inset ring-green-600/20">Paid</dd>
                    </div>
                    <div class="flex flex-none w-full px-6 pt-6 mt-6 border-t gap-x-4 border-gray-900/5">
                        <dt class="flex-none">
                            <span class="sr-only">Client</span>
                            <svg class="w-5 h-6 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" />
                            </svg>
                        </dt>
                        <dd class="text-sm font-medium leading-6 text-gray-900">Alex Curren</dd>
                    </div>
                    <div class="flex flex-none w-full px-6 mt-4 gap-x-4">
                        <dt class="flex-none">
                            <span class="sr-only">Due date</span>
                            <svg class="w-5 h-6 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M5.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H6a.75.75 0 01-.75-.75V12zM6 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H6zM7.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H8a.75.75 0 01-.75-.75V12zM8 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H8zM9.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V10zM10 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H10zM9.25 14a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V14zM12 9.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V10a.75.75 0 00-.75-.75H12zM11.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V12zM12 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H12zM13.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H14a.75.75 0 01-.75-.75V10zM14 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H14z" />
                                <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                            </svg>
                        </dt>
                        <dd class="text-sm leading-6 text-gray-500">
                            <time datetime="2023-01-31">January 31, 2023</time>
                        </dd>
                    </div>
                    <div class="flex flex-none w-full px-6 mt-4 gap-x-4">
                        <dt class="flex-none">
                            <span class="sr-only">Status</span>
                            <svg class="w-5 h-6 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M2.5 4A1.5 1.5 0 001 5.5V6h18v-.5A1.5 1.5 0 0017.5 4h-15zM19 8.5H1v6A1.5 1.5 0 002.5 16h15a1.5 1.5 0 001.5-1.5v-6zM3 13.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zm4.75-.75a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                            </svg>
                        </dt>
                        <dd class="text-sm leading-6 text-gray-500">Paid with MasterCard</dd>
                    </div>
                </dl>
                <div class="px-6 py-6 mt-6 border-t border-gray-900/5">
                    <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Download receipt <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
        </div>

        <!-- Invoice -->
        <div class="flex">
            <div class="flex flex-row items-center h-32 p-6 text-black bg-white cursor-pointer rounded-2xl" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;">
                <div class="mr-6 cursor-pointer">
                    <svg width="31" height="21" viewBox="0 0 31 21" fill="none" xmlns="http://www.w3.org/2000/svg" class="">
                        <path d="M25.5 20.5C28.3 20.2 30.5 17.9 30.5 15C30.5 12.1 28.3 9.8 25.5 9.5C25 4.4 20.7 0.5 15.5 0.5C11 0.5 7.2 3.5 5.9 7.6C2.9 8.1 0.5 10.8 0.5 14C0.5 17.4 3.1 20.2 6.5 20.5H25.5Z" stroke="black" stroke-linecap="round" stroke-linejoin="round" class=""></path>
                    </svg>
                </div>
                <div class="w-full cursor-pointer">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xl not-italic font-medium text-left" style="font-stretch: normal; line-height: normal; letter-spacing: normal;">
                            Cloud subscriptions
                        </div>
                    </div>
                    <div class="pt-2 overflow-hidden text-sm not-italic font-normal text-left" style="font-stretch: normal; line-height: normal; letter-spacing: normal; display: -webkit-box;">
                        <p data-v-8213c242="" class="p-0 m-0">
                            Maximize your Microsoft 365 investment, boost productivity, and
                            streamline management tasks with 365Simple
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex flex-row items-center h-32 p-6 text-black bg-white cursor-pointer rounded-2xl" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;">
                <div class="mr-6 cursor-pointer">
                    <svg width="31" height="21" viewBox="0 0 31 21" fill="none" xmlns="http://www.w3.org/2000/svg" class="">
                        <path d="M25.5 20.5C28.3 20.2 30.5 17.9 30.5 15C30.5 12.1 28.3 9.8 25.5 9.5C25 4.4 20.7 0.5 15.5 0.5C11 0.5 7.2 3.5 5.9 7.6C2.9 8.1 0.5 10.8 0.5 14C0.5 17.4 3.1 20.2 6.5 20.5H25.5Z" stroke="black" stroke-linecap="round" stroke-linejoin="round" class=""></path>
                    </svg>
                </div>
                <div class="w-full cursor-pointer">
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-xl not-italic font-medium text-left" style="font-stretch: normal; line-height: normal; letter-spacing: normal;">
                            Cloud subscriptions
                        </div>
                    </div>
                    <div class="pt-2 overflow-hidden text-sm not-italic font-normal text-left" style="font-stretch: normal; line-height: normal; letter-spacing: normal; display: -webkit-box;">
                        <p data-v-8213c242="" class="p-0 m-0">
                            Maximize your Microsoft 365 investment, boost productivity, and
                            streamline management tasks with 365Simple
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-start-3">

        </div>
    </div>
</div>


<!-- End Main -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
