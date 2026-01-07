<div class="card">
    <div class="card-body">
        <div id="chart"></div>
    </div>
</div>

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var seriesData = {
            monthDataSeries1: {
                prices: @json($prices),
                dates: @json($dates)
            }
        };

        var options = {
            series: [{
                name: "Traffic Size (bytes)",
                data: seriesData.monthDataSeries1.prices
            }],
            chart: {
                type: 'area',
                height: 350,
                zoom: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 1,
                curve: 'monotoneCubic'
            },
            title: {
                text: 'Traffic Response Size per Access Time',
                align: 'left'
            },
            xaxis: {
                type: 'datetime',
                categories: seriesData.monthDataSeries1.dates,
                labels: {
                    datetimeFormatter: {
                        year: 'yyyy',
                        month: "MMM 'yy",
                        day: 'dd MMM',
                        hour: 'HH:mm'
                    }
                },
                title: {
                    text: 'Access Time (Date & Hour)'
                }
            },
            yaxis: {
                title: {
                    text: 'Response Size (bytes)'
                }
            },
            tooltip: {
                x: {
                    format: 'dd MMM yyyy HH:mm:ss'
                }
            },
            legend: {
                horizontalAlign: 'left'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush
