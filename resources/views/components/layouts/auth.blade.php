<!doctype html>
<html
    lang="en"
    class="h-full bg-gray-50"
>

<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? 'Authentication' }} | Traffic Log</title>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    @vite(['resources/css/app.css','resources/js/app.js'])

    <x-link
        rel="shortcut icon"
        href="dashboard/assets/images/favicon.ico"
    />

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .auth-gradient {
            background: linear-gradient(135deg, #405189 0%, #0ab39c 100%);
        }
    </style>
</head>

<body class="h-full">

    <div class="relative min-h-screen flex flex-col justify-center">

        <div class="absolute top-0 left-0 right-0 h-80 auth-gradient -z-10">
            <div class="absolute inset-0 bg-slate-900/40"></div>
            <div class="absolute bottom-0 left-0 right-0">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 1440 120"
                    class="fill-gray-50"
                >
                    <path
                        d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"
                    ></path>
                </svg>
            </div>
        </div>

        <div class="relative z-10 flex-grow flex items-center justify-center px-4 pt-12 pb-20">
            <div class="w-full max-w-md">

                <div class="text-center mb-8">
                    <x-logo />
                </div>

                <div class="bg-white rounded-lg shadow-xl overflow-hidden px-5 py-10">
                    {{ $slot }}
                </div>

            </div>
        </div>

        <footer class="py-8 relative z-20">
            <div class="container mx-auto px-4">
                <div class="text-center text-slate-400 text-xs tracking-[0.2em] uppercase">
                    <p>&copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <span class="font-bold text-slate-500">LogScreen</span>
                        <span class="mx-2 text-slate-300">|</span>
                        Developed by <span class="text-emerald-500 font-semibold">Riska Amelia
                            Putri</span>
                    </p>
                </div>
            </div>
        </footer>

    </div>

    <x-script src="dashboard/assets/libs/feather-icons/feather.min.js"></x-script>
    <script>
        // Inisialisasi feather icons jika diperlukan
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    </script>
</body>

</html>
