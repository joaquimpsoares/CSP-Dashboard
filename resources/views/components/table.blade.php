<div class="mt-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full px-4 py-1 align-middle">
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        @foreach($columns as $column => $link)
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase @if(!in_array($column, $mobileColumns)) hidden lg:table-cell @endif">{{ Str::title(trans_choice('messages.'.$column, 1)) }}</th>
                        @endforeach
                        <th scope="col" class="relative px-2 py-2"><span class="sr-only">{{ ucwords(trans_choice('messages.action', 1)) }}</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($list as $item)
                        <tr class="hover:bg-gray-100">
                            @foreach ($columns as $column => $link)
                                <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap @if(!in_array($column, $mobileColumns)) hidden lg:table-cell @endif">
                                    @if($link)
                                        <a href="{{ $link($item) }}">{{ Arr::get($item->getAttributes(), $column) }}</a>
                                    @else
                                        {{ Arr::get($item->getAttributes(), $column) }}
                                    @endif
                                </td>
                            @endforeach

                            <td class="px-2 py-2 text-sm font-medium text-right whitespace-nowrap">
                                <div class="z-10">
                                    <button type="button" class="px-1 py-1 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        @foreach ($listElementActions as $action)
                                            <a class="dropdown-item" href="{{ $action['url']($item) }}">
                                                <img class="inline w-5 h-5 mr-2" src="data:image/svg+xml;base64,{{ $action['icon'] }}" />
                                                {{ $action['textKey'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5">Empty</td>
                    </tr>
                    @endforelse
                    <!-- More people... -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center mt-4">
        {{ $list->links() }}
    </div>
</div>
