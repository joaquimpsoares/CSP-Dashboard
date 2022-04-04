
<div class="flex flex-col space-y-8 ">
    <!-- First Row -->
    <div class="grid grid-cols-1 px-4 mt-3 md:grid-cols-4 xl:grid-cols-5 xl:p-0 gap-y-4 md:gap-6">
        <div class="md:col-span-2 xl:col-span-3 rounded-2xl bg-gradient-to-r from-blue-500 to-blue-800">
            <div id="carouselExampleCrossfade" class="relative carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="absolute bottom-0 left-0 right-0 flex justify-center p-0 mb-4 carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCrossfade" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="relative w-full overflow-hidden carousel-inner rounded-2xl">
                    <div class="float-left w-full carousel-item active">
                        <img src="{{URL::asset('/images/nce.png')}}" class="block w-full h-96" alt="Wild Landscape"/>
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
            {{-- </div> --}}
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

<!-- End Main -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>