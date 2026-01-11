<x-layouts.landing :title="$blog->title">

    <x-slot:meta>
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->url() }}">
        <meta property="og:title" content="{{ $blog->title ?? 'LogScreen Riska' }}">
        <meta property="og:description" content="{{ $blog->description ?? 'Analisis Log Server Apache' }}">
        <meta property="og:image" content="{{ isset($blog) ? $blog->thumbnail : asset('default-og.png') }}">

        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ request()->url() }}">
        <meta property="twitter:title" content="{{ $blog->title ?? 'LogScreen Riska' }}">
        <meta property="twitter:description" content="{{ $blog->description ?? 'Analisis Log Server Apache' }}">
        <meta property="twitter:image" content="{{ isset($blog) ? $blog->thumbnail : asset('default-og.png') }}">
    </x-slot:meta>

    <article class="max-w-4xl mx-auto px-6 pt-12">
        <div class="mb-8 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
            <a href="/" class="hover:text-emerald-500 transition-colors">Home</a>
            <i class="ri-arrow-right-s-line"></i>
            <span class="text-emerald-500">{{ $blog->category->name }}</span>
        </div>

        <h1 class="text-4xl md:text-6xl font-black tracking-tighter italic leading-tight mb-8">
            {{ $blog->title }}
        </h1>

        <div class="flex items-center gap-4 mb-12 pb-12 border-b border-slate-100">
            <div class="size-12 rounded-full bg-slate-200"></div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest">Written by Admin</p>
                <p class="text-xs font-bold text-slate-400 italic mt-0.5">{{ $blog->created_at->format('F d, Y') }}</p>
            </div>
        </div>

        <img src="{{ $blog->thumbnail }}" class="w-full h-[500px] object-cover rounded-[3rem] shadow-2xl mb-12"
            alt="Header Image">

        <div class="prose prose-slate prose-lg max-w-none">
            <div class="text-slate-700 leading-relaxed space-y-6 text-lg font-medium italic">
                {!! nl2br(e($blog->content)) !!}
            </div>
        </div>

        <div
            class="mt-20 pt-12 border-t border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <a href="/"
                class="flex items-center gap-2 text-xs font-black uppercase tracking-widest hover:text-emerald-500 transition-colors">
                <i class="ri-arrow-left-line"></i> Back to stories
            </a>
            <div class="flex items-center gap-4">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Share:</span>

                <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(request()->url()) }}"
                    target="_blank" rel="noopener noreferrer"
                    class="size-10 bg-white rounded-full flex items-center justify-center border border-slate-100 hover:bg-emerald-50 hover:text-emerald-500 transition-all shadow-sm">
                    <i class="ri-twitter-x-line"></i>
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                    target="_blank" rel="noopener noreferrer"
                    class="size-10 bg-white rounded-full flex items-center justify-center border border-slate-100 hover:bg-emerald-50 hover:text-emerald-500 transition-all shadow-sm">
                    <i class="ri-facebook-fill"></i>
                </a>

                <button x-data="{ copied: false }"
                    @click="navigator.clipboard.writeText('{{ request()->url() }}'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="size-10 bg-white rounded-full flex items-center justify-center border border-slate-100 hover:bg-emerald-50 hover:text-emerald-500 transition-all shadow-sm relative">
                    <i x-show="!copied" class="ri-link-m"></i>
                    <i x-show="copied" class="ri-check-line text-emerald-500"></i>

                    <span x-show="copied" x-transition
                        class="absolute -top-10 left-1/2 -translate-x-1/2 px-2 py-1 bg-slate-900 text-white text-[8px] font-black uppercase rounded shadow-lg whitespace-nowrap">
                        Copied!
                    </span>
                </button>
            </div>
        </div>
    </article>
</x-layouts.landing>
