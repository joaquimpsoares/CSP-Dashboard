<div>
    <main class="pb-10 mx-auto max-w-7xl lg:py-12 lg:px-8">
        {{-- <div class="lg:grid lg:grid-cols-12 lg:gap-x-5"> --}}
            <div class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
                {{-- @dd($account) --}}
                <!-- Payment details -->
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
                    <section aria-labelledby="payment_details_heading">
                        <form action="#" method="POST">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-6 bg-white sm:p-6">
                                    <div>
                                        <h2 id="payment_details_heading" class="text-lg font-medium leading-6 text-gray-900">{{ ucwords(trans_choice('messages.customer_details', 1)) }}</h2>
                                        <p class="mt-1 text-sm text-gray-500">Update your billing information. Please note that updating your location could affect your tax rates.</p>
                                    </div>
                                    <div class="grid grid-cols-4 gap-6 mt-6">
                                        <div class="col-span-4 sm:col-span-2">
                                            <label for="first_name" class="block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                            <input value="{{$account->company_name}}" type="text" name="first_name" id="first_name" autocomplete="cc-given-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <label for="last_name" class="block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                                            <input value="{{$account->nif}}" type="text" name="last_name" id="last_name" autocomplete="cc-family-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <label for="email_address" class="block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.address', 1)) }}</label>
                                            <input value="{{$account->address_1}}" type="text" name="email_address" id="email_address" autocomplete="email" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                        </div>

                                        <div class="col-span-4 sm:col-span-1">
                                            <label for="expiration_date" class="block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.city', 1)) }}</label>
                                            <input value="{{$account->city}}" type="text" name="expiration_date" id="expiration_date" autocomplete="cc-exp" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm" placeholder="MM / YY">
                                        </div>

                                        <div class="col-span-4 sm:col-span-1">
                                            <label for="security_code" class="flex items-center text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.state', 1)) }}</label>
                                            <input value="{{$account->state}}" type="text" name="security_code" id="security_code" autocomplete="cc-csc" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <label for="country" class="block text-sm font-medium text-gray-700">Country / Region</label>
                                            <select id="country" name="country" autocomplete="country" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                <option>United States</option>
                                                <option>Canada</option>
                                                <option>Mexico</option>
                                            </select>
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <label for="postal_code" class="block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.postal_code', 1)) }}</label>
                                            <input value="{{$account->postal_code}}" type="text" name="postal_code" id="postal_code" autocomplete="postal-code" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </section>
                    <!-- Plan -->
                    @if(Auth::user()->roles->first()->name == "Provider")
                    <section aria-labelledby="plan_heading">
                        <form action="#" method="POST">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-6 space-y-6 bg-white sm:p-6">
                                    <div>
                                        <h2 id="plan_heading" class="text-lg font-medium leading-6 text-gray-900">Plan</h2>
                                    </div>

                                    <fieldset>
                                        <legend class="sr-only">
                                            Pricing plans
                                        </legend>
                                        <ul class="relative -space-y-px bg-white rounded-md">
                                            <li>
                                                <!-- On: "bg-orange-50 border-orange-200 z-10", Off: "border-gray-200" -->
                                                <div class="relative flex flex-col p-4 border rounded-tl-md rounded-tr-md md:pl-4 md:pr-6 md:grid md:grid-cols-3">
                                                    <label class="flex items-center text-sm cursor-pointer">
                                                        <input name="pricing_plan" type="radio" class="w-4 h-4 text-indigo-500 border-gray-300 cursor-pointer focus:ring-gray-900" aria-describedby="plan-option-pricing-0 plan-option-limit-0">
                                                        <span class="ml-3 font-medium text-gray-900">Startup</span>
                                                    </label>
                                                    <p id="plan-option-pricing-0" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-center">
                                                        <!-- On: "text-orange-900", Off: "text-gray-900" -->
                                                        <span class="font-medium">$29 / mo</span>
                                                        <!-- On: "text-orange-700", Off: "text-gray-500" -->
                                                        <span>($290 / yr)</span>
                                                    </p>
                                                    <!-- On: "text-orange-700", Off: "text-gray-500" -->
                                                    <p id="plan-option-limit-0" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-right">Up to 5 active job postings</p>
                                                </div>
                                            </li>

                                            <li>
                                                <!-- On: "bg-orange-50 border-orange-200 z-10", Off: "border-gray-200" -->
                                                <div class="relative flex flex-col p-4 border border-gray-200 md:pl-4 md:pr-6 md:grid md:grid-cols-3">
                                                    <label class="flex items-center text-sm cursor-pointer">
                                                        <input name="pricing_plan" type="radio" class="w-4 h-4 text-indigo-500 border-gray-300 cursor-pointer focus:ring-gray-900" aria-describedby="plan-option-pricing-1 plan-option-limit-1" checked>
                                                        <span class="ml-3 font-medium text-gray-900">Business</span>
                                                    </label>
                                                    <p id="plan-option-pricing-1" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-center">
                                                        <!-- On: "text-orange-900", Off: "text-gray-900" -->
                                                        <span class="font-medium">$99 / mo</span>
                                                        <!-- On: "text-orange-700", Off: "text-gray-500" -->
                                                        <span>($990 / yr)</span>
                                                    </p>
                                                    <!-- On: "text-orange-700", Off: "text-gray-500" -->
                                                    <p id="plan-option-limit-1" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-right">Up to 25 active job postings</p>
                                                </div>
                                            </li>

                                            <li>
                                                <!-- On: "bg-orange-50 border-orange-200 z-10", Off: "border-gray-200" -->
                                                <div class="relative flex flex-col p-4 border border-gray-200 rounded-bl-md rounded-br-md md:pl-4 md:pr-6 md:grid md:grid-cols-3">
                                                    <label class="flex items-center text-sm cursor-pointer">
                                                        <input name="pricing_plan" type="radio" class="w-4 h-4 text-indigo-500 border-gray-300 cursor-pointer focus:ring-gray-900" aria-describedby="plan-option-pricing-2 plan-option-limit-2">
                                                        <span class="ml-3 font-medium text-gray-900">Enterprise</span>
                                                    </label>
                                                    <p id="plan-option-pricing-2" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-center">
                                                        <!-- On: "text-orange-900", Off: "text-gray-900" -->
                                                        <span class="font-medium">$249 / mo</span>
                                                        <!-- On: "text-orange-700", Off: "text-gray-500" -->
                                                        <span>($2490 / yr)</span>
                                                    </p>
                                                    <!-- On: "text-orange-700", Off: "text-gray-500" -->
                                                    <p id="plan-option-limit-2" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-right">Unlimited active job postings</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </fieldset>

                                    <div class="flex items-center">
                                        <!-- Enabled: "bg-indigo-500", Not Enabled: "bg-gray-200" -->
                                        <button type="button" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900" aria-pressed="true" aria-labelledby="annual-billing-label">
                                            <span class="sr-only">Use setting</span>
                                            <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                            <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow ring-0"></span>
                                        </button>
                                        <span class="ml-3" id="annual-billing-label">
                                            <span class="text-sm font-medium text-gray-900">Annual billing </span>
                                            <span class="text-sm text-gray-500">(Save 10%)</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </section>

                    <!-- Billing history -->
                    <section aria-labelledby="billing_history_heading">
                        <div class="pt-6 bg-white shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 sm:px-6">
                                <h2 id="billing_history_heading" class="text-lg font-medium leading-6 text-gray-900">Billing history</h2>
                            </div>
                            <div class="flex flex-col mt-6">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                        <div class="overflow-hidden border-t border-gray-200">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                            Date
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                            Description
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                            Amount
                                                        </th>
                                                        <!--
                                                            `relative` is added here due to a weird bug in Safari that causes `sr-only` headings to introduce overflow on the body on mobile.
                                                        -->
                                                        <th scope="col" class="relative px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                            <span class="sr-only">View receipt</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    <tr>
                                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            1/1/2020
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            Business Plan - Annual Billing
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            CA$109.00
                                                        </td>
                                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                            <a href="#" class="text-orange-600 hover:text-orange-900">View receipt</a>
                                                        </td>
                                                    </tr>

                                                    <!-- More items... -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    @endif

                    <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">
                        <div class="bg-white shadow sm:rounded-lg">
                            <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                                <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                                    <div class="mt-2 ml-4">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                                            {{ ucwords(trans_choice('messages.customer_details', 1)) }}
                                        </h3>
                                    </div>
                                    <div class="flex-shrink-0 mt-2 ml-4">
                                        {{-- <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $customer->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">
                                            {{ ucwords(trans_choice($customer->status->name, 1)) }} --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-10 py-5 border-t border-gray-200 sm:px-6">
                                <div class="flex flex-col mt-6 ml-10 lg:flex-row">
                                    <div class="flex-grow space-y-6">
                                        <div>
                                            <label for="username" class="block text-sm font-medium text-gray-700">
                                                Username
                                            </label>
                                            <div class="flex mt-1 rounded-md shadow-sm">
                                                <span class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-300 bg-gray-50 rounded-l-md sm:text-sm">
                                                    https://
                                                </span>
                                                <input type="text" name="url" id="url" autocomplete="url" class="flex-grow block w-full min-w-0 border-gray-300 rounded-none focus:ring-light-blue-500 focus:border-light-blue-500 rounded-r-md sm:text-sm" value="lisamarie">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="flex-grow mt-6 ml-10 lg:mt-0 lg:ml-16 lg:flex-grow-0 lg:flex-shrink-0"> --}}
                                        <p class="text-sm font-medium text-gray-700" aria-hidden="true">
                                            Photo
                                        </p>
                                        <div class="mt-1 lg:block">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 inline-block w-12 h-12 overflow-hidden rounded-full" aria-hidden="true">
                                                    <img class="w-full h-full rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixqx=uonr10FSf0&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=80h" alt="">
                                                </div>
                                                <div class="ml-5 rounded-md shadow-sm">
                                                    <div class="relative flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md group hover:bg-gray-50 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-light-blue-500">
                                                        <label for="user_photo" class="relative text-sm font-medium leading-4 text-gray-700 pointer-events-none">
                                                            <span>Change</span>
                                                            <span class="sr-only"> user photo</span>
                                                        </label>
                                                        <input id="user_photo" name="user_photo" type="file" class="absolute w-full h-full border-gray-300 rounded-md opacity-0 cursor-pointer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="relative hidden overflow-hidden rounded-full lg:block">
                                            <img class="relative w-40 h-40 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixqx=uonr10FSf0&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=320&h=320&q=80" alt="">
                                            <label for="user-photo" class="absolute inset-0 flex items-center justify-center w-full h-full text-sm font-medium text-white bg-black bg-opacity-75 opacity-0 hover:opacity-100 focus-within:opacity-100">
                                                <span>Change</span>
                                                <span class="sr-only"> user photo</span>
                                                <input type="file" id="user-photo" name="user-photo" class="absolute inset-0 w-full h-full border-gray-300 rounded-md opacity-0 cursor-pointer">
                                            </label>
                                        </div> --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div>
                            {{-- <a href="{{$customer->format()['path']}}/edit" class="block px-4 py-4 text-sm font-medium text-center text-gray-500 bg-gray-50 hover:text-gray-700 sm:rounded-b-lg">{{ ucwords(trans_choice('messages.edit_customer', 1)) }}</a> --}}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

</div>
