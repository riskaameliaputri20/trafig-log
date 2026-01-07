<x-layouts.dashboard title="Dashboard Overview">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div
            class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm group hover:border-emerald-200 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">
                        Total Request Hari Ini</p>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter italic">
                        {{ number_format($trafikCountToday) }}
                    </h2>
                </div>
                <div
                    class="size-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ri-flashlight-line text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-slate-900 p-6 rounded-3xl shadow-xl relative overflow-hidden group">
            <div
                class="absolute -right-4 -top-4 size-24 bg-white/5 rounded-full group-hover:scale-110 transition-transform">
            </div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p
                        class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1">
                        Total Request Keseluruhan</p>
                    <h2 class="text-4xl font-black text-white tracking-tighter italic">
                        {{ number_format($trafikCount) }}
                    </h2>
                </div>
                <div
                    class="size-12 bg-white/10 text-emerald-400 rounded-2xl flex items-center justify-center">
                    <i class="ri-database-2-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @foreach ($statusCounts as $status => $count)
            <div
                class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
                <div
                    class="size-10 flex-shrink-0 bg-slate-50 text-slate-600 rounded-xl flex items-center justify-center font-bold text-xs border border-slate-100">
                    {{ $status }}
                </div>
                <div class="min-w-0">
                    <p
                        class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">
                        Status Code</p>
                    <p class="text-lg font-black text-slate-800 leading-tight">
                        {{ number_format($count) }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-8">
        <form
            action="{{ route('dashboard.uploadFile') }}"
            method="post"
            enctype="multipart/form-data"
        >
            @csrf
            <div
                class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm overflow-hidden relative">
                @session('custom_log_path')
                    <div class="absolute top-0 left-0 w-1 h-full bg-rose-500"></div>
                @endsession

                <h5
                    class="text-sm font-black text-slate-900 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                    <i class="ri-upload-cloud-2-line text-emerald-500 text-lg"></i>
                    Upload Custom Log
                </h5>

                @session('custom_log_path')
                    <div
                        class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-3">
                        <i class="ri-error-warning-fill text-rose-500 text-lg"></i>
                        <p
                            class="text-xs font-bold text-rose-800 leading-relaxed uppercase tracking-tight">
                            Anda menggunakan Custom Log! Klik Remove Uploaded untuk kembali ke log
                            sistem.
                        </p>
                    </div>
                @endsession

                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-grow">
                        <input
                            type="file"
                            name="customLogFile"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition-all border border-slate-200 rounded-xl p-1"
                        />
                        @error('customLogFile')
                            <p
                                class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">
                                {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="px-6 py-3 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 flex items-center gap-2"
                        >
                            <i class="ri-upload-2-line"></i> Upload
                        </button>
                        @session('custom_log_path')
                            <button
                                formaction="{{ route('dashboard.removeFile') }}"
                                formmethod="post"
                                type="submit"
                                class="px-6 py-3 bg-white text-rose-600 border border-rose-100 text-xs font-black uppercase tracking-widest rounded-xl hover:bg-rose-50 transition-all flex items-center gap-2"
                            >
                                <i class="ri-delete-bin-line"></i> Remove
                            </button>
                        @endsession
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch mb-8">
        <div class="lg:col-span-8">
            <x-chart.respon-size-chart
                :prices="$prices"
                :dates="$dates"
            />
        </div>

        <div class="lg:col-span-4">
            <x-chart.status-code-chart :statusCounts="$statusCounts" />
        </div>
    </div>
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-8">
        <div
            class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h5 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em]">Apache
                    Access Logs</h5>
                <p
                    class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-widest italic">
                    Raw Parsed Data Table</p>
            </div>
            <a
                href="{{ route('dashboard.export.parse-log') }}"
                class="px-4 py-2 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg hover:bg-emerald-700 transition-all flex items-center gap-2"
            >
                <i class="ri-file-excel-2-line"></i> Export Laporan
            </a>
        </div>
        <div class="p-2 overflow-x-auto whitespace-nowrap">
            <x-table.traffic-table :traffics="$traffics" />
        </div>
    </div>


    <div
        class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden"
        x-data="{
            detailOpen: false,
            activeThreat: null
        }"
    >

        <div
            class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-900">
            <div>
                <h5
                    class="text-sm font-black text-white uppercase tracking-[0.2em] flex items-center gap-2">
                    <span class="size-2 bg-rose-500 rounded-full animate-ping"></span>
                    Detected Threats
                </h5>
                <p class="text-[10px] text-slate-500 font-bold uppercase mt-1 tracking-widest">
                    Security Alert Logs</p>
            </div>
            <a
                href="{{ route('dashboard.export.threats') }}"
                class="px-4 py-2 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg hover:bg-emerald-700 transition-all flex items-center gap-2"
            >
                <i class="ri-download-cloud-2-line text-xs"></i> Export Threats
            </a>
        </div>

        <div class="overflow-x-auto">
            @if ($threats->isEmpty())
            @else
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr
                            class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">IP Address</th>
                            <th class="px-6 py-4 text-center">Hits</th>
                            <th class="px-6 py-4">Threat Level</th>
                            <th class="px-6 py-4">Last Activity</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($threats as $index => $t)
                            @php
                                $score = $t['score'] ?? 0;
                                $config = match (true) {
                                    $score >= 7 => ['level' => 'HIGH', 'color' => 'rose'],
                                    $score >= 4 => ['level' => 'MEDIUM', 'color' => 'amber'],
                                    default => ['level' => 'LOW', 'color' => 'emerald'],
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4 text-[10px] font-bold text-slate-400">
                                    {{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-mono text-xs font-black text-slate-700">
                                    <div class="flex items-center gap-2">
                                        {{ $t['ip_address'] }}
                                        <a
                                            href="https://www.abuseipdb.com/check/{{ $t['ip_address'] }}"
                                            target="_blank"
                                            class="text-slate-300 hover:text-emerald-500 transition-colors"
                                        >
                                            <i class="ri-external-link-line"></i>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center text-xs font-bold text-slate-600">
                                    {{ $t['total_requests'] ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 bg-{{ $config['color'] }}-50 text-{{ $config['color'] }}-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-{{ $config['color'] }}-100"
                                    >
                                        {{ $config['level'] }} ({{ $score }})
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 text-[10px] font-bold text-slate-500 italic uppercase">
                                    {{ \Carbon\Carbon::parse($t['last_seen'])->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        @click="activeThreat = {{ json_encode($t) }}; detailOpen = true"
                                        class="px-3 py-1 bg-white border border-slate-200 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all"
                                    >
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div
            x-show="detailOpen"
            class="fixed inset-0 z-[70]"
            x-cloak
        >
            <div
                x-show="detailOpen"
                x-transition:enter="transition-opacity ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="detailOpen = false"
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            ></div>

            <div
                x-show="detailOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="fixed inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col"
            >

                <div class="p-6 bg-slate-900 text-white flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest">Threat Analysis
                        </h3>
                        <p
                            class="text-[10px] text-slate-400 font-bold uppercase mt-1"
                            x-text="activeThreat?.ip_address"
                        ></p>
                    </div>
                    <button
                        @click="detailOpen = false"
                        class="p-2 hover:bg-white/10 rounded-xl transition-colors"
                    >
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                    <template x-if="activeThreat">
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-[9px] font-black text-slate-400 uppercase mb-1">
                                        Total Hits</p>
                                    <p
                                        class="text-xl font-black text-slate-900"
                                        x-text="activeThreat.total_requests"
                                    ></p>
                                </div>
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-[9px] font-black text-slate-400 uppercase mb-1">
                                        Severity</p>
                                    <p
                                        class="text-xl font-black text-rose-600"
                                        x-text="activeThreat.score"
                                    ></p>
                                </div>
                            </div>

                            <div>
                                <p
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">
                                    Detection Details</p>
                                <div class="space-y-3">
                                    <template x-for="detail in activeThreat.details">
                                        <div
                                            class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-emerald-200 transition-colors">
                                            <div class="flex justify-between items-center mb-2">
                                                <span
                                                    class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded uppercase tracking-tighter"
                                                    x-text="detail.type"
                                                ></span>
                                                <span
                                                    class="text-[10px] font-black text-slate-400"
                                                    x-text="detail.count + ' Hits'"
                                                ></span>
                                            </div>
                                            <div class="bg-slate-50 p-3 rounded-xl">
                                                <code
                                                    class="text-[10px] text-slate-600 break-all leading-relaxed"
                                                    x-text="detail.recent"
                                                ></code>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="p-6 border-t border-slate-100 bg-slate-50">
                    <a
                        :href="'https://www.abuseipdb.com/check/' + activeThreat?.ip_address"
                        target="_blank"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all"
                    >
                        Check Reputation <i class="ri-external-link-line"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
