<div>
@include('layouts.messages')

<main class="pb-10 mx-auto max-w-auto lg:py-12 lg:px-8">
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-4">
        <!-- Payment details -->
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
            {{-- @dd(Auth::user()->userlevel->name != 'Reseller' or Auth::user()->userlevel->name != 'Customer' ) --}}
            @if(Auth::user()->userlevel->name == 'Provider')
            <section aria-labelledby="payment_details_heading">
                <form wire:submit.prevent="savePhoto">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-6 bg-white sm:p-6">
                            <div>
                                <h2 id="payment_details_heading" class="text-lg font-medium leading-6 text-gray-900">Company Logo</h2>
                                <p class="mt-1 text-sm text-gray-500">Set your company Logo.</p>
                            </div>
                            <div class="sm:col-span-6">
                                <label for="photo" class="block text-sm font-medium text-blue-gray-900">
                                    Logo
                                </label>
                                <div class="flex items-center mt-1">
                                    {{-- @dump($photo->temporaryUrl()) --}}
                                    @if ($photo)
                                    <img class="inline-block w-auto h-14 " src="{{$photo->temporaryUrl()}}" alt="">
                                    @else
                                    <img class="inline-block w-auto h-14 " src="{{$logo ?? $logo->temporaryUrl()}}" alt="">
                                    @endif
                                    <div class="flex ml-4">
                                        <div class="relative flex items-center px-3 py-1 mr-3 bg-white border rounded-md shadow-sm cursor-pointer border-blue-gray-300 hover:bg-blue-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-blue-gray-50 focus-within:ring-blue-500">
                                            <label for="user_photo" class="relative text-sm font-medium pointer-events-none text-blue-gray-900">
                                                <span>Change</span>
                                                <span class="sr-only"> Company Logo</span>
                                            </label>
                                            <input wire:model="photo" id="photo" name="photo" type="file" class="absolute inset-0 w-full h-full border-gray-300 rounded-md opacity-0 cursor-pointer">
                                        </div>
                                        @if(isset($logo))
                                        <x-button type="submit" wire:click.prevent='removePhoto' >
                                            Remove
                                        </x-button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div wire:loading wire:target="photo">Uploading...</div>
                            <div class="text-red-700">
                                @error('photo') <span class="error">{{ $message }}</span> @enderror
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
            @endif

            <section aria-labelledby="payment_details_heading">
                <form action="#" method="POST">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-6 bg-white sm:p-6">
                            <div>
                                <h2 id="payment_details_heading" class="text-lg font-medium leading-6 text-gray-900">Company details</h2>
                                <p class="mt-1 text-sm text-gray-500">Update your Company billing information.</p>
                            </div>
                            <div class="grid grid-cols-4 gap-6 mt-6">
                                <div class="col-span-4 sm:col-span-2">
                                    <x-label for="nif">{{ucwords(trans_choice('messages.company_name', 1))}}</x-label>
                                    <x-input wire:model="company_name" type="text" name="company_name"   class="@error('company_name') is-invalid @enderror" id='company_name' ></x-input>
                                    @error('company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>

                                <div class="col-span-4 sm:col-span-2">
                                    <x-label for="nif">{{ucwords(trans_choice('messages.nif', 1))}}</x-label>
                                    <x-input wire:model="nif" type="text" name="nif"   class="@error('nif') is-invalid @enderror" id='nif' ></x-input>
                                    @error('nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>

                                <div class="col-span-4 sm:col-span-2">
                                    <x-label for="address">{{ucwords(trans_choice('messages.address', 1))}}</x-label>
                                    <x-input wire:model="address" type="text" name="address"   class="@error('address') is-invalid @enderror" id='address' ></x-input>
                                    @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>

                                <div class="col-span-4 sm:col-span-1">
                                    <x-label for="city">{{ucwords(trans_choice('messages.city', 1))}}</x-label>
                                    <x-input wire:model="city" type="text" name="city"   class="@error('city') is-invalid @enderror" id='city' ></x-input>
                                    @error('city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>

                                <div class="col-span-4 sm:col-span-1">
                                    <x-label for="state">{{ucwords(trans_choice('messages.state', 1))}}</x-label>
                                    <x-input wire:model="state" type="text" name="state"   class="@error('state') is-invalid @enderror" id='state' ></x-input>
                                    @error('state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>

                                <div class="col-span-4 sm:col-span-2">
                                    <x-label for="country">{{ucwords(trans_choice('messages.country', 1))}}</x-label>
                                    <div class="mb-3 input-group">
                                        <select wire:model="country_id" name="country_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md @error('country_id') is-invalid @enderror" sf-validate="required">
                                            <option value="">Choose...</option>
                                            @foreach ($countries as $key => $country)
                                            <option value="{{$key}}">{{$country}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>

                                <div class="col-span-4 sm:col-span-2">
                                    <x-label for="postal_code">{{ucwords(trans_choice('messages.postal_code', 1))}}</x-label>
                                    <x-input wire:model="postal_code" type="text" name="postal_code"   class="@error('postal_code') is-invalid @enderror" id='postal_code' ></x-input>
                                    @error('postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
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
        </div>
    </div>
</main>

            <!-- Plan -->
            {{-- <section aria-labelledby="plan_heading">
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
                                <div class="relative -space-y-px bg-white rounded-md">
                                    <!-- Checked: "bg-orange-50 border-orange-200 z-10", Not Checked: "border-gray-200" -->
                                    <label class="relative flex flex-col p-4 border border-gray-200 cursor-pointer rounded-tl-md rounded-tr-md md:pl-4 md:pr-6 md:grid md:grid-cols-3">
                                        <div class="flex items-center text-sm">
                                            <input type="radio" name="pricing_plan" value="Startup" class="w-4 h-4 text-orange-500 border-gray-300 focus:ring-gray-900" aria-labelledby="pricing-plans-0-label" aria-describedby="pricing-plans-0-description-0 pricing-plans-0-description-1">
                                            <span id="pricing-plans-0-label" class="ml-3 font-medium text-gray-900">Startup</span>
                                        </div>
                                        <p id="pricing-plans-0-description-0" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-center">
                                            <!-- Checked: "text-orange-900", Not Checked: "text-gray-900" -->
                                            <span class="font-medium text-gray-900">$29 / mo</span>
                                            <!-- Checked: "text-orange-700", Not Checked: "text-gray-500" -->
                                            <span class="text-gray-500">($290 / yr)</span>
                                        </p>
                                        <!-- Checked: "text-orange-700", Not Checked: "text-gray-500" -->
                                        <p id="pricing-plans-0-description-1" class="pl-1 ml-6 text-sm text-gray-500 md:ml-0 md:pl-0 md:text-right">Up to 5 active job postings</p>
                                    </label>

                                    <!-- Checked: "bg-orange-50 border-orange-200 z-10", Not Checked: "border-gray-200" -->
                                    <label class="relative flex flex-col p-4 border border-gray-200 cursor-pointer md:pl-4 md:pr-6 md:grid md:grid-cols-3">
                                        <div class="flex items-center text-sm">
                                            <input type="radio" name="pricing_plan" value="Business" class="w-4 h-4 text-orange-500 border-gray-300 focus:ring-gray-900" aria-labelledby="pricing-plans-1-label" aria-describedby="pricing-plans-1-description-0 pricing-plans-1-description-1">
                                            <span id="pricing-plans-1-label" class="ml-3 font-medium text-gray-900">Business</span>
                                        </div>
                                        <p id="pricing-plans-1-description-0" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-center">
                                            <!-- Checked: "text-orange-900", Not Checked: "text-gray-900" -->
                                            <span class="font-medium text-gray-900">$99 / mo</span>
                                            <!-- Checked: "text-orange-700", Not Checked: "text-gray-500" -->
                                            <span class="text-gray-500">($990 / yr)</span>
                                        </p>
                                        <!-- Checked: "text-orange-700", Not Checked: "text-gray-500" -->
                                        <p id="pricing-plans-1-description-1" class="pl-1 ml-6 text-sm text-gray-500 md:ml-0 md:pl-0 md:text-right">Up to 25 active job postings</p>
                                    </label>

                                    <!-- Checked: "bg-orange-50 border-orange-200 z-10", Not Checked: "border-gray-200" -->
                                    <label class="relative flex flex-col p-4 border border-gray-200 cursor-pointer rounded-bl-md rounded-br-md md:pl-4 md:pr-6 md:grid md:grid-cols-3">
                                        <div class="flex items-center text-sm">
                                            <input type="radio" name="pricing_plan" value="Enterprise" class="w-4 h-4 text-orange-500 border-gray-300 focus:ring-gray-900" aria-labelledby="pricing-plans-2-label" aria-describedby="pricing-plans-2-description-0 pricing-plans-2-description-1">
                                            <span id="pricing-plans-2-label" class="ml-3 font-medium text-gray-900">Enterprise</span>
                                        </div>
                                        <p id="pricing-plans-2-description-0" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-center">
                                            <!-- Checked: "text-orange-900", Not Checked: "text-gray-900" -->
                                            <span class="font-medium text-gray-900">$249 / mo</span>
                                            <!-- Checked: "text-orange-700", Not Checked: "text-gray-500" -->
                                            <span class="text-gray-500">($2490 / yr)</span>
                                        </p>
                                        <!-- Checked: "text-orange-700", Not Checked: "text-gray-500" -->
                                        <p id="pricing-plans-2-description-1" class="pl-1 ml-6 text-sm text-gray-500 md:ml-0 md:pl-0 md:text-right">Unlimited active job postings</p>
                                    </label>
                                </div>
                            </fieldset>

                            <div class="flex items-center">
                                <!-- Enabled: "bg-orange-500", Not Enabled: "bg-gray-200" -->
                                <button type="button" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900" role="switch" aria-checked="true" aria-labelledby="annual-billing-label">
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
                                                    <time datetime="2020-01-01">1/1/2020</time>
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

                                            <!-- More payments... -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --}}
        </div>
    </div>
</main>
