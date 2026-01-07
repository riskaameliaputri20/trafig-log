@use('Carbon\Carbon')
<x-layouts.dashboard title="User Behavior Analysis">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4 group">
            <div
                class="size-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="ri-fingerprint-line text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Unique
                    Visitors</p>
                <h4 class="text-2xl font-black text-slate-900 leading-tight">
                    {{ number_format($userBehavior->count()) }}</h4>
            </div>
        </div>

        <div
            class="bg-slate-900 p-6 rounded-3xl shadow-xl flex items-center gap-4 border-l-4 border-emerald-500">
            <div
                class="size-12 bg-white/10 text-emerald-400 rounded-2xl flex items-center justify-center">
                <i class="ri-user-location-line text-2xl"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Top
                    Active Source</p>
                <h4 class="text-lg font-mono font-black text-white truncate leading-tight">
                    {{ $userBehavior->first()['ip_address'] ?? 'N/A' }}
                </h4>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div
                class="size-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                <i class="ri-shield-user-line text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Health
                    Status</p>
                <h4 class="text-lg font-black text-emerald-600 italic uppercase">Secure Traffic</h4>
            </div>
        </div>
    </div>

    <div
        class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-8"
        x-data="{ detailOpen: false, activeUser: null }"
    >
        <div
            class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h5 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em]">Detailed
                    User Behavior</h5>
                <p
                    class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-widest italic">
                    Session & Clickstream Analysis</p>
            </div>
            <a
                href="{{ route('dashboard.export.user-behavior') }}"
                class="px-4 py-2 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg hover:bg-emerald-700 transition-all flex items-center gap-2"
            >
                <i class="ri-file-chart-line"></i> Export Analysis
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr
                        class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <th class="px-6 py-4">IP Address</th>
                        <th class="px-6 py-4 text-center">Hits</th>
                        <th class="px-6 py-4">Duration</th>
                        <th class="px-6 py-4">Avg Gap</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Entry / Exit</th>
                        <th class="px-6 py-4 text-right">Activity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($userBehavior as $user)
                        <tr
                            class="hover:bg-slate-50/50 transition-colors group text-xs font-medium text-slate-600">
                            <td class="px-6 py-4">
                                <span
                                    class="font-mono font-black text-slate-900">{{ $user['ip_address'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="font-black text-slate-800">{{ $user['total_requests'] }}</span>
                            </td>
                            <td class="px-6 py-4 italic">
                                @php
                                    $durationDisplay = '-';
                                    if ($user['duration_minutes'] > 0) {
                                        $durationDisplay = Carbon::parse(
                                            $user['first_seen'],
                                        )->diffForHumans(Carbon::parse($user['last_seen']), [
                                            'parts' => 1,
                                            'short' => true,
                                            'syntax' => Carbon::DIFF_ABSOLUTE,
                                        ]);
                                    }
                                @endphp
                                {{ $durationDisplay }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-0.5 bg-slate-100 rounded text-[10px] font-bold">{{ $user['avg_click_gap_sec'] }}s</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($user['behavior_type'] === 'possible bot / crawler')
                                    <span
                                        class="px-2 py-1 bg-rose-50 text-rose-600 rounded-lg text-[9px] font-black uppercase tracking-tighter border border-rose-100"
                                    >Bot / Crawler</span>
                                @elseif ($user['behavior_type'] === 'high activity user')
                                    <span
                                        class="px-2 py-1 bg-amber-50 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-tighter border border-amber-100"
                                    >High Active</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-tighter border border-emerald-100"
                                    >Normal</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1 max-w-[150px]">
                                    <span class="truncate text-[10px] text-slate-400">In:
                                        {{ $user['first_page'] }}</span>
                                    <span class="truncate text-[10px] text-slate-800 font-bold">Out:
                                        {{ $user['last_page'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="activeUser = {{ json_encode($user) }}; detailOpen = true"
                                    class="px-3 py-1 bg-slate-900 text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-sm"
                                >
                                    Clickstream
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="7"
                                class="px-6 py-12 text-center text-slate-400 italic"
                            >No user behavior data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div
            x-show="detailOpen"
            class="fixed inset-0 z-[70]"
            x-cloak
        >
            <div
                x-show="detailOpen"
                x-transition.opacity
                @click="detailOpen = false"
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            ></div>
            <div
                x-show="detailOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                class="fixed inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col"
            >

                <div class="p-6 bg-slate-900 text-white flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest italic">User
                            Clickstream</h3>
                        <p
                            class="text-[10px] text-emerald-400 font-mono mt-1"
                            x-text="activeUser?.ip_address"
                        ></p>
                    </div>
                    <button
                        @click="detailOpen = false"
                        class="p-2 hover:bg-white/10 rounded-xl transition-colors"
                    ><i class="ri-close-line text-2xl"></i></button>
                </div>

                <div class="flex-1 overflow-y-auto p-8 custom-scrollbar bg-slate-50/50">
                    <template x-if="activeUser">
                        <div class="relative border-l-2 border-emerald-200 ml-3 space-y-8">
                            <template x-for="(page, index) in activeUser.clickstream.split(' , ')">
                                <div class="relative pl-8">
                                    <div
                                        class="absolute -left-[9px] top-1 size-4 rounded-full bg-white border-4 border-emerald-500 shadow-sm">
                                    </div>
                                    <p
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1"
                                        x-text="'Step ' + (index + 1)"
                                    ></p>
                                    <div
                                        class="p-3 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                                        <code
                                            class="text-[10px] text-slate-700 break-all leading-relaxed"
                                            x-text="page"
                                        ></code>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em]">Activity
                Distribution</h3>
        </div>
        <div
            id="userBehaviorChart"
            class="w-full"
            style="min-height: 365px;"
        ></div>
    </div>
@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                series: [{
                    name: "Total Requests",
                    data: @json($userBehavior->pluck('total_requests'))
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    fontFamily: 'Inter',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 12,
                        horizontal: false,
                        columnWidth: '40%',
                        distributed: true
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: @json($userBehavior->pluck('ip_address')),
                    labels: {
                        show: false
                    } // Hide IP labels for cleaner look as they are long
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#94a3b8',
                            fontSize: '10px',
                            fontWeight: 600
                        }
                    }
                },
                colors: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#6366f1'],
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: (val) => val + " requests"
                    }
                },
                legend: {
                    show: false
                }
            };
            
            new ApexCharts(document.querySelector("#userBehaviorChart"), options).render();
        });
    </script>
@endpush

</x-layouts.dashboard>
