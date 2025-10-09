@push('style')
<style>
    /* Supaya teks tidak pindah baris */
    table td, table th {
        white-space: nowrap;
    }

    /* Tambahan biar tabel tetap bisa scroll kalau lebar */
    .table-responsive {
        overflow-x: auto;
    }
</style>
@endpush
<x-layouts.dashboard title="Dashboard Page" >
    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Total Request Hari Ini</p>
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $trafikCountToday }}">{{ $trafikCountToday }}</span>k</h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users text-info material-shadow"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
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
                            <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $trafikCount }}">{{ $trafikCount }}</span>k</h2>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users text-info material-shadow"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div> <!-- end card-->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Basic Datatables</h5>
                </div>
                <div class="card-body table-responsive">
                    <table id="tableTrafikLog" class="table table-bordered table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th data-ordering="false">No.</th>
                                <th>Ip Address</th>
                                <th>Method</th>
                                <th>Url</th>
                                <th>Status Code</th>
                                <th>User Agent</th>
                                <th>Response Size</th>
                                <th>Referrer</th>
                                <th>Access Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($traffics as $trafficLog )
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $trafficLog->ip_address }}</td>
                                <td>{{ $trafficLog->request_method }}</td>
                                <td>{{ $trafficLog->request_uri }}</td>
                                <td>{{ $trafficLog->status_code }}</td>
                                <td>{{ $trafficLog->user_agent }}</td>
                                <td>{{ $trafficLog->response_size }}</td>
                                <td>{{ $trafficLog->referrer }}</td>
                                <td>{{ $trafficLog->access_time }}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                            <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                            <li>
                                                <a class="dropdown-item remove-item-btn">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $traffics->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div><!--end col-->
    </div>
</x-layouts.dashboard>

