<x-layouts.dashboard title="Error Log Analysis">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic">
                Error <span class="text-rose-600">Analysis</span>
            </h2>
            <p class="text-sm text-slate-500 font-medium italic">Diagnostic reports for 4xx and 5xx status codes</p>
        </div>
        <a href="{{ route('dashboard.export.error-logs') }}" 
           class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200">
            <i class="ri-file-warning-line text-sm"></i> Export Error Report
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 size-24 bg-rose-50 rounded-full group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total System Errors</p>
                    <h4 class="text-5xl font-black text-rose-600 tracking-tighter italic">
                        {{ number_format($errorData['total_errors'] ?? 0) }}
                    </h4>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="size-2 bg-rose-500 rounded-full animate-ping"></span>
                        <span class="text-[10px] font-bold text-rose-500 uppercase">Action required</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h5 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-6">Distribution</h5>
                <div id="errorCodeChart" class="min-h-[300px]"></div>
            </div>
        </div>

        <div class="lg:col-span-8 bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h5 class="text-xs font-black text-slate-900 uppercase tracking-widest">Error Trend Over Time</h5>
                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 italic">Real-time incidents tracking</p>
                </div>
                <div class="size-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center border border-slate-100">
                    <i class="ri-line-chart-line text-lg"></i>
                </div>
            </div>
            <div id="errorTimelineChart" class="min-h-[350px]"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center gap-3">
                <i class="ri-link text-rose-500"></i>
                <h5 class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Top Broken Endpoints</h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($errorData['top_urls'] as $url => $count)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <code class="text-[10px] text-rose-600 bg-rose-50 px-2 py-1 rounded truncate block max-w-xs xl:max-w-md italic">
                                        {{ $url }}
                                    </code>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-xs font-black text-slate-700">{{ $count }} <span class="text-[9px] text-slate-400 uppercase ml-1">Hits</span></span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center gap-3">
                <i class="ri-user-unfollow-line text-rose-500"></i>
                <h5 class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Suspect IP Addresses</h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($errorData['top_ips'] as $ip => $count)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs font-black text-slate-700">{{ $ip }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-xs font-black text-slate-700">{{ $count }} <span class="text-[9px] text-slate-400 uppercase ml-1">Hits</span></span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const errorData = @json($errorData ?? ['errors_by_code' => [], 'errors_over_time' => []]);
            const errorsByCode = errorData.errors_by_code || {};
            const errorsOverTime = errorData.errors_over_time || {};

            const timeCatsISO = Object.keys(errorsOverTime).map(c => {
                if (!c) return c;
                return c.replace(' ', 'T') + (c.includes('T') ? '' : ':00');
            });

            // Chart 1: Donut Error Codes
            if (document.querySelector("#errorCodeChart")) {
                new ApexCharts(document.querySelector("#errorCodeChart"), {
                    series: Object.values(errorsByCode),
                    labels: Object.keys(errorsByCode),
                    chart: { type: 'donut', height: 300, fontFamily: 'Inter' },
                    colors: ['#ef4444', '#f59e0b', '#6366f1', '#10b981', '#64748b'],
                    dataLabels: { enabled: false },
                    legend: { position: 'bottom', fontSize: '10px', fontWeight: 700 },
                    stroke: { width: 2, colors: ['#ffffff'] },
                    tooltip: { theme: 'dark' },
                    plotOptions: { pie: { donut: { size: '75%' } } }
                }).render();
            }

            // Chart 2: Timeline Area
            if (document.querySelector("#errorTimelineChart")) {
                new ApexCharts(document.querySelector("#errorTimelineChart"), {
                    series: [{ name: "Incidents", data: Object.values(errorsOverTime) }],
                    chart: { type: 'area', height: 350, fontFamily: 'Inter', toolbar: { show: false } },
                    xaxis: { 
                        categories: timeCatsISO, 
                        type: 'datetime',
                        labels: { style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 600 } }
                    },
                    yaxis: { labels: { style: { colors: '#94a3b8', fontSize: '10px' } } },
                    colors: ['#ef4444'],
                    stroke: { curve: 'smooth', width: 3 },
                    fill: { type: 'gradient', gradient: { opacityFrom: 0.3, opacityTo: 0 } },
                    grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                    dataLabels: { enabled: false },
                    tooltip: { theme: 'dark', x: { format: 'dd MMM HH:mm' } }
                }).render();
            }
        });
    </script>
@endpush
</x-layouts.dashboard>

