<div class="card">
    <div class="card-body">
        <div id="pieChartStatus"></div>
    </div>
</div>
<script>
    var options = {
        series: @json($statusCounts->values()), // Jumlah per status
        chart: {
            height: 365,
            type: 'pie',
        },
        colors: [
            '#27ae60', // Hijau
            '#f0b426', // Kuning-oranye muda
            '#f04f26', // Oranye tegas
            '#ff0019', // Oranye gelap
            '#6b030f', // Merah gelap
            '#4b0108' // Merah tua
        ],
        labels: @json($statusCounts->keys()), // Daftar status code
        title: {
            text: 'HTTP Status Code Distribution',
            align: 'center'
        },
        legend: {
            position: 'bottom'
        }
    };

    var chart = new ApexCharts(document.querySelector("#pieChartStatus"), options);
    chart.render();
</script>
