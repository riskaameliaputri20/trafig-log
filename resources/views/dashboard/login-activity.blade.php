<x-layouts.dashboard title="Login Activity Monitor">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic">
                Login <span class="text-emerald-500">Security</span>
            </h2>
            <p class="text-sm text-slate-500 font-medium italic">Monitoring authentication attempts and suspicious patterns</p>
        </div>
        <a href="{{ route('dashboard.export.login-activity') }}" 
           class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200">
            <i class="ri-file-shield-2-line text-sm"></i> Export Security Log
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4 group">
            <div class="size-12 bg-slate-50 text-slate-600 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="ri-shield-user-line text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Requests</p>
                <h4 class="text-3xl font-black text-slate-900 tracking-tighter">{{ number_format($summary['total_login_requests']) }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-rose-100 shadow-sm flex items-center gap-4 group">
            <div class="size-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="ri-error-warning-line text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-rose-400 uppercase tracking-[0.2em]">Failed Attempts</p>
                <h4 class="text-3xl font-black text-rose-600 tracking-tighter">{{ number_format($summary['failed_by_ip']->sum()) }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm flex items-center gap-4 group">
            <div class="size-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="ri-checkbox-circle-line text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em]">Success Auth</p>
                <h4 class="text-3xl font-black text-emerald-600 tracking-tighter">{{ number_format($summary['success_by_ip']->sum()) }}</h4>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        
        <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50">
                <h5 class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Top Login Attempts</h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($summary['attempt_by_ip'] as $ip => $count)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-[10px] font-bold text-slate-400">#{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-mono text-xs font-black text-slate-700">{{ $ip }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="px-2 py-1 bg-slate-100 rounded text-[10px] font-black text-slate-600">{{ $count }} Hits</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="lg:col-span-7 bg-white rounded-3xl border border-rose-100 shadow-sm overflow-hidden relative">
            <div class="px-6 py-4 border-b border-rose-50 bg-rose-600 flex items-center gap-3">
                <span class="size-2 bg-white rounded-full animate-ping"></span>
                <h5 class="text-[10px] font-black text-white uppercase tracking-widest">Suspicious Activity Detected</h5>
            </div>
            
            <div class="overflow-x-auto">
                @if ($summary['suspicious']->isEmpty())
                    <div class="p-12 text-center text-slate-400 font-medium italic text-xs">
                        <i class="ri-shield-check-line text-4xl text-emerald-500 block mb-2"></i>
                        Tidak ada aktivitas mencurigakan saat ini.
                    </div>
                @else
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-rose-50 text-[10px] font-black text-rose-400 uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-3">Source IP</th>
                                <th class="px-6 py-3 text-center">Reason</th>
                                <th class="px-6 py-3 text-right">Fail Count</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-rose-50">
                            @foreach ($summary['suspicious'] as $item)
                                <tr class="bg-rose-50/20 hover:bg-rose-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-mono text-xs font-black text-rose-700">{{ $item['ip'] }}</span>
                                            <span class="text-[9px] text-rose-400 uppercase font-bold mt-1">{{ $item['last_attempt']->diffForHumans() }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 bg-rose-600 text-white rounded text-[9px] font-black uppercase tracking-tighter">{{ $item['reason'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-rose-600 text-sm">
                                        {{ $item['fail_count'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex items-center justify-between">
            <div>
                <h5 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em]">Full Login Logs</h5>
                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Audit trail for all authentication requests</p>
            </div>
        </div>

        <div class="overflow-x-auto whitespace-nowrap">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">IP Address</th>
                        <th class="px-6 py-4">Device / User Agent</th>
                        <th class="px-6 py-4">Time</th>
                        <th class="px-6 py-4 text-right">Request Path</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($raw as $row)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                @php
                                    $isSuccess = in_array($row['status_code'], [200, 302]);
                                @endphp
                                <span class="px-2 py-1 {{ $isSuccess ? 'bg-emerald-500' : 'bg-rose-500' }} text-white rounded text-[10px] font-black shadow-sm">
                                    {{ $row['status_code'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs font-black text-slate-700">{{ $row['ip_address'] }}</td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-medium text-slate-500 italic block max-w-xs truncate" title="{{ $row['user_agent'] }}">
                                    {{ $row['user_agent'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                {{ $row['access_time']->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <code class="text-[10px] text-slate-500 font-bold bg-slate-100 px-2 py-1 rounded">
                                    {{ $row['request_method'] }} {{ $row['request_uri'] }}
                                </code>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-slate-50/50 border-t border-slate-100">
            {{ $raw->links() }}
        </div>
    </div>

</x-layouts.dashboard>