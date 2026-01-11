@props(['title' => ''])
<!doctype html>
<html
    lang="en"
    class="h-full bg-slate-50"
>

<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? 'Dashboard' }} | LogScreen Riska</title>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <x-link
        rel="shortcut icon"
        href="{{ asset('favicon.ico') }}"
    />
    <x-link
        href="dashboard/assets/css/icons.min.css"
        rel="stylesheet"
        type="text/css"
    />


    @vite(['resources/css/app.css','resources/js/app.js'])

    @stack('style')


</head>

<body
    class="h-full antialiased font-inter"
    x-data="{ mobileSidebarOpen: false }"
>

    <div
        x-show="mobileSidebarOpen"
        class="fixed inset-0 z-[100] lg:hidden"
        x-cloak
    >

        <div
            x-show="mobileSidebarOpen"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            @click="mobileSidebarOpen = false"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
        ></div>

        <div
            x-show="mobileSidebarOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            class="relative flex flex-col w-72 h-full bg-slate-900"
        >

            <div class="p-4 flex justify-end">
                <button
                    @click="mobileSidebarOpen = false"
                    class="text-white/50 hover:text-white"
                >
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto pt-2">
                @include('__partials.dashboard.sidebar')
            </div>
        </div>
    </div>

    <div
        id="layout-wrapper"
        class="flex min-h-screen"
    >
        <aside class="hidden lg:flex lg:flex-col lg:w-72 lg:fixed lg:inset-y-0 bg-slate-900 z-50">
            @include('__partials.dashboard.sidebar')
        </aside>

        <div class="flex-1 flex flex-col lg:pl-72 w-full">
            <header
                class="sticky top-0 z-40 h-16 bg-white/80 backdrop-blur-md border-b flex items-center justify-between px-4"
            >

                <button
                    @click="mobileSidebarOpen = true"
                    type="button"
                    class="lg:hidden p-2 text-slate-600"
                >
                    <i class="ri-menu-2-line text-2xl"></i>
                </button>

                @include('__partials.dashboard.header')
            </header>

            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('script')

</body>

</html>
