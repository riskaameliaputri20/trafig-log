<x-layouts.dashboard title="Popular Endpoints">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Analisis Endpoint Terpopuler</h4>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Top 10 Most Accessed Endpoints</h5>
                    <span class="text-muted">Berdasarkan Access Log</span>
                </div>

                <div class="card-body">

                    @if ($endpointStats->isEmpty())
                        <div class="alert alert-warning">
                            Tidak ada data endpoint ditemukan.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Endpoint URL</th>
                                        <th>Total Hit</th>
                                        <th>Persentase (%)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $totalHits = $endpointStats->sum('hit_count');
                                    @endphp

                                    @foreach ($endpointStats as $index => $ep)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <td>
                                                <code>{{ $ep['url'] }}</code>
                                            </td>

                                            <td>{{ number_format($ep['hit_count']) }}</td>

                                            <td>{{ number_format(($ep['hit_count'] / $totalHits) * 100, 2) }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>

</x-layouts.dashboard>
