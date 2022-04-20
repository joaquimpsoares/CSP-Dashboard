@extends('layouts.master')

@section('content')

<div class=" mx-auto px-4 sm:px-6 lg:max-w-8xl lg:px-6">
    {{-- <div class="py-14"> --}}
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

            <section aria-labelledby="products-heading" class="mt-8">
                <h2 id="products-heading" class="sr-only">Products</h2>
                <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:gap-x-8  px-12">
                    @foreach ($subscriptions as $subscription)
                    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                        <div class="bg-cover bg-center h-16 p-4 flex items-center" style="background-image: url(https://mosscm.com/wp-content/uploads/2017/11/news-dallas-skyline.jpg)">
                            <p class="uppercase tracking-widest text-sm text-white bg-black py-1 px-2 rounded opacity-75 shadow-lg">{{$subscription->product->productType}}</p>
                        </div>
                        <div class="p-4 text-gray-700 flex justify-between">
                            <div>
                                <p class="text-2xl text-gray-900 font-bold">{{$subscription->name}}
                                </p>
                                <p class="text-sm text-gray-900">
                                    {{$subscription->product_id}}
                                </p>

                            </div>
                            <div class="leading-loose text-sm">
                                <div class="flex items-center">
                                    <p class="uppercase tracking-widest text-sm text-white bg-black py-1 px-2 rounded opacity-75 shadow-lg">{{ucwords(trans_choice($subscription->status->name, 1))}}</p>
                                </div>

                            </div>
                        </div>
                        <div class="flex justify-between items-center p-4 border-t border-gray-300 text-gray-600">
                            <div class="flex items-center">
                                <p><span class="text-gray-900 font-bold">Quantity</span> <span class="text-sm">{{$subscription->amount}}</span></p>
                            </div>
                            <div class="flex items-center">
                                <p><span class="text-gray-900 font-bold">term</span> <span class="text-sm">{{$subscription->term}}</span></p>
                            </div>
                            <div class="flex items-center">
                                <p><span class="text-gray-900 font-bold">Billing</span> <span class="text-sm">{{$subscription->billing_period}}</span></p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
