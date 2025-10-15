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
            name: "Traffic Size (KB)",
            data: seriesData.monthDataSeries1.prices
        }],
        chart: {
            type: 'area',
            height: 350,
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        title: {
            text: 'Traffic Response Size (KB)',
            align: 'left'
        },
        subtitle: {
            text: 'Based on Access Time',
            align: 'left'
        },
        labels: seriesData.monthDataSeries1.dates,
        xaxis: {
            type: 'datetime',
        },
        yaxis: {
            opposite: true
        },
        legend: {
            horizontalAlign: 'left'
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
@endpush
