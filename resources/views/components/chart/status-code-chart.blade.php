@props(['statusCounts'])

<div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm h-full">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em]">Status Code</h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1 italic">HTTP Distribution</p>
        </div>
    </div>
    <div id="chartStatusCode"></div>
</div>

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            series: @json($statusCounts->values()),
            chart: { type: 'donut', height: 350, fontFamily: 'Inter' },
            labels: @json($statusCounts->keys()),
            colors: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#64748b'],
            plotOptions: { 
                pie: { 
                    donut: { 
                        size: '75%',
                        labels: { 
                            show: true, 
                            total: { show: true, label: 'TOTAL', fontSize: '10px', fontWeight: 900, color: '#94a3b8' } 
                        } 
                    } 
                } 
            },
            dataLabels: { enabled: false },
            legend: { position: 'bottom', fontSize: '10px', fontWeight: 700 },
            tooltip: { theme: 'dark' }
        };
        new ApexCharts(document.querySelector("#chartStatusCode"), options).render();
    });
</script>
@endpush