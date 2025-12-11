@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Cegah error jika $errorData belum ada
            const errorData = @json(
                $errorData ?? [
                    'errors_by_code' => [],
                    'errors_over_time' => [],
                ]
            );

            // Pastikan data ada sebelum dipakai
            const errorsByCode = errorData.errors_by_code || {};
            const errorsOverTime = errorData.errors_over_time || {};

            const errorCounts = Object.values(errorsByCode);
            const errorLabels = Object.keys(errorsByCode);

            const timeCatsRaw = Object.keys(errorsOverTime);
            const timeCatsISO = timeCatsRaw.map(c => {
                if (!c) return c;
                if (c.includes('T')) return c; // sudah ISO
                // contoh: "2025-10-28 13:00" => "2025-10-28T13:00:00"
                return c.replace(' ', 'T') + ':00';
            });

            const errorsOverTimeValues = Object.values(errorsOverTime);

            // Chart 1: distribusi error code
            if (document.querySelector("#errorCodeChart")) {
                var errorCodeChart = new ApexCharts(document.querySelector("#errorCodeChart"), {
                    chart: {
                        type: 'donut',
                        height: 350
                    },
                    series: errorCounts,
                    labels: errorLabels,
                    title: {
                        text: 'Error Codes Distribution'
                    },
                    legend: {
                        position: 'bottom'
                    },
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            chart: {
                                height: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                });
                errorCodeChart.render();
            }

            // Chart 2: tren error dari waktu ke waktu
            if (document.querySelector("#errorTimelineChart")) {
                var errorTimelineChart = new ApexCharts(document.querySelector("#errorTimelineChart"), {
                    chart: {
                        type: 'area',
                        height: 350,
                        zoom: {
                            enabled: true
                        }
                    },
                    series: [{
                        name: "Error Count",
                        data: errorsOverTimeValues
                    }],
                    xaxis: {
                        categories: timeCatsISO,
                        type: 'datetime',
                        title: {
                            text: 'Time (Hour)'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Errors'
                        }
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ['#ef4444'],
                    fill: {
                        opacity: 0.3
                    },
                    tooltip: {
                        x: {
                            format: 'dd MMM yyyy HH:mm'
                        }
                    },
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            chart: {
                                height: 300
                            }
                        }
                    }]
                });
                errorTimelineChart.render();
            }

        });
    </script>
@endpush


<x-layouts.dashboard>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card mini-stats-wid border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Errors</p>
                    <h4 class="fw-semibold mb-0">{{ $errorData['total_errors'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-2 text-end">
            <a href="{{ route('dashboard.export.error-logs') }}" class="btn btn-success">
                Export Laporan
            </a>
        </div>
    </div>

    {{-- 🔹 Distribusi Kode Error --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">Error Distribution by Status Code</h5>
        </div>
        <div class="card-body">
            <div id="errorCodeChart" style="height: 350px;"></div>
        </div>
    </div>

    {{-- 🔹 Top URL & IP --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Top URLs with Errors</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>URL</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($errorData['top_urls'] as $url => $count)
                                <tr>
                                    <td><code>{{ Str::limit($url, 60) }}</code></td>
                                    <td>{{ $count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Top IPs Causing Errors</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>IP Address</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($errorData['top_ips'] as $ip => $count)
                                <tr>
                                    <td>{{ $ip }}</td>
                                    <td>{{ $count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 Chart Error Over Time --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">Error Trend Over Time</h5>
        </div>
        <div class="card-body">
            <div id="errorTimelineChart" style="height: 350px;"></div>
        </div>
    </div>

</x-layouts.dashboard>
