@push('style')
    <style>
        /* Supaya teks tidak pindah baris */
        table td,
        table th {
            white-space: nowrap;
        }

        /* Tambahan biar tabel tetap bisa scroll kalau lebar */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endpush
<x-layouts.dashboard title="Dashboard Page">

    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Total Request Hari Ini</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                    data-target="{{ $trafikCountToday }}">{{ $trafikCountToday }}</span></h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-users text-info material-shadow">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div> <!-- end card-->
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Total Request</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                    data-target="{{ $trafikCount }}">{{ $trafikCount }}</span></h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-users text-info material-shadow">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div> <!-- end card-->
        </div>
    </div>
    <div class="row">
        @foreach ($statusCounts as $status => $count)
            <x-widget.count class="col-xl-3" :title="'Status Code ' . $status" :count="$count" icon=" ri-code-fill" />
        @endforeach
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('dashboard.uploadFile') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Upload Custom Log</h5>
                        @session('custom_log_path')
                            <!-- Alert Message -->
                            <div class="alert alert-danger material-shadow mb-4" role="alert">
                                <strong>Anda menggunakan Custom Log! </strong> Klik <em>Remove Uploaded</em> untuk kembali
                                ke
                                log sistem.
                            </div>
                        @endsession


                        <!-- Upload Section -->
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-8">
                                <input type="file" class="form-control" id="customLogFile" name="customLogFile" />
                            </div>

                            <div class="col-lg-4 d-flex justify-content-end gap-2">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-upload me-1"></i> Upload File
                                </button>
                                @session('custom_log_path')
                                    <button formaction="{{ route('dashboard.removeFile') }}" formmethod="post"
                                        class="btn btn-danger" type="submit">
                                        <i class="bi bi-trash me-1"></i> Remove Uploaded
                                    </button>
                                @endsession
                            </div>
                            @error('customLogFile')
                                <div class="col-12 mt-0">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Basic Datatables</h5>
                        <a href="{{ route('dashboard.export.parse-log') }}" class="btn btn-success">
                            Export Laporan
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <x-table.traffic-table :traffics="$traffics" />
                </div>
            </div>
        </div><!--end col-->
    </div>
    <div class="row">
        <div class="col-8">
            <x-chart.respon-size-chart />
        </div>
        <div class="col-4">
            <x-chart.status-code-chart />
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center  text-white">
                    <h5 class="card-title mb-0">🛡️ Detected Threats</h5>
                    <a href="{{ route('dashboard.export.threats') }}" class="btn btn-success">
                        Export Laporan
                    </a>
                </div>

                <div class="card-body table-responsive">
                    @if ($threats->isEmpty())
                        <div class="alert alert-success text-center mb-0">
                            <strong>No threats detected 🎉</strong><br>
                            Your system looks safe for now.
                        </div>
                    @else
                        <table class="table table-hover align-middle text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>IP Address</th>
                                    <th>Total Requests</th>
                                    <th>Threat Level</th>
                                    <th>Last Seen</th>
                                    <th>Details</th>
                                    <th>Recommended Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($threats as $index => $t)
                                    @php
                                        $score = $t['score'] ?? 0;
                                        $level = 'Low';
                                        $badge = 'success';
                                        if ($score >= 7) {
                                            $level = 'High';
                                            $badge = 'danger';
                                        } elseif ($score >= 4) {
                                            $level = 'Medium';
                                            $badge = 'warning';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $t['ip_address'] }}</strong>
                                            <a href="https://www.abuseipdb.com/check/{{ $t['ip_address'] }}"
                                                target="_blank" class="text-muted ms-1" title="Check IP Reputation">
                                                <i class="ri-external-link-line"></i>
                                            </a>
                                        </td>
                                        <td>{{ $t['total_requests'] ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $badge }}">
                                                {{ $level }} ({{ $score }})
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($t['last_seen'])->diffForHumans() }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-info" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#details-{{ $index }}">
                                                View Details
                                            </button>

                                            <div class="collapse mt-2" id="details-{{ $index }}">
                                                @if (!empty($t['details']))
                                                    <div class="collapse mt-2" id="details-{{ $index }}">
                                                        <div class="card card-body bg-light border-info">
                                                            @foreach ($t['details'] as $d)
                                                                <div class="d-flex justify-content-between small">
                                                                    <span><strong>{{ $d['type'] }}</strong></span>
                                                                    <span>{{ $d['count'] }} ×</span>
                                                                </div>
                                                                @if (isset($d['recent']))
                                                                    <code
                                                                        class="text-secondary">{{ $d['recent'] }}</code>
                                                                @endif
                                                                <hr class="my-1">
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </td>
                                        <td class="text-end">
                                            @php
                                                $action = $t['recommended_action'] ?? 'monitor';
                                            @endphp
                                            @if ($action === 'block')
                                                <span class="badge bg-danger">BLOCK</span>
                                            @elseif($action === 'rate-limit / captcha')
                                                <span class="badge bg-warning text-dark">RATE-LIMIT</span>
                                            @else
                                                <span class="badge bg-secondary">MONITOR</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- jika threats dipaginate --}}
                        @if (method_exists($threats, 'links'))
                            <div class="mt-3">
                                {{ $threats->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>

</x-layouts.dashboard>
