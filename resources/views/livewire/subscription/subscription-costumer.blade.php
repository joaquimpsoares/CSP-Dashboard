{{-- 

<body class="relative antialiased bg-gray-100"> --}}
    
    <!-- Start Main -->
    {{-- <main class="container py-4 mx-auto mx-w-6xl"> --}}
        <div class="flex flex-col space-y-8 ">
            <div class="mx-auto lg:w-auto">
                <div id="carouselExampleCrossfade" class="relative carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="absolute bottom-0 left-0 right-0 flex justify-center p-0 mb-4 carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="relative w-full overflow-hidden carousel-inner rounded-2xl">
                        <div class="float-left w-full carousel-item active">
                            <img src="https://mdbcdn.b-cdn.net/img/new/slides/041.webp" class="block w-full h-96" alt="Wild Landscape"/>
                        </div>
                        <div class="float-left w-full carousel-item">
                            <img src="https://mdbcdn.b-cdn.net/img/new/slides/042.webp" class="block w-full h-96" alt="Camera"/>
                        </div>
                        <div class="float-left w-full carousel-item">
                            <img src="https://mdbcdn.b-cdn.net/img/new/slides/043.webp" class="block w-full h-96" alt="Exotic Fruits"/>
                        </div>
                    </div>
                    <button class="absolute top-0 bottom-0 left-0 flex items-center justify-center p-0 text-center border-0 carousel-control-prev hover:outline-none hover:no-underline focus:outline-none focus:no-underlinen type="buttonn data-bs-target="#carouselExampleCrossfaden data-bs-slide="prev">
                        <span class="inline-block bg-no-repeat carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="absolute top-0 bottom-0 right-0 flex items-center justify-center p-0 text-center border-0 carousel-control-next hover:outline-none hover:no-underline focus:outline-none focus:no-underline" type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide="next">
                        <span class="inline-block bg-no-repeat carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>        
            </div>
            
            <!-- First Row -->
            <div class="grid grid-cols-1 px-4 md:grid-cols-4 xl:grid-cols-5 xl:p-0 gap-y-4 md:gap-6">
                <div class="p-6 bg-white border md:col-span-2 xl:col-span-3 rounded-2xl border-gray-50">
                    <div class="flex flex-col space-y-6 md:h-full md:justify-between">
                        <div class="flex justify-between">
                            <span class="text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                Main Account
                            </span>
                            <span class="text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                Available Funds
                            </span>
                        </div>
                        <div class="flex items-center justify-between gap-2 md:gap-4">
                            <div class="flex flex-col space-y-4">
                                <h2 class="font-bold leading-tight tracking-widest text-gray-800">
                                    {{$subscriptions->first()->name}}
                                </h2>
                                <div class="flex items-center gap-4">
                                    <p class="text-lg tracking-wider text-gray-600">**** **** *321</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-lg font-black tracking-wider text-gray-700 md:text-xl xl:text-3xl">
                                <span class="md:text-xl">$</span>
                                92,817.45
                            </h2>
                        </div>
                        <div class="flex gap-2 md:gap-4">
                            <a href="#" class="w-full px-5 py-3 text-xs font-semibold tracking-wider text-center text-white bg-blue-600 rounded-lg md:w-auto hover:bg-blue-800">
                                Transfer Money
                            </a>
                            <a href="#" class="w-full px-5 py-3 text-xs font-semibold tracking-wider text-center text-blue-600 rounded-lg bg-blue-50 md:w-auto hover:bg-blue-600 hover:text-white">
                                Link Account
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-between col-span-2 p-6 rounded-2xl bg-gradient-to-r from-blue-500 to-blue-800">
                    <div class="flex flex-col">
                        <p class="font-bold text-white">Lorem ipsum dolor sit amet</p>
                        <p class="max-w-sm mt-1 text-xs font-light leading-tight md:text-sm text-gray-50">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio soluta saepe consequuntur
                            facilis ab a. Molestiae ad saepe assumenda praesentium rem dolore? Exercitationem, neque
                            obcaecati?
                        </p>
                    </div>
                    <div class="flex items-end justify-between">
                        <a href="#"
                        class="px-4 py-3 text-xs font-semibold tracking-wider text-white bg-blue-800 rounded-lg hover:bg-blue-600 hover:text-white">
                        Learn More
                    </a>
                    <img src="http://img-prod-cms-rt-microsoft-com.akamaized.net/cms/api/am/imageFileData/RWOalS?ver=cc6e" alt="calendar" class="object-cover w-auto h-24">
                </div>
            </div>
        </div>
        <!-- End First Row -->
        <!-- End Third Row -->
        {{-- <div class="grid max-w-lg gap-5 mx-auto mt-12 lg:grid-cols-3 lg:max-w-none">
            @foreach ($news as $new)
            <div class="flex flex-col justify-between col-span-2 p-6 rounded-2xl bg-gradient-to-r from-blue-500 to-blue-800">
                <div class="flex flex-col">
                    <p class="font-bold text-white">{{$new->title}}</p>
                    <p class="max-w-sm mt-1 text-xs font-light leading-tight md:text-sm text-gray-50">
                        {!! \Illuminate\Support\Str::limit(\Michelf\Markdown::defaultTransform($new->description), 430, $end='...') !!}  
                    </p>
                </div>
                <div class="flex items-end justify-between">
                    <a href="#" class="px-4 py-3 text-xs font-semibold tracking-wider text-white bg-blue-800 rounded-lg hover:bg-blue-600 hover:text-white">
                    Learn More
                </a>
                <img src="http://img-prod-cms-rt-microsoft-com.akamaized.net/cms/api/am/imageFileData/RWOalS?ver=cc6e" alt="calendar" class="object-cover w-auto h-24">
            </div>
        </div> --}}
            {{-- <div class="flex flex-col overflow-hidden text-sm font-bold leading-tight tracking-widest text-gray-800 rounded-lg shadow-lg">
                <div class="flex-shrink-0">
                    <img class="object-cover w-full h-48" src="{{$new->image}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 p-6 ">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-indigo-600">
                            <a href="{{route('news.view', $new->id)}}" class="hover:underline">
                                {{$new->category}}
                            </a>
                        </p>
                        <a href="{{route('news.view', $new->id)}}" class="block mt-2">
                            <p class="text-xl font-semibold text-gray-900">
                                {{$new->title}}
                            </p>
                            <p class="mt-3 text-base text-justify text-gray-500">
                                {!! \Illuminate\Support\Str::limit(\Michelf\Markdown::defaultTransform($new->description), 430, $end='...') !!}                                        </p>
                            </a>
                        </div>
                        @php
                        $user = DB::table('users')->where('id', $new->user_id)->first();
                        @endphp
                        <div class="flex items-center mt-6">
                            <div class="flex-shrink-0">
                                <a href="{{route('news.view', $new->id)}}">
                                    <span class="sr-only">Roel Aufderehar</span>
                                    <img class="w-10 h-10 rounded-full" src="{{$user->avatar}}" alt="">
                                </a>
                            </div>
                            <div class="ml-3">
                                
                                <p class="text-sm font-medium text-gray-900">
                                    <a href="#" class="hover:underline">
                                        {{$user->name}}
                                    </a>
                                </p>
                                <div class="flex space-x-1 text-sm text-gray-500">
                                    <time datetime="2020-03-16">
                                        {{$new->created_at}}
                                    </time>
                                    <span aria-hidden="true">
                                        &middot;
                                    </span>
                                    <span>
                                        6 min read
                                    </span>
                                </div>
                                <x-a href="{{ route('news.edit', $new->id) }}"  title="@lang('app.edit_customer')" >
                                    Edit
                                </x-a>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- @endforeach
            </div> --}}
        </main>
        <!-- End Main -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
        <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            
            const data = {
                labels: [
                'Food & beverages',
                'Groceries',
                'Gaming',
                'Trip & holiday',
                ],
                datasets: [{
                    label: 'Total Expenses',
                    data: [148, 150, 130, 170],
                    backgroundColor: [
                    '#3B82F6',
                    '#10B981',
                    '#6366F1',
                    '#F59E0B'
                    ]
                }]
            };
            
            const config = {
                type: 'polarArea',
                data: data,
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                    }
                }
            };
            
            const chart = new Chart(ctx, config);
        </script>
        
    </body>
    
    </html>
