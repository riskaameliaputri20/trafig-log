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
            '#27ae60', // 200 - Hijau Tegas
            '#f04f26', // 300 - Kuning-Oranye Tegas
            '#ff0019', // 400 - Oranye Gelap
            '#6b030f' // 500 - Merah Gelap
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
