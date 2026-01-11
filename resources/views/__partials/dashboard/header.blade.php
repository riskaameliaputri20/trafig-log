<div class="flex items-center justify-between w-full">

    <div class="flex items-center gap-4">
        <div class="hidden sm:block">
            <h1 class="text-sm font-semibold text-slate-800 uppercase tracking-wider">
                System Monitoring <span class="mx-2 text-slate-300">/</span>
                <span class="text-emerald-600">{{ $title ?? 'Overview' }}</span>
            </h1>
        </div>
    </div>

    <div class="flex items-center gap-3">

        <div
            class="relative"
            x-data="{ open: false }"
            @click.away="open = false"
        >
            <button
                @click="open = !open"
                type="button"
                class="flex items-center gap-3 p-1.5 pl-3 rounded-2xl hover:bg-slate-100 transition-all border border-transparent hover:border-slate-200 group"
            >

                <div class="text-right hidden md:block">
                    <p class="text-xs font-bold text-slate-900 leading-none truncate w-24">
                        {{ auth()->user()->name }}
                    </p>
                    <p
                        class="text-[10px] font-bold text-emerald-600 uppercase tracking-tighter mt-1">
                        Administrator
                    </p>
                </div>

                <div class="relative">
                    <img
                        class="size-9 rounded-xl object-cover ring-2 ring-slate-100 group-hover:ring-emerald-100 transition-all"
                        src="{{ auth()->user()->profile ? Storage::url(auth()->user()->profile) : asset('assets/img/avatar-default.png') }}"
                        alt="Header Avatar"
                    />
                    <div
                        class="absolute bottom-0 right-0 size-2.5 bg-emerald-500 border-2 border-white rounded-full">
                    </div>
                </div>

                <i
                    class="ri-arrow-down-s-line text-slate-400 transition-transform duration-200"
                    :class="open ? 'rotate-180' : ''"
                ></i>
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-cloak
                class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50"
            >

                <div class="px-4 py-2 border-b border-slate-50 mb-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Signed
                        in as</p>
                    <p class="text-xs font-semibold text-slate-900 truncate">
                        {{ auth()->user()->email }}</p>
                </div>

                <a
                    href="{{ route('dashboard.setting.account') }}"
                    class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-emerald-600 transition-colors"
                >
                    <i class="ri-user-settings-line text-lg"></i>
                    <span>My Profile</span>
                </a>

                <div class="h-px bg-slate-100 my-2"></div>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition-colors"
                    >
                        <i class="ri-logout-circle-r-line text-lg"></i>
                        <span class="font-semibold">Sign Out</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
