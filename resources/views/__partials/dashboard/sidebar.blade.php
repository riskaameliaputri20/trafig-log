<div class="flex flex-col h-full bg-slate-900 text-slate-300">
    <div class="flex items-center h-16 px-8 border-b border-white/5 bg-slate-900/50">
        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 group">
            <div class="size-2 rounded-full bg-emerald-500 shadow-[0_0_12px_var(--color-emerald-500)] group-hover:scale-125 transition-transform"></div>
            <div class="flex items-baseline">
                <span class="text-lg font-black tracking-tighter text-white uppercase italic">
                    LOG<span class="text-emerald-400">SCREEN</span>
                </span>
                <span class="ml-2 text-[10px] font-extralight tracking-[0.3em] text-slate-500 uppercase group-hover:text-emerald-400 transition-colors">
                    RISKA
                </span>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-4 py-6 overflow-y-auto custom-scrollbar">

        <div class="mb-8">
            <p class="px-4 mb-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Analysis Menu</p>
            <ul class="space-y-1.5">
                <x-sidebar-link href="{{ route('dashboard.index') }}"
                                icon="ri-pie-chart-box-line"
                                :active="request()->routeIs('dashboard.index')">
                    Overview
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('dashboard.userBehavior') }}"
                                icon="ri-user-search-line"
                                :active="request()->routeIs('dashboard.userBehavior')">
                    User Behavior
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('dashboard.analyzeErrorLogs') }}"
                                icon="ri-bug-line"
                                :active="request()->routeIs('dashboard.analyzeErrorLogs')">
                    Error Logs
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('dashboard.loginActivity') }}"
                                icon="ri-shield-keyhole-line"
                                :active="request()->routeIs('dashboard.loginActivity')">
                    Security / Login
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('dashboard.analyzeServerPerformance') }}"
                                icon="ri-pulse-line"
                                :active="request()->routeIs('dashboard.analyzeServerPerformance')">
                    Performance
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('dashboard.popularEndpoints') }}"
                                icon="ri-route-line"
                                :active="request()->routeIs('dashboard.popularEndpoints')">
                    Top Endpoints
                </x-sidebar-link>
            </ul>
        </div>

        <div class="mb-8">
            <p class="px-4 mb-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Management</p>
            <ul class="space-y-1.5">
                <x-sidebar-link href="{{ route('dashboard.blog.index') }}"
                                icon="ri-article-line"
                                :active="request()->routeIs('dashboard.blog.*')">
                    Manage Blog
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('dashboard.category.index') }}"
                                icon="ri-price-tag-3-line"
                                :active="request()->routeIs('dashboard.category.*')">
                    Categories
                </x-sidebar-link>
            </ul>
        </div>

        <div>
            <p class="px-4 mb-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">System</p>
            <ul class="space-y-1.5">
                <x-sidebar-link href="{{ route('dashboard.setting.account') }}"
                                icon="ri-settings-3-line"
                                :active="request()->routeIs('dashboard.setting.account')">
                    Settings
                </x-sidebar-link>

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-red-400 hover:bg-red-500/10 transition-all group border-none cursor-pointer text-left">
                            <i class="ri-logout-circle-r-line text-lg opacity-70 group-hover:opacity-100"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </nav>
</div>
