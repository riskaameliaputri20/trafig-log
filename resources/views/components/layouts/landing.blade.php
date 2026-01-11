<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'LogScreen Riska - Insights' }}</title>
    {{ $meta ?? '' }}
        <x-link
        rel="shortcut icon"
        href="{{ asset('favicon.ico') }}"
    />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased">
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 group">
                <div class="size-2 rounded-full bg-emerald-500"></div>
                <span class="text-xl font-black tracking-tighter italic uppercase">LOG<span
                        class="text-emerald-500">SCREEN</span></span>
            </a>
            <div class="flex items-center gap-8">
                <a href="{{ route('landing.index') }}"
                    class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('landing.index') ? 'text-emerald-500' : 'text-slate-400 hover:text-slate-900' }}">Home</a>
                <a href="{{ route('landing.features') }}"
                    class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('landing.features') ? 'text-emerald-500' : 'text-slate-400 hover:text-slate-900' }}">Features</a>
                <a href="{{ route('landing.about') }}"
                    class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('landing.about') ? 'text-emerald-500' : 'text-slate-400 hover:text-slate-900' }}">About</a>
            </div>
        </div>
        </div>
    </nav>

    <main>{{ $slot }}</main>

    <footer class="bg-white border-t border-slate-100 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">© 2026 LOGSCREEN RISKA - ALL
                RIGHTS RESERVED</p>
        </div>
    </footer>
</body>

</html>
