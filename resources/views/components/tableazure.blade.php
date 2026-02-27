<div class="mt-2 overflow-visible sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full px-4 py-1 align-middle">
        <!-- Keep horizontal scroll for the table, but allow dropdowns/menus to escape -->
        <div class="overflow-x-auto overflow-y-visible">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        {{ $head }}
                    </tr>
                </thead>

                <tbody>
                    {{ $body }}
                </tbody>
            </table>
        </div>
        <hr>
    </div>
</div>
