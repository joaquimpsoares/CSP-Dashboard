@extends('layouts.master')
@section('css')

{{-- <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" /> --}}
{{-- <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet"> --}}
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
@endsection

@section('content')

<section class="section">
    <div id='recipients' class="p-5 mt-6 mb-5 bg-white lg:mt-0">
        <div class="px-4 py-4 bg-white border-b border-gray-200 py-auto sm:px-6">
            <div class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-nowrap">
                <div class="mt-4 ml-4">
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                {{ ucwords(trans_choice('messages.product', 2)) }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="flex flex-shrink-0 mt-1 ml-4">
                    <a href="{{route("product.create")}}" type="button" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <span>
                            {{ ucwords(trans_choice('messages.new_product', 1)) }}
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
                                            {{ ucwords(trans_choice('messages.product_sku', 2)) }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.product_name', 2)) }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.category', 2)) }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.vendor', 1)) }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.instance', 1)) }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.action', 2)) }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="flex-1 text-gray-700 sm:flex-none">
                                    @forelse($products as $product)
                                    <tr v-for="(person, index) in persons" :key="index" class="flex flex-col flex-wrap w-full p-1 border-t first:border-t-0 md:p-3 hover:bg-gray-100 md:table-row">
                                        <td style="width: 1px; white-space: wrap;">
                                            <a  href="{{ route('product.edit' ,$product->id) }}">
                                                {{$product->sku}}</a>
                                            </td>
                                            <td style="width: 5px; ">
                                                {{$product->name}}
                                            </td>
                                            <td style="width: 1px; white-space: nowrap;">
                                                {{$product->category}}
                                            </td>
                                            <td style="width: 1px; white-space: nowrap;">
                                                {{$product->vendor}}
                                            </td>
                                            <td style="width: 1px; white-space: nowrap;">
                                                {{$product->instance->name}}
                                            </td>
                                            <td style="width: 1px; white-space: nowrap;">
                                                Actions
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td>Empty</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>


                @endsection



                @section('js')
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
                <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.4/b-flash-1.6.4/b-html5-1.6.4/b-print-1.6.4/datatables.min.js"></script>
                <script src="{{URL::asset('assets/js/datatables.js')}}"></script>

                @endsection
