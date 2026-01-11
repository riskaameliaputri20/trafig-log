<x-layouts.landing>
    <section class="relative overflow-hidden pt-20 pb-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600">v2.0 Real-time Monitor</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-black tracking-tighter italic leading-[0.9] mb-8 uppercase">
                    Analyzing <span class="text-emerald-500">Web</span> <br>
                    Traffic <span class="text-slate-400">Deeply.</span>
                </h1>
                <p class="text-slate-500 text-lg font-medium italic leading-relaxed max-w-lg mb-10">
                    LogScreen Riska adalah solusi analisis log server Apache yang mengubah data mentah menjadi wawasan keamanan dan performa yang cerdas.
                </p>
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="flex -space-x-3">
                            <div class="size-8 rounded-full bg-slate-200 border-2 border-white"></div>
                            <div class="size-8 rounded-full bg-slate-300 border-2 border-white"></div>
                            <div class="size-8 rounded-full bg-slate-400 border-2 border-white"></div>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Trusted by SysAdmins</span>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 bg-emerald-500/10 rounded-[3rem] blur-3xl"></div>
                <div class="relative bg-slate-900 rounded-[2.5rem] border border-white/10 shadow-2xl p-4 aspect-video overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-transparent opacity-50"></div>
                    <div class="flex gap-2 mb-4">
                        <div class="size-2 rounded-full bg-rose-500"></div>
                        <div class="size-2 rounded-full bg-amber-500"></div>
                        <div class="size-2 rounded-full bg-emerald-500"></div>
                    </div>
                    <div class="space-y-3">
                        <div class="h-4 w-2/3 bg-white/10 rounded-full"></div>
                        <div class="h-24 w-full bg-white/5 rounded-3xl border border-white/5"></div>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="h-12 bg-white/5 rounded-2xl"></div>
                            <div class="h-12 bg-white/5 rounded-2xl"></div>
                            <div class="h-12 bg-white/5 rounded-2xl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($featured && $posts->onFirstPage())
    <section class="max-w-7xl mx-auto px-6 pt-12">
        <div class="relative group h-[500px] rounded-[3rem] overflow-hidden shadow-2xl">
            <img src="{{ $featured->thumbnail }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Featured">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
            <div class="absolute bottom-0 p-8 md:p-16 max-w-3xl text-left">
                <span class="px-3 py-1 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full mb-4 inline-block">Editor's Pick</span>
                <h2 class="text-3xl md:text-5xl font-black text-white leading-tight italic tracking-tighter mb-6">
                    <a href="{{ route('landing.show', $featured->slug) }}" class="hover:text-emerald-400 transition-colors">
                        {{ $featured->title }}
                    </a>
                </h2>
                <div class="flex items-center gap-4 text-white text-[10px] font-black uppercase tracking-widest">
                    <span>Admin</span>
                    <span class="size-1 bg-emerald-500 rounded-full"></span>
                    <span>{{ $featured->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="max-w-7xl mx-auto px-6 mt-20">
        <div class="flex items-center justify-between mb-12 border-b border-slate-100 pb-8">
            <h2 class="text-2xl font-black italic tracking-tighter uppercase">Latest <span class="text-emerald-500">Insights</span></h2>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($posts as $post)
            <article class="group">
                <a href="{{ route('landing.show', $post->slug) }}" class="block mb-6 overflow-hidden rounded-[2rem] aspect-[4/3] bg-slate-100 shadow-sm border border-slate-100">
                    <img src="{{ $post->thumbnail }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $post->title }}">
                </a>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[9px] font-black uppercase tracking-widest">{{ $post->category->name }}</span>
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-300 italic">{{ $post->created_at->format('M d, Y') }}</span>
                    </div>
                    <h3 class="text-xl font-black tracking-tight leading-snug group-hover:text-emerald-500 transition-colors">
                        <a href="{{ route('landing.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    <p class="text-slate-500 text-xs leading-relaxed line-clamp-2 italic font-medium">
                        {{ $post->description }}
                    </p>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-20">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    </section>
</x-layouts.landing>
