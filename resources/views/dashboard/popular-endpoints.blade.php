<x-layouts.dashboard title="Popular Endpoints Analysis">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic">
                Popular <span class="text-emerald-500">Endpoints</span>
            </h2>
            <p class="text-sm text-slate-500 font-medium italic">Identification of the most frequently requested routes</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-slate-200">
            <i class="ri-rhythm-line text-emerald-400"></i> Based on Access Logs
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            
            <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                <h5 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Top 10 Most Accessed Endpoints</h5>
                <div class="flex items-center gap-2">
                    <span class="size-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase italic tracking-tighter">Live Analysis</span>
                </div>
            </div>

            <div class="card-body">
                @if ($endpointStats->isEmpty())
                    <div class="p-12 text-center">
                        <div class="size-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="ri-error-warning-line text-4xl"></i>
                        </div>
                        <h4 class="text-lg font-black text-slate-800 uppercase italic">No data found</h4>
                        <p class="text-xs text-slate-500 font-medium tracking-tight">Make sure the Apache log file is uploaded and contains request data.</p>
                    </div>
                @else
                    <div class="overflow-x-auto whitespace-nowrap">
                        <table class="w-full text-left align-middle">
                            <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <tr>
                                    <th class="px-6 py-4">#</th>
                                    <th class="px-6 py-4">Endpoint URL</th>
                                    <th class="px-6 py-4">Total Hit</th>
                                    <th class="px-6 py-4 text-right">Popularity (Percentage)</th>
                                </tr>
                            </thead>

                            @php
                                $totalHits = $endpointStats->sum('hit_count');
                            @endphp

                            <tbody class="divide-y divide-slate-50">
                                @foreach ($endpointStats as $index => $ep)
                                    @php
                                        $percentage = ($totalHits > 0) ? ($ep['hit_count'] / $totalHits) * 100 : 0;
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-black text-slate-300">#{{ $index + 1 }}</span>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="size-8 bg-slate-50 text-slate-400 rounded-lg flex items-center justify-center border border-slate-100 group-hover:bg-emerald-50 group-hover:text-emerald-600 transition-colors">
                                                    <i class="ri-link text-sm"></i>
                                                </div>
                                                <code class="text-[10px] font-bold text-slate-600 bg-slate-50 px-2 py-1 rounded border border-slate-100">
                                                    {{ $ep['url'] }}
                                                </code>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="text-sm font-black text-slate-900 tracking-tighter">
                                                {{ number_format($ep['hit_count']) }}
                                            </span>
                                            <span class="text-[9px] text-slate-400 uppercase font-bold ml-1 tracking-widest">Hits</span>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex flex-col items-end gap-1.5">
                                                <span class="text-xs font-black text-emerald-600 italic">
                                                    {{ number_format($percentage, 2) }}%
                                                </span>
                                                <div class="w-32 h-1 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" 
                                                         style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            @if (!$endpointStats->isEmpty())
                <div class="p-6 bg-slate-900 border-t border-slate-100 flex justify-between items-center">
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Aggregate Traffic Volume</span>
                    <span class="text-sm font-black text-white italic tracking-tighter">
                        TOTAL: {{ number_format($totalHits) }} REQUESTS
                    </span>
                </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>