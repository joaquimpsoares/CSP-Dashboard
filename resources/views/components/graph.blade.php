<div class="flex-grow px-4 sm:p-6">
    <div class="flex items-center ">
        <h3 class="text-sm text-gray-600 md:font-semibold md:text-lg">{{ $headerTitle }}</h3>
    </div>
    <canvas id="chartjs-{{ $randomNumber = rand() }}" class="chartjs" width="undefined" height="undefined"></canvas>
    <script>
        new Chart(document.getElementById("chartjs-{{ $randomNumber }}"), {
            "type": "line",
            "data": {
                "labels": {!! json_encode($labels) !!},
                "datasets": [
                {
                    "label": "{{ $legendName ?? 'Item' }}",
                    "data": {!! json_encode($data) !!},
                    "fill": true,
                    "borderColor": "rgb(99, 102, 241, 1)",
                    "backgroundColor": "rgb(198, 199, 231, 0.4)",
                    "lineTension": 0.5
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }
        });
    </script>
</div>
