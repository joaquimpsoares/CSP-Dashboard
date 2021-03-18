@extends('layouts.master')
@section('css')
<!-- Data table css -->

<!-- Slect2 css -->
{{-- <link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" /> --}}
@endsection

@section('content')
<div class="p-6 mb-10 bg-indigo-200 rounded-lg shadow">
    <div class="md:flex">
        <div class="md:w-1/2">
            <h2 class="mb-2 text-xl font-bold leading-tight text-gray-800 md:text-2xl">Welcome {{Auth::user()->name}},</h2>

            <p class="mb-4 text-gray-700">Great to have you here with us, {{Auth::user()->name}} we have setup for you this account so that you can manage your
                customers and their subscriptions, you'll find here all that you need to make your life ease.</p>
                <p class="mb-4 text-gray-700">If you have any questions, please contact us.</p>
                <p class="mb-4 text-gray-700">Thank you!</p>

                <button class="inline-flex items-center px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                    Contact us
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 text-gray-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                        <circle cx="12" cy="12" r="9" />
                        <line x1="16" y1="12" x2="8" y2="12" />
                        <line x1="16" y1="12" x2="12" y2="16" />
                        <line x1="16" y1="12" x2="12" y2="8" />
                    </svg>
                </button>
            </div>
            <div class="md:w-1/2">
                <svg class="object-cover w-64 h-48 mx-auto" id="f61e7f2c-3df8-44b9-b514-d2b672d0e0d5" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1100.99998 666.0509"><title>dev_focus</title><circle cx="633.92942" cy="214.02012" r="36.39575" fill="#2f2e41"/><path d="M693.56939,295.60077a36.40082,36.40082,0,0,1,32.03938,53.66882,36.38708,36.38708,0,1,0-60.45438-39.98247A36.306,36.306,0,0,1,693.56939,295.60077Z" transform="translate(-49.50001 -116.97455)" fill="#2f2e41"/><circle cx="565.91872" cy="107.03051" r="106.9125" fill="#2f2e41"/><path d="M531.5098,157.67094A106.89328,106.89328,0,0,1,679.677,146.461c-.87424-.83106-1.73925-1.66885-2.64768-2.47643A106.91251,106.91251,0,0,0,534.96321,303.79182c.90844.80758,1.84178,1.56849,2.76952,2.33937A106.89337,106.89337,0,0,1,531.5098,157.67094Z" transform="translate(-49.50001 -116.97455)" fill="#2f2e41"/><circle cx="565.01268" cy="144.17807" r="68.8589" fill="#ffb8b8"/><path d="M565.58663,282.89754s9.06039,83.35551-5.43622,92.41589,83.35551,21.74492,83.35551,21.74492-14.49662-90.60382,21.74491-114.16081Z" transform="translate(-49.50001 -116.97455)" fill="#ffb8b8"/><path d="M652.5663,360.81682s26.98248-12.60018-11.87783-8.11216-72.38788-12.72672-72.38788-12.72672-11.77434-11.77849-13.58641.906,5.43623,36.24153-34.42945,39.86568-76.10721-7.2483-90.60382,19.93284-7.2483,144.9661-7.2483,144.9661,27.18114,97.85213,48.92606,112.34874,212.01292-5.43623,212.01292-5.43623L737.73388,554.709V440.54818s-7.2483-39.86568-57.98644-28.99322c0,0-32.61737-7.24831-30.8053-23.557S652.5663,360.81682,652.5663,360.81682Z" transform="translate(-49.50001 -116.97455)" fill="#d0cde1"/><path d="M478.55,727.24542c1.12-4.88,1.87-7.64,1.87-7.64l-.57995-3.97-5.97-40.54-2.51-17.1c21.74-9.06,27.18-50.74,27.18-50.74l.82-.49,3.71-2.22v-.01l13.32-7.99.27-.16,5.38,3.58,10.93,7.29c38.24,28.12,77.18,27.62,101.21,23.19,14.69-2.71,23.82-6.88,23.82-6.88l26.36-8.79.82-.27.81.12,15.46,2.34.28.05,1.28.19-3.58,24.75-5.19,35.97c13.71,7.26,25.9,20.9,36.56,37.71q3.54,5.58,6.86,11.61c2.88,5.2,5.63,10.61,8.25,16.15.32.66.63,1.33.94,2,1.01,2.17,2.01,4.36,2.98005,6.56H473.75c.36-2.21.72-4.32,1.07-6.35a1.54822,1.54822,0,0,0,.04-.21c.13-.68.25-1.34.36-2C476.44,736.79541,477.62,731.28546,478.55,727.24542Z" transform="translate(-49.50001 -116.97455)" fill="#2f2e41"/><path d="M467.73451,378.93759s19.93284,36.24152,12.68454,81.54343S502.164,618.13166,502.164,618.13166l21.74492-5.43623s-14.49661-94.228-10.87246-115.97289,3.62415-106.9125-14.49661-117.78495S467.73451,378.93759,467.73451,378.93759Z" transform="translate(-49.50001 -116.97455)" fill="#2f2e41"/><path d="M678.47286,416.59979l7.61685,200.62583,14.49661,9.06038s20.83888-220.16727,9.96642-220.16727H688.4302A9.97043,9.97043,0,0,0,678.47286,416.59979Z" transform="translate(-49.50001 -116.97455)" fill="#2f2e41"/><circle cx="462.63037" cy="487.56653" r="9.06038" fill="#4299e1"/><circle cx="643.838" cy="496.62692" r="9.06038" fill="#4299e1"/><polygon points="506.12 58.104 506.12 126.963 522.067 126.963 542.362 105.218 539.644 126.963 610.133 126.963 605.784 105.218 614.482 126.963 625.717 126.963 625.717 58.104 506.12 58.104" fill="#2f2e41"/><ellipse cx="495.24775" cy="129.68146" rx="5.43623" ry="9.96642" fill="#ffb8b8"/><ellipse cx="634.77762" cy="129.68146" rx="5.43623" ry="9.96642" fill="#ffb8b8"/><path d="M721.4252,612.69543s-82.44948-15.40265-87.8857,11.77849,91.50985,15.40265,91.50985,15.40265Z" transform="translate(-49.50001 -116.97455)" fill="#ffb8b8"/><path d="M719.61312,426.05157S917.12944,583.70221,880.88791,621.75581,706.92859,648.937,706.92859,648.937l9.06038-45.3019,79.73135-9.06038L755.85465,554.709l-36.24153,3.62415Z" transform="translate(-49.50001 -116.97455)" fill="#d0cde1"/><path d="M427.86884,688.80263l25.36906,19.93284s18.12077,56.17437,45.30191,39.86568S473.17074,674.306,473.17074,674.306l-30.80529-10.87246Z" transform="translate(-49.50001 -116.97455)" fill="#ffb8b8"/><path d="M453.2379,397.05835l-25.30065,7.61381s-175.83982,130.104-183.08812,166.34551S279.27858,627.192,279.27858,627.192l157.65064,74.29513,16.30868-43.48983-74.29513-38.05361s5.43623-10.87245-16.30868-12.68453S337.265,581.89013,337.265,581.89013s43.48983-67.04682,67.04682-52.55021,30.8053,25.36907,30.8053,25.36907Z" transform="translate(-49.50001 -116.97455)" fill="#d0cde1"/><path d="M814.1,733.45544v6.07a13.34008,13.34008,0,0,1-.91,4.87,13.68227,13.68227,0,0,1-.97,2,13.4373,13.4373,0,0,1-11.55,6.56H354.12a13.43736,13.43736,0,0,1-11.55-6.56,13.68842,13.68842,0,0,1-.97-2,13.34153,13.34153,0,0,1-.91-4.87v-6.07a13.42641,13.42641,0,0,1,13.43-13.43h25.74v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.55908.55908,0,0,1,.56.56v2.83h8.39v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.55908.55908,0,0,1,.56.56v2.83h8.4v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.55908.55908,0,0,1,.56.56v2.83h8.39v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.55908.55908,0,0,1,.56.56v2.83h8.39v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.55908.55908,0,0,1,.56.56v2.83h8.4v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.55908.55908,0,0,1,.56.56v2.83h8.39v-2.83a.55908.55908,0,0,1,.56-.56h105.2a.55908.55908,0,0,1,.56.56v2.83h8.4v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.56552.56552,0,0,1,.56.56v2.83h8.39v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.55908.55908,0,0,1,.56.56v2.83h8.39v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.55908.55908,0,0,1,.56.56v2.83h8.4v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.557.557,0,0,1,.55.56v2.83h8.4v-2.83a.55908.55908,0,0,1,.56-.56H738a.55908.55908,0,0,1,.56.56v2.83h8.39v-2.83a.55908.55908,0,0,1,.56-.56h13.43a.55908.55908,0,0,1,.56.56v2.83h39.17A13.42636,13.42636,0,0,1,814.1,733.45544Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><rect x="161.44819" y="627.41618" width="732.99951" height="2" fill="#3f3d56"/><path d="M778.14246,477.82126H611.69957v-3.43053H536.22789v3.43053h-167.129a11.25861,11.25861,0,0,0-11.25861,11.25861v227.9115A11.25864,11.25864,0,0,0,369.09889,728.25H778.14246a11.25864,11.25864,0,0,0,11.25861-11.25865V489.07987A11.2586,11.2586,0,0,0,778.14246,477.82126Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><circle cx="524.44819" cy="440.41618" r="25" fill="none" stroke="#d0cde1" stroke-miterlimit="10" stroke-width="2"/><circle cx="516.44819" cy="449.41618" r="25" fill="#d0cde1"/><rect x="26.02015" y="663.55077" width="189" height="2.26159" fill="#3f3d56"/><rect x="851.02015" y="663.55077" width="189" height="2.26159" fill="#3f3d56"/><path d="M185.63919,707.69176c-19.911,32.5064-13.06067,72.9409-13.06067,72.9409s39.1325-12.26879,59.04353-44.7752,13.06067-72.9409,13.06067-72.9409S205.55022,675.18536,185.63919,707.69176Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><path d="M171.76594,780.90107l-1.13209-.17932c-.40938-.06491-41.158-6.81651-65.56214-36.01491-24.40427-29.19937-23.817-70.4997-23.809-70.91351l.02429-1.14573,1.13209.17932c.40939.06492,41.158,6.81651,65.56228,36.01588h0c24.40414,29.19841,23.81684,70.49874,23.80885,70.91255Z" transform="translate(-49.50001 -116.97455)" fill="#4299e1"/><path d="M173.37365,781.92912l-1.09375-.34277c-.39551-.124-39.7207-12.75586-59.59766-45.20605-19.87695-32.45118-13.26269-73.22266-13.19433-73.63086l.1914-1.12989,1.09375.34278c.39551.124,39.72071,12.75586,59.59766,45.207h0c19.87695,32.45019,13.2627,73.22168,13.19434,73.62988Zm-72.081-117.67773c-.90528,6.84277-4.51368,42.33594,13.09472,71.084,17.60938,28.74707,50.86719,41.65821,57.373,43.96192.90527-6.84278,4.51367-42.33594-13.09473-71.083h0C141.05627,679.46623,107.79846,666.5551,101.2926,664.25139Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><circle cx="124.32091" cy="536.32762" r="22" fill="#3f3d56"/><polygon points="399.789 258.254 273.582 131.051 214 131.051 214 129.051 274.417 129.051 274.711 129.348 401.211 256.848 399.789 258.254" fill="#3f3d56"/><polygon points="696.211 254.254 822.417 127.051 882 127.051 882 125.051 821.582 125.051 821.289 125.348 694.789 252.848 696.211 254.254" fill="#3f3d56"/><rect x="0.00009" y="68.33964" width="145.99988" height="28.87712" fill="#d0cde1"/><rect x="0.00009" y="112.65108" width="145.99988" height="28.87712" fill="#d0cde1"/><rect x="0.00009" y="156.96251" width="145.99988" height="28.87712" fill="#d0cde1"/><rect x="0.0001" y="68.33965" width="60.39875" height="28.87712" opacity="0.15"/><rect y="112.65105" width="19.55356" height="28.87712" opacity="0.15"/><rect x="0.00009" y="156.96251" width="97.33325" height="28.87712" opacity="0.15"/><rect x="954.7761" y="74.82702" width="146.22388" height="13.02985" fill="#d0cde1"/><rect x="899.99998" y="73.14045" width="28.95522" height="28.95522" fill="#4299e1"/><rect x="899.99998" y="116.57329" width="28.95522" height="28.95522" fill="#4299e1"/><rect x="899.99998" y="160.00612" width="28.95522" height="28.95522" fill="#4299e1"/><path d="M986.45507,213.07037H955.5V182.1148h30.95508Zm-28.95508-2h26.95508V184.1148H957.5Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><rect x="954.7761" y="118.25985" width="146.22388" height="13.02985" fill="#d0cde1"/><path d="M986.45507,256.503H955.5V225.54791h30.95508Zm-28.95508-2h26.95508V227.54791H957.5Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><rect x="954.7761" y="161.69269" width="146.22388" height="13.02985" fill="#d0cde1"/><path d="M986.45507,299.93561H955.5V268.98053h30.95508Zm-28.95508-2h26.95508V270.98053H957.5Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><circle cx="188.99998" cy="83.0509" r="16" fill="#4299e1"/><circle cx="188.99998" cy="131.0509" r="16" fill="#4299e1"/><circle cx="188.99998" cy="174.0509" r="16" fill="#4299e1"/><path d="M230.5,213.02545a17,17,0,1,1,17-17A17.019,17.019,0,0,1,230.5,213.02545Zm0-32a15,15,0,1,0,15,15A15.017,15.017,0,0,0,230.5,181.02545Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><path d="M230.5,261.02545a17,17,0,1,1,17-17A17.019,17.019,0,0,1,230.5,261.02545Zm0-32a15,15,0,1,0,15,15A15.017,15.017,0,0,0,230.5,229.02545Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><path d="M230.5,304.02545a17,17,0,1,1,17-17A17.019,17.019,0,0,1,230.5,304.02545Zm0-32a15,15,0,1,0,15,15A15.017,15.017,0,0,0,230.5,272.02545Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><path d="M1038.5,713.02545h-2v-15a3.00328,3.00328,0,0,1,3-3h5a1.00067,1.00067,0,0,0,1-1v-10a1.00067,1.00067,0,0,0-1-1h-5a3.00328,3.00328,0,0,1-3-3v-5a1.00067,1.00067,0,0,0-1-1h-9a3.00328,3.00328,0,0,1-3-3v-1a1.00067,1.00067,0,0,0-1-1h-36a1.00067,1.00067,0,0,0-1,1v1a3.00328,3.00328,0,0,1-3,3h-9a1.00067,1.00067,0,0,0-1,1v5a3.00328,3.00328,0,0,1-3,3h-5a1.00067,1.00067,0,0,0-1,1v10a1.00067,1.00067,0,0,0,1,1h6a3.00328,3.00328,0,0,1,3,3v15h-2v-15a1.00067,1.00067,0,0,0-1-1h-6a3.00328,3.00328,0,0,1-3-3v-10a3.00328,3.00328,0,0,1,3-3h5a1.00067,1.00067,0,0,0,1-1v-5a3.00328,3.00328,0,0,1,3-3h9a1.00067,1.00067,0,0,0,1-1v-1a3.00328,3.00328,0,0,1,3-3h36a3.00328,3.00328,0,0,1,3,3v1a1.00067,1.00067,0,0,0,1,1h9a3.00328,3.00328,0,0,1,3,3v5a1.00067,1.00067,0,0,0,1,1h5a3.00328,3.00328,0,0,1,3,3v10a3.00328,3.00328,0,0,1-3,3h-5a1.00067,1.00067,0,0,0-1,1Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><path d="M1035.5,783.02545h-61a3.00328,3.00328,0,0,1-3-3v-43h2v43a1.00067,1.00067,0,0,0,1,1h61a1.00067,1.00067,0,0,0,1-1v-43h2v43A3.00328,3.00328,0,0,1,1035.5,783.02545Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><rect x="921.99998" y="603.0509" width="79" height="24" rx="2" fill="#4299e1"/><path d="M1042,738.02545H967a3.00328,3.00328,0,0,1-3-3v-20a3.00328,3.00328,0,0,1,3-3h75a3.00328,3.00328,0,0,1,3,3v20A3.00328,3.00328,0,0,1,1042,738.02545Zm-75-24a1.00067,1.00067,0,0,0-1,1v20a1.00067,1.00067,0,0,0,1,1h75a1.00067,1.00067,0,0,0,1-1v-20a1.00067,1.00067,0,0,0-1-1Z" transform="translate(-49.50001 -116.97455)" fill="#3f3d56"/><path d="M1002.5,660.02545v0a249.6283,249.6283,0,0,1-2.09463-54.11121L1002.5,576.02545h0c-11.54175,22.96553-8.93335,53.1922,0,83.99993Z" transform="translate(-49.50001 -116.97455)" fill="#d0cde1"/><path d="M1011.5,665.02545v0a183.49687,183.49687,0,0,1-1.00779-32.20905L1011.5,615.02545h0c-5.55309,13.67-4.29811,31.662,0,50Z" transform="translate(-49.50001 -116.97455)" fill="#d0cde1"/></svg>
            </div>
        </div>
    </div>
    <div>
        {{-- @dd(Auth::user()->userLevel->name == "Super Admin") --}}
        <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-2 @if(Auth::user()->userLevel->name == "Super Admin") lg:grid-cols-5 @endif ?? lg:grid-cols-4 ">
            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
                            <!-- Heroicon name: outline/users -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="flex-1 w-0 ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                {{ucwords(trans_choice('messages.order', 2))}}
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    @if($orders)
                                    {{$orders->count()}}
                                    @endif
                                    0
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-4 bg-gray-50 sm:px-6">
                    <div class="text-sm">
                        <a href="/order" class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Total Subscribers stats</span></a>
                    </div>
                </div>
            </div>

            @if(Auth::user()->userLevel->name == "Super Admin")
            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
                            <!-- Heroicon name: outline/mail-open -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 w-0 ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                {{ucwords(trans_choice('messages.provider', 2))}}
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{$providers->count()}}
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-4 bg-gray-50 sm:px-6">
                    <div class="text-sm">
                        <a href=" {{route('provider.index')}} " class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Avg. Open Rate stats</span></a>
                    </div>
                </div>
            </div>
            @endif
            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
                            <!-- Heroicon name: outline/mail-open -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 w-0 ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                {{ucwords(trans_choice('messages.reseller', 2))}}
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{$resellers->count()}}
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-4 bg-gray-50 sm:px-6">
                    <div class="text-sm">
                        <a href=" {{route('reseller.index')}} " class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Avg. Open Rate stats</span></a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
                            <!-- Heroicon name: outline/mail-open -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 w-0 ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                {{ucwords(trans_choice('messages.customer', 2))}}
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                   {{$customers->count()}}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-4 bg-gray-50 sm:px-6">
                        <div class="text-sm">
                            <a href="/customer" class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Avg. Open Rate stats</span></a>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                    <div class="flex-grow px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
                                <!-- Heroicon name: outline/cursor-click -->
                                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    {{ucwords(trans_choice('messages.subscription', 2))}}
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{$subscriptions->count()}}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-4 bg-gray-50 sm:px-6">
                        <div class="text-sm">
                            <a href="/subscription" class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Avg. Click Rate stats</span></a>
                        </div>
                    </div>
                </div>
            </dl>
        </div>


        <div class="overflow-hidden bg-gray-200 divide-y divide-gray-200 rounded-lg shadow sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
            <div class="relative p-6 bg-white rounded-tl-lg rounded-tr-lg sm:rounded-tr-none group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                <div >
                    <span class="inline-flex p-3 rounded-lg bg-blue-50 ring-4 ring-white">
                        <!-- Heroicon name: outline/clock -->
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium">
                            <a href="/store" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ucwords(trans_choice('messages.store', 1))}}
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Purchase on-behalf your customers.
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                        </svg>
                    </span>
                </div>
                <div class="relative p-6 bg-white sm:rounded-tr-lg group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-purple-700 rounded-lg bg-purple-50 ring-4 ring-white">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium">
                            <a href="/customer" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ucwords(trans_choice('messages.customer', 2))}}
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Manage your customers
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                        </svg>
                    </span>
                </div>
                <div class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-green-700 rounded-lg bg-blue-50 ring-4 ring-white">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium">
                            <a href="/subscription" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ucwords(trans_choice('messages.subscription', 2))}}
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Manage your customers subscriptions.
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                        </svg>
                    </span>
                </div>
                <div class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-yellow-700 rounded-lg bg-yellow-50 ring-4 ring-white">
                            <!-- Heroicon name: outline/badge-check -->
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium">
                            <a href="/analytics" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ucwords(trans_choice('messages.analytics', 2))}}
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Check your current budget for Azure Subscriptions
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                        </svg>
                    </span>
                </div>
                <div class="relative p-6 bg-white sm:rounded-bl-lg group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-blue-700 rounded-lg bg-purple-50 ring-4 ring-white">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium">
                            <a href="tickets" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ucwords(trans_choice('messages.ticket', 2))}}
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Submit a support ticket
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                        </svg>
                    </span>
                </div>
                <div class="relative p-6 bg-white rounded-bl-lg rounded-br-lg sm:rounded-bl-none group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-indigo-700 rounded-lg bg-indigo-50 ring-4 ring-white">
                            <!-- Heroicon name: outline/academic-cap -->
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium">
                            <a href="/priceList" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ucwords(trans_choice('messages.price', 2))}}
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Manage your price List
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>



        @endsection

        {{-- @section('scripts') --}}


        {{-- @endsection --}}
