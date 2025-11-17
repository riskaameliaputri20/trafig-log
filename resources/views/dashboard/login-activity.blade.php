@push('style')
    <style>
        table td,
        table th {
            white-space: nowrap;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endpush

<x-layouts.dashboard title="Login Activity">

    <div class="row">
        <div class="col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="fw-medium text-muted mb-0">Total Login Requests</p>
                    <h2 class="mt-3 ff-secondary fw-bold">
                        {{ $summary['total_login_requests'] }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="fw-medium text-muted mb-0">Failed Login</p>
                    <h2 class="mt-3 ff-secondary fw-bold">
                        {{ $summary['failed_by_ip']->sum() }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="fw-medium text-muted mb-0">Successful Login</p>
                    <h2 class="mt-3 ff-secondary fw-bold">
                        {{ $summary['success_by_ip']->sum() }}
                    </h2>
                </div>
            </div>
        </div>
    </div>


    {{-- TOP LOGIN ATTEMPT --}}
    <div class="card mt-4 shadow-none">
        <div class="card-header bg-dark text-white">
            <h5 class="card-title mb-0">Top Login Attempts</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover text-nowrap align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>IP Address</th>
                        <th>Attempts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summary['attempt_by_ip'] as $ip => $count)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $ip }}</td>
                            <td>{{ $count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- SUSPICIOUS LOGIN --}}
    <div class="card mt-4 shadow-none">
        <div class="card-header bg-danger text-white">
            <h5 class="card-title mb-0">Suspicious Login Attempts</h5>
        </div>

        <div class="card-body table-responsive">
            @if ($summary['suspicious']->isEmpty())
                <div class="alert alert-success mb-0 text-center">
                    Tidak ada aktivitas mencurigakan 🎉
                </div>
            @else
                <table class="table table-hover text-nowrap align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>IP Address</th>
                            <th>Reason</th>
                            <th>Fail Count</th>
                            <th>Last Attempt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($summary['suspicious'] as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item['ip'] }}</td>
                                <td><span class="badge bg-danger">{{ $item['reason'] }}</span></td>
                                <td>{{ $item['fail_count'] }}</td>
                                <td>{{ $item['last_attempt']->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>


    {{-- RAW DATA LOGIN --}}
    <div class="card mt-4 shadow-none">
        <div class="card-header">
            <h5 class="card-title mb-0">Login Log Details</h5>
            <small class="text-muted">Semua request ke /login</small>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped text-nowrap align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>IP</th>
                        <th>Status</th>
                        <th>Agent</th>
                        <th>Time</th>
                        <th>Full Request</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($raw as $row)
                        <tr>
                            <td>{{ ($raw->currentPage() - 1) * $raw->perPage() + $loop->iteration }}</td>
                            <td>{{ $row['ip_address'] }}</td>

                            <td>
                                @if ($row['status_code'] == 200 || $row['status_code'] == 302)
                                    <span class="badge bg-success">{{ $row['status_code'] }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $row['status_code'] }}</span>
                                @endif
                            </td>

                            <td>{{ $row['user_agent'] }}</td>

                            <td>{{ $row['access_time']->diffForHumans() }}</td>

                            <td>
                                <code>{{ $row['request_method'] }} {{ $row['request_uri'] }}</code>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $raw->links() }}
            </div>
        </div>
    </div>

</x-layouts.dashboard>
