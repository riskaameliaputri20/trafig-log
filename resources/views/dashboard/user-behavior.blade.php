@use('Carbon\Carbon')
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                series: [{
                    name: "Total Requests",
                    data: @json($userBehavior->pluck('total_requests'))
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 5,
                        horizontal: false,
                        distributed: true
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: @json($userBehavior->pluck('ip_address')),
                    title: {
                        text: 'IP Address'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Request'
                    }
                },
                colors: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444'],
                title: {
                    text: 'Aktivitas Pengguna Berdasarkan Jumlah Request',
                    align: 'left'
                },
                tooltip: {
                    y: {
                        formatter: (val) => val + " request"
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#userBehaviorChart"), options);
            chart.render();
        });
    </script>
@endpush
<x-layouts.dashboard>
    <!-- 🔹 Summary Section -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium mb-2">Total Unique IPs</p>
                            <h4 class="mb-0">{{ $userBehavior->count() }}</h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-circle fs-4">
                                <i class="ri-computer-line"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium mb-2">Top Active IP</p>
                            <h4 class="mb-0">
                                {{ $userBehavior->first()['ip_address'] ?? '-' }}
                            </h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success rounded-circle fs-4">
                                <i class="ri-user-location-line"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 🔹 Main Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <h5 class="card-title mb-0">Detailed User Behavior</h5>
                    <a href="{{ route('dashboard.export.user-behavior') }}" class="btn btn-success">
                        Export Laporan
                    </a>
                </div>
                <h5 class="card-title mb-0">Detailed User Behavior</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-light text-nowrap">
                            <tr>
                                <th>IP Address</th>
                                <th>Requests</th>
                                <th>Duration (min)</th>
                                <th>Avg Click Gap (s)</th>
                                <th>Behavior Type</th>
                                <th>First Page</th>
                                <th>Last Page</th>
                                <th>Clickstream</th>
                                <th>First Seen</th>
                                <th>Last Seen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($userBehavior as $user)
                                <tr>
                                    <td><span class="fw-medium">{{ $user['ip_address'] }}</span></td>
                                    <td>{{ $user['total_requests'] }}</td>
                                    <td>
                                        @php
                                            $durationDisplay = '-';
                                            if ($user['duration_minutes'] > 0) {
                                                $start = Carbon::parse($user['first_seen']);
                                                $end = Carbon::parse($user['last_seen']);
                                                $durationDisplay = $start->diffForHumans($end, [
                                                    'parts' => 2,
                                                    'short' => false,
                                                    'syntax' => Carbon::DIFF_ABSOLUTE,
                                                ]);
                                            }
                                        @endphp
                                        {{ $durationDisplay }}
                                    </td>
                                    <td>{{ $user['avg_click_gap_sec'] }}</td>
                                    <td>
                                        @if ($user['behavior_type'] === 'possible bot / crawler')
                                            <span class="badge bg-danger">Crawler / Bot</span>
                                        @elseif ($user['behavior_type'] === 'high activity user')
                                            <span class="badge bg-warning text-dark">High Activity</span>
                                        @else
                                            <span class="badge bg-success">Normal</span>
                                        @endif
                                    </td>
                                    <td><code>{{ Str::limit($user['first_page'], 40) }}</code></td>
                                    <td><code>{{ Str::limit($user['last_page'], 40) }}</code></td>
                                    <td style="max-width: 300px;">
                                        <small class="text-muted d-block text-truncate"
                                            title="{{ $user['clickstream'] }}">
                                            {{ Str::limit($user['clickstream'], 100) }}
                                        </small>
                                    </td>
                                    <td>{{ $user['first_seen']->format('d M Y H:i') }}</td>
                                    <td>{{ $user['last_seen']->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        <i class="ri-information-line me-1"></i>
                                        No user behavior data available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- 🔹 Chart -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">User Request Activity Chart</h5>
                </div>
                <div class="card-body">
                    <div id="userBehaviorChart" class="apex-charts" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
