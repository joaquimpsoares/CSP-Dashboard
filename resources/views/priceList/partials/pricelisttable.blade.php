
<div id='recipients' class="p-5 mt-6 mb-5 bg-white lg:mt-0">
    <div class="px-4 py-4 bg-white border-b border-gray-200 py-auto sm:px-6">
        <div class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-nowrap">
            <div class="mt-4 ml-4">
                <div class="flex items-center">
                    <div class="ml-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            {{ ucwords(trans_choice('messages.price_list', 1)) }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="flex flex-shrink-0 mt-1 ml-4">
                <a href="{{route("priceList.create")}}" type="button" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <!-- Heroicon name: solid/mail -->
                    <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>
                        {{ ucwords(trans_choice('messages.new_pricelist', 1)) }}
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="-my-1 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <div class="table-responsive">
                        <table id="tagydes_table_buttons" class="flex table w-full border-collapse table-auto ">
                            <thead class="bg-gray-100">
                                <tr class="hidden text-sm text-left text-gray-700 rounded-lg md:table-row" style="font-size: 0.9674rem">
                                    <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                        {{ ucwords(trans_choice('messages.name', 1)) }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                        {{ ucwords(trans_choice('messages.description', 1)) }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                        {{ ucwords(trans_choice('messages.provider', 1)) }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                        {{ ucwords(trans_choice('messages.reseller', 2)) }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                        {{ ucwords(trans_choice('messages.customer', 1)) }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                        {{ ucwords(trans_choice('messages.action', 1)) }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="flex-1 text-gray-700 sm:flex-none">
                                @forelse($priceLists as $priceList)
                                <tr v-for="(person, index) in persons" :key="index" class="flex flex-col flex-wrap w-full p-1 border-t first:border-t-0 md:p-3 hover:bg-gray-100 md:table-row">
                                    <td class="p-1 md:p-3">
                                        <label class="text-xs font-semibold text-gray-500 uppercase md:hidden" for="">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                        <p class=""><a href="{{route('priceList.prices', $priceList['id']) }}">{{ $priceList['name'] }}</a></p>
                                    </td>
                                    <td class="p-1 md:p-3">
                                        <label class="text-xs font-semibold text-gray-500 uppercase md:hidden" for="">{{ ucwords(trans_choice('messages.description', 1)) }}</label>
                                        <p class="">{{ $priceList['description'] }}</p>
                                    </td>
                                    <td class="p-1 md:p-3 md:text-right">
                                        <label class="text-xs font-semibold text-gray-500 uppercase md:hidden" for="">{{ ucwords(trans_choice('messages.provider', 1)) }}</label>
                                        <div>0</div>
                                    </td>
                                    <td class="p-1 md:p-3 md:text-right">
                                        <label class="text-xs font-semibold text-gray-500 uppercase md:hidden" for="">{{ ucwords(trans_choice('messages.reseller', 2)) }}</label>
                                        <div>0</div>
                                    </td>
                                    <td class="p-1 md:p-3 md:text-right">
                                        <label class="text-xs font-semibold text-gray-500 uppercase md:hidden" for="">{{ ucwords(trans_choice('messages.customer', 1)) }}</label>
                                        <div>0</div>
                                    </td>
                                    <td class="p-1 md:p-3">
                                        <label class="text-xs font-semibold text-gray-500 uppercase md:hidden" for="">{{ ucwords(trans_choice('messages.action', 1)) }}</label>
                                        <a href="{{route('priceList.prices', $priceList['id']) }}"  class="inline-flex justify-center px-1 py-2 text-sm text-indigo-600 hover:text-indigo-900">
                                            <!-- Heroicon name: solid/pencil -->
                                            <svg class="w-4 h-4 mr-2 -ml-1 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                            <span>{{ ucwords(trans_choice('messages.edit', 1)) }}</span>
                                        </a>
                                        <a href="{{route('priceList.prices', $priceList['id']) }}"  class="inline-flex justify-center px-1 py-2 text-sm text-red-600 hover:text-red-900">
                                            <!-- Heroicon name: solid/pencil -->
                                            <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ ucwords(trans_choice('messages.delete', 2)) }}
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">Empty</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

