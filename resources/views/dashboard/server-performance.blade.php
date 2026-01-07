<x-layouts.dashboard title="Server Performance Monitor">

    <div class="mb-8">
        <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic">
            Server <span class="text-emerald-500">Resource</span> Monitor
        </h2>
        <p class="text-sm text-slate-500 font-medium italic">Real-time infrastructure health and system metrics</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- ======================= CPU USAGE ======================= --}}
        @php
            $cpuStatus = match(true) {
                $cpuUsage >= 70 => ['color' => 'rose', 'text' => 'Critical'],
                $cpuUsage >= 40 => ['color' => 'amber', 'text' => 'High Load'],
                default => ['color' => 'emerald', 'text' => 'Normal'],
            };
        @endphp
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm group hover:border-{{ $cpuStatus['color'] }}-200 transition-all duration-300">
            <div class="flex justify-between items-start mb-6">
                <div class="size-12 bg-{{ $cpuStatus['color'] }}-50 text-{{ $cpuStatus['color'] }}-600 rounded-2xl flex items-center justify-center">
                    <i class="ri-cpu-line text-2xl"></i>
                </div>
                <span class="px-2.5 py-1 bg-{{ $cpuStatus['color'] }}-50 text-{{ $cpuStatus['color'] }}-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-{{ $cpuStatus['color'] }}-100">
                    {{ $cpuStatus['text'] }}
                </span>
            </div>
            
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Processor Load</p>
            <h4 class="text-4xl font-black text-slate-900 tracking-tighter italic">
                @if ($cpuUsage === null)
                    <span class="text-slate-300 text-xl">Unsupported</span>
                @else
                    {{ $cpuUsage }}<span class="text-lg text-slate-400 font-medium">%</span>
                @endif
            </h4>

            <div class="mt-6">
                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-{{ $cpuStatus['color'] }}-500 transition-all duration-1000 ease-out" 
                         style="width: {{ $cpuUsage ?? 0 }}%"></div>
                </div>
                <p class="mt-3 text-[10px] text-slate-400 font-medium leading-relaxed">
                    Semakin tinggi load, semakin berat server bekerja memproses request.
                </p>
            </div>
        </div>

        {{-- ======================= MEMORY USAGE ======================= --}}
        @php
            $memTotal = $memoryTotal;
            $memFree = $memoryFree;
            $memUsed = $memTotal - $memFree;
            $memPercent = $memTotal > 0 ? round(($memUsed / $memTotal) * 100, 2) : 0;

            $memStatus = match(true) {
                $memPercent >= 80 => ['color' => 'rose', 'text' => 'Low Memory'],
                $memPercent >= 50 => ['color' => 'amber', 'text' => 'High Usage'],
                default => ['color' => 'emerald', 'text' => 'Healthy'],
            };
        @endphp
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm group hover:border-{{ $memStatus['color'] }}-200 transition-all duration-300">
            <div class="flex justify-between items-start mb-6">
                <div class="size-12 bg-{{ $memStatus['color'] }}-50 text-{{ $memStatus['color'] }}-600 rounded-2xl flex items-center justify-center">
                    <i class="ri-ram-line text-2xl"></i>
                </div>
                <span class="px-2.5 py-1 bg-{{ $memStatus['color'] }}-50 text-{{ $memStatus['color'] }}-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-{{ $memStatus['color'] }}-100">
                    {{ $memStatus['text'] }}
                </span>
            </div>

            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Physical Memory</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tighter italic">
                {{ number_format($memUsed) }} <span class="text-sm text-slate-400 font-medium">/ {{ number_format($memTotal) }} MB</span>
            </h4>

            <div class="mt-6">
                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden text-right">
                    <div class="h-full bg-{{ $memStatus['color'] }}-500 transition-all duration-1000 ease-out" 
                         style="width: {{ $memPercent }}%"></div>
                </div>
                <div class="mt-3 flex justify-between items-center">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Free Memory</span>
                    <span class="text-xs font-black text-slate-700">{{ number_format($memFree) }} MB</span>
                </div>
            </div>
        </div>

        {{-- ======================= DISK USAGE ======================= --}}
        @php
            $diskPercent = round(($diskUsed / $diskTotal) * 100, 2);
            $diskStatus = match(true) {
                $diskPercent >= 85 => ['color' => 'rose', 'text' => 'Critical'],
                $diskPercent >= 60 => ['color' => 'amber', 'text' => 'Warning'],
                default => ['color' => 'emerald', 'text' => 'Safe'],
            };
        @endphp
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm group hover:border-{{ $diskStatus['color'] }}-200 transition-all duration-300">
            <div class="flex justify-between items-start mb-6">
                <div class="size-12 bg-slate-900 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-slate-200">
                    <i class="ri-hard-drive-2-line text-2xl"></i>
                </div>
                <span class="px-2.5 py-1 bg-{{ $diskStatus['color'] }}-50 text-{{ $diskStatus['color'] }}-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-{{ $diskStatus['color'] }}-100">
                    {{ $diskStatus['text'] }}
                </span>
            </div>

            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Storage Capacity</p>
            <h4 class="text-2xl font-black text-slate-900 tracking-tighter italic">
                {{ $diskUsed }} <span class="text-sm text-slate-400 font-medium">/ {{ $diskTotal }} GB</span>
            </h4>

            <div class="mt-6">
                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-slate-900 transition-all duration-1000 ease-out" 
                         style="width: {{ $diskPercent }}%"></div>
                </div>
                <div class="mt-3 flex justify-between items-center">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Available Space</span>
                    <span class="text-xs font-black text-slate-700">{{ $diskFree }} GB</span>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- ======================= PHP RUNTIME ======================= --}}
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <h5 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                <i class="ri-server-line text-emerald-500"></i>
                System Environment
            </h5>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">PHP Memory Limit</span>
                    <span class="text-sm font-black text-slate-800">{{ $phpMemoryLimit }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Max Execution Time</span>
                    <span class="text-sm font-black text-slate-800">{{ $maxExecution }} <small class="text-slate-400">sec</small></span>
                </div>
            </div>
        </div>

        {{-- ======================= DATABASE PERFORMANCE ======================= --}}
        @php
            $dbStatus = match(true) {
                $dbResponse >= 500 => ['color' => 'rose', 'text' => 'Critical Delay'],
                $dbResponse >= 200 => ['color' => 'amber', 'text' => 'Slow Query'],
                default => ['color' => 'emerald', 'text' => 'Fast'],
            };
        @endphp
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-10 -bottom-10 size-32 bg-{{ $dbStatus['color'] }}-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
            
            <h5 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                <i class="ri-database-2-line text-{{ $dbStatus['color'] }}-500"></i>
                Database Latency
            </h5>

            <div class="relative z-10 flex items-end justify-between">
                <div>
                    <h4 class="text-5xl font-black text-slate-900 tracking-tighter italic">
                        {{ $dbResponse }}<span class="text-lg text-slate-400 font-medium italic ml-1">ms</span>
                    </h4>
                    <span class="mt-2 inline-block px-2 py-1 bg-{{ $dbStatus['color'] }}-50 text-{{ $dbStatus['color'] }}-600 rounded text-[9px] font-black uppercase tracking-widest">
                        {{ $dbStatus['text'] }}
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-bold text-slate-400 uppercase leading-relaxed max-w-[120px]">
                        Kecepatan eksekusi query pada database.
                    </p>
                </div>
            </div>
        </div>

    </div>

</x-layouts.dashboard>