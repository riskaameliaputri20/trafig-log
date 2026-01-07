@props([
    'traffics' => [],
])

<div class="flex flex-col">
    <div class="overflow-x-auto custom-scrollbar">
        <table
            id="tableTrafikLog"
            class="w-full text-left border-collapse"
        >
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th
                        class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        No.</th>
                    <th
                        class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        IP Address</th>
                    <th
                        class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        Method</th>
                    <th
                        class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        Endpoint / URL</th>
                    <th
                        class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        Status</th>
                    <th
                        class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        Size</th>
                    <th
                        class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        Access Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($traffics as $trafficLog)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4 text-xs font-bold text-slate-400">
                            {{ ($traffics->currentPage() - 1) * $traffics->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="font-mono text-xs font-black text-slate-700 bg-slate-100 px-2 py-1 rounded-md"
                            >
                                {{ $trafficLog['ip_address'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $methodColor = match (strtoupper($trafficLog['request_method'])) {
                                    'GET' => 'text-blue-600 bg-blue-50 border-blue-100',
                                    'POST' => 'text-emerald-600 bg-emerald-50 border-emerald-100',
                                    'PUT', 'PATCH' => 'text-amber-600 bg-amber-50 border-amber-100',
                                    'DELETE' => 'text-rose-600 bg-rose-50 border-rose-100',
                                    default => 'text-slate-600 bg-slate-50 border-slate-100',
                                };
                            @endphp
                            <span
                                class="px-2 py-0.5 border rounded-md text-[10px] font-black {{ $methodColor }}"
                            >
                                {{ $trafficLog['request_method'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p
                                class="text-xs font-medium text-slate-600 truncate max-w-[200px] xl:max-w-xs italic"
                                title="{{ $trafficLog['request_uri'] }}"
                            >
                                {{ $trafficLog['request_uri'] }}
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColor = match (true) {
                                    $trafficLog['status_code'] < 300 => 'bg-emerald-500 text-white',
                                    $trafficLog['status_code'] < 400 => 'bg-blue-500 text-white',
                                    $trafficLog['status_code'] < 500 => 'bg-amber-500 text-white',
                                    default => 'bg-rose-500 text-white',
                                };
                            @endphp
                            <span
                                class="px-2 py-1 {{ $statusColor }} rounded text-[10px] font-black shadow-sm"
                            >
                                {{ $trafficLog['status_code'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-slate-500">
                                {{ Number::format($trafficLog['response_size'] / 1024, 2) }} <span
                                    class="text-[10px] text-slate-400"
                                >MB</span>
                            </span>
                        </td>
                        <td
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-tight">
                            {{ $trafficLog['access_time'] }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="7"
                            class="px-6 py-12 text-center"
                        >
                            <div class="flex flex-col items-center">
                                <i class="ri-inbox-line text-4xl text-slate-200"></i>
                                <p
                                    class="text-sm font-bold text-slate-400 mt-2 uppercase tracking-widest">
                                    No Traffic Data Found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-6 bg-slate-50/50 border-t border-slate-100">
        {{ $traffics->links() }}
    </div>
</div>
