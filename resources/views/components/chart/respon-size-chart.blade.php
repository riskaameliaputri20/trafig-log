@props(['prices', 'dates'])

<div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm h-full">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em]">Response Size</h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1 italic">Payload Trend</p>
        </div>
        <div class="size-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
            <i class="ri-pulse-line text-xl"></i>
        </div>
    </div>
    <div id="chartResponseSize"></div>
</div>

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            series: [{ name: "Size (Bytes)", data: @json($prices) }],
            chart: { type: 'area', height: 350, toolbar: { show: false }, fontFamily: 'Inter' },
            dataLabels: {
                enabled: false
            },
            colors: ['#10b981'],
            stroke: { curve: 'smooth', width: 3 },
            fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0 } },
            xaxis: { 
                type: 'datetime', 
                categories: @json($dates),
                labels: { style: { colors: '#94a3b8', fontSize: '10px' } }
            },
            yaxis: {
                labels: { 
                    style: { colors: '#94a3b8', fontSize: '10px' },
                    formatter: (val) => (val / 1024).toFixed(1) + ' KB'
                }
            },
            tooltip: { theme: 'dark', x: { format: 'dd MMM HH:mm' } }
        };
        new ApexCharts(document.querySelector("#chartResponseSize"), options).render();
    });
</script>
@endpush