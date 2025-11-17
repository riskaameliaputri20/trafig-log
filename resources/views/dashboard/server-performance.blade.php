@push('style')
    <style>
        .perf-box h4 {
            font-weight: 700;
            margin-bottom: 0;
        }

        .perf-status {
            font-size: 0.8rem;
        }
    </style>
@endpush

<x-layouts.dashboard title="Server Performance">

    <h3 class="mb-4">📊 Analisis Kinerja Server</h3>

    <div class="row">

        {{-- ======================= CPU USAGE ======================= --}}
        <div class="col-xl-4 col-md-6">
            <div class="card card-animate shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">CPU Usage</h5>
                </div>
                <div class="card-body">
                    <div class="perf-box">
                        <h4>
                            @if ($cpuUsage === null)
                                <span class="text-muted">Not Supported (Windows)</span>
                            @else
                                {{ $cpuUsage }}%
                            @endif
                        </h4>

                        @php
                            $cpuStatus = 'success';
                            $cpuText = 'Normal';
                            if ($cpuUsage >= 70) {
                                $cpuStatus = 'danger';
                                $cpuText = 'Critical';
                            } elseif ($cpuUsage >= 40) {
                                $cpuStatus = 'warning';
                                $cpuText = 'High Load';
                            }
                        @endphp

                        <span class="badge bg-{{ $cpuStatus }} perf-status">{{ $cpuText }}</span>

                        <div class="progress mt-3" style="height: 8px;">
                            <div class="progress-bar bg-{{ $cpuStatus }}" role="progressbar"
                                style="width: {{ $cpuUsage ?? 0 }}%">
                            </div>
                        </div>

                        <small class="text-muted d-block mt-2">
                            Semakin tinggi load, semakin berat server bekerja.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================= MEMORY USAGE ======================= --}}
        <div class="col-xl-4 col-md-6">
            <div class="card card-animate shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Memory Usage</h5>
                </div>
                <div class="card-body">

                    @php
                        $memTotal = $memoryTotal;
                        $memFree = $memoryFree;
                        $memUsed = $memTotal - $memFree;
                        $memPercent = $memTotal > 0 ? round(($memUsed / $memTotal) * 100, 2) : 0;

                        $memStatus = 'success';
                        $memText = 'Normal';
                        if ($memPercent >= 80) {
                            $memStatus = 'danger';
                            $memText = 'Low Memory';
                        } elseif ($memPercent >= 50) {
                            $memStatus = 'warning';
                            $memText = 'High Usage';
                        }
                    @endphp

                    <h4>{{ $memUsed }} MB / {{ $memTotal }} MB</h4>
                    <span class="badge bg-{{ $memStatus }}">{{ $memText }}</span>

                    <div class="progress mt-3" style="height: 8px;">
                        <div class="progress-bar bg-{{ $memStatus }}" style="width: {{ $memPercent }}%">
                        </div>
                    </div>

                    <p class="mt-3 mb-0">
                        <small class="text-muted">
                            Free Memory: <b>{{ $memFree }} MB</b>
                        </small>
                    </p>
                </div>
            </div>
        </div>

        {{-- ======================= DISK USAGE ======================= --}}
        <div class="col-xl-4 col-md-6">
            <div class="card card-animate shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Disk Usage</h5>
                </div>
                <div class="card-body">
                    @php
                        $diskPercent = round(($diskUsed / $diskTotal) * 100, 2);

                        $diskStatus = 'success';
                        $diskText = 'Normal';
                        if ($diskPercent >= 85) {
                            $diskStatus = 'danger';
                            $diskText = 'Critical (Almost Full)';
                        } elseif ($diskPercent >= 60) {
                            $diskStatus = 'warning';
                            $diskText = 'High Usage';
                        }
                    @endphp

                    <h4>{{ $diskUsed }} GB / {{ $diskTotal }} GB</h4>
                    <span class="badge bg-{{ $diskStatus }}">{{ $diskText }}</span>

                    <div class="progress mt-3" style="height: 8px;">
                        <div class="progress-bar bg-{{ $diskStatus }}" style="width: {{ $diskPercent }}%">
                        </div>
                    </div>

                    <p class="mt-3">
                        <small class="text-muted">
                            Free Disk: <b>{{ $diskFree }} GB</b>
                        </small>
                    </p>
                </div>
            </div>
        </div>

        {{-- ======================= PHP RUNTIME ======================= --}}
        <div class="col-xl-6 col-md-6 mt-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">PHP Runtime</h5>
                </div>
                <div class="card-body">
                    <p>PHP Memory Limit:
                        <b>{{ $phpMemoryLimit }}</b>
                    </p>
                    <p>Max Execution Time:
                        <b>{{ $maxExecution }} seconds</b>
                    </p>
                </div>
            </div>
        </div>

        {{-- ======================= DATABASE PERFORMANCE ======================= --}}
        <div class="col-xl-6 col-md-6 mt-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Database Performance</h5>
                </div>
                <div class="card-body">

                    @php
                        $dbStatus = 'success';
                        $dbText = 'Fast';

                        if ($dbResponse >= 200) {
                            $dbStatus = 'warning';
                            $dbText = 'Slow Query';
                        }
                        if ($dbResponse >= 500) {
                            $dbStatus = 'danger';
                            $dbText = 'Critical Delay';
                        }
                    @endphp

                    <h4>{{ $dbResponse }} ms</h4>
                    <span class="badge bg-{{ $dbStatus }}">{{ $dbText }}</span>

                    <small class="text-muted d-block mt-2">
                        Ini gambaran kecepatan query sederhana pada DB.
                    </small>
                </div>
            </div>
        </div>

    </div>

</x-layouts.dashboard>
