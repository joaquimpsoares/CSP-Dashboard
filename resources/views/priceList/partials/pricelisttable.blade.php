{{-- <div class="card">
    <div class="">
        <div class="card-body">
            @if(Auth::user()->userLevel->id === 3)
            <div class="md-form">
                <div style="display: flex;">
                    <div style="flex-grow: 31;">
                    </div>
                    <div>
                        <a type="submit" href="{{route('priceList.create')}}" class="btn btn-primary"><i class="mr-2 fe fe-plus"></i>{{ ucwords(__('messages.new_pricelist')) }}</a>
                    </div>
                </div>
            </div>
            @endif
            <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.price_list_table', 1)) }}</a></h4>
            <div class="table-responsive">
                <table id="example" class="table table-bordered text-nowrap key-buttons">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>{{ ucwords(trans_choice('messages.name', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.description', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.provider', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.reseller', 2)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.customer', 2)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.action', 2)) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($priceLists as $priceList)
                        <tr>
                            <td></td>
                            <td><a href="{{route('priceList.prices', $priceList['id']) }}">{{ $priceList['name'] }}</a></td>
                            <td>{{ $priceList['description'] }}</td>
                            <td>{{ $priceList['provider']['company_name'] ?? null }}</td>
                            <td>{{ $priceList['reseller']->count() }}</td>
                            <td>{{ $priceList['customer']->count() }}</td>
                            <td>
                                <a href="{{route('priceList.clone', $priceList['id'])}}"><i class="fa fa-clone"></i></a>
                                <a href="{{route('priceList.prices', $priceList['id']) }}"><i class="fa fa-list"></i></a>
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
    </div> --}}

<style>
    		/*Form fields*/
		.dataTables_wrapper select,
		.dataTables_wrapper .dataTables_filter input {
			color: #4a5568; 			/*text-gray-700*/
			padding-left: 1rem; 		/*pl-4*/
			padding-right: 1rem; 		/*pl-4*/
			padding-top: .5rem; 		/*pl-2*/
			padding-bottom: .5rem; 		/*pl-2*/
			line-height: 1.25; 			/*leading-tight*/
			border-width: 2px; 			/*border-2*/
			border-radius: .25rem;
			border-color: #edf2f7; 		/*border-gray-200*/
			background-color: #edf2f7; 	/*bg-gray-200*/
		}

		/*Row Hover*/
		table.dataTable.hover tbody tr:hover, table.dataTable.display tbody tr:hover {
			background-color: #ebf4ff;	/*bg-indigo-100*/
		}

		/*Pagination Buttons*/
		.dataTables_wrapper .dataTables_paginate .paginate_button		{
			font-weight: 700;				/*font-bold*/
			border-radius: .25rem;			/*rounded*/
			border: 1px solid transparent;	/*border border-transparent*/
		}

		/*Pagination Buttons - Current selected */
		.dataTables_wrapper .dataTables_paginate .paginate_button.current	{
			color: #fff !important;				/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); 	/*shadow*/
			font-weight: 700;					/*font-bold*/
			border-radius: .25rem;				/*rounded*/
			background: #667eea !important;		/*bg-indigo-500*/
			border: 1px solid transparent;		/*border border-transparent*/
		}

		/*Pagination Buttons - Hover */
		.dataTables_wrapper .dataTables_paginate .paginate_button:hover		{
			color: #fff !important;				/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);	 /*shadow*/
			font-weight: 700;					/*font-bold*/
			border-radius: .25rem;				/*rounded*/
			background: #667eea !important;		/*bg-indigo-500*/
			border: 1px solid transparent;		/*border border-transparent*/
		}

		/*Add padding to bottom border */
		table.dataTable.no-footer {
			border-bottom: 1px solid #e2e8f0;	/*border-b-1 border-gray-300*/
			margin-top: 0.75em;
			margin-bottom: 0.75em;
		}

		/*Change colour of responsive icon*/
		table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
			background-color: #667eea !important; /*bg-indigo-500*/
		}

</style>




    <div id='recipients' class="p-8 mt-6 mb-5 bg-white lg:mt-0">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <div class="table-responsive">
                            <table id="example" class="hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.name', 1)) }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.description', 1)) }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.provider', 1)) }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.reseller', 2)) }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.customer', 2)) }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            {{ ucwords(trans_choice('messages.action', 2)) }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($priceLists as $priceList)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{route('priceList.prices', $priceList['id']) }}">{{ $priceList['name'] }}</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $priceList['description'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $priceList['provider']['company_name'] ?? null }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $priceList['reseller']->count() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $priceList['customer']->count() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-center whitespace-nowrap">
                                            <a href="{{route('priceList.prices', $priceList['id']) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
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
<script>
    		$(document).ready(function() {

			var table = $('#table1').DataTable( {
					responsive: true
				} )
				.columns.adjust()
				.responsive.recalc();
		} );
</script>
