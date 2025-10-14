@props([
    'traffics' => []
])

<table id="tableTrafikLog" class="table table-bordered table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">No.</th>
            <th>Ip Address</th>
            <th>Method</th>
            <th>Url</th>
            <th>Status Code</th>
            {{-- <th>User Agent</th> --}}
            <th>Response Size</th>
            {{-- <th>Referrer</th> --}}
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
            {{-- <td>{{ $trafficLog->user_agent }}</td> --}}
            <td>{{ $trafficLog->response_size }}</td>
            {{-- <td>{{ $trafficLog->referrer }}</td> --}}
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
