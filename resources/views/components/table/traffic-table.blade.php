@props([
    'traffics' => [],
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
        </tr>
    </thead>
    <tbody>
        @foreach ($traffics as $trafficLog)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $trafficLog['ip_address'] }}</td>
                <td>{{ $trafficLog['request_method'] }}</td>
                <td>{{ $trafficLog['request_uri'] }}</td>
                <td>{{ $trafficLog['status_code'] }}</td>
                {{-- <td>{{ $trafficLog->user_agent }}</td> --}}
                <td>{{ Number::format($trafficLog['response_size']) }} KB</td>
                {{-- <td>{{ $trafficLog->referrer }}</td> --}}
                <td>{{ $trafficLog['access_time'] }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
{{ $traffics->links('pagination::bootstrap-5') }}
