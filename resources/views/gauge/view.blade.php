


<x-layout>

    <div class="mb-50"><a href="/gauge">Alle Messwerte</a></div>

    <h3>{{ $subtype }}   </h3>


           <canvas id="myChart" width="400" height="400"></canvas>

    <ul>
        @foreach($all as $journal)
            <li>
                {{$journal->date}}:
                    {{ $journal->value }}
                @if(!empty($journal->text)): {{ $journal->text }} @endif
            </li>
        @endforeach

    </ul>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script>
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    label: '{{ $subtype }}',
                    data: {{ json_encode($chartData) }},
                }]
            },
            options: {
                scales: {
                    x:  {
                        type: 'time',
                        time: {
                            parsing: false,
                            unit: 'day'
                        }
                    }
                }
            }
        });
    </script>


</x-layout>
