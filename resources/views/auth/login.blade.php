<x-layouts.auth>
    <div class="text-center mb-8">
        <h1 class="text-xl font-bold text-slate-800">Login Admin Dashboard</h1>
        <p class="text-sm text-slate-500 mt-1">Masukkan Email dan Password untuk melanjutkan</p>
    </div>

    @error('login')
        <div class="mb-6 flex items-start gap-3 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
            <i
                data-feather="alert-circle"
                class="w-5 h-5 text-red-500 mt-0.5"
            ></i>
            <div>
                <p class="text-sm font-bold text-red-800 leading-none">Login Failed</p>
                <p class="text-xs text-red-700 mt-1">{{ $message }}</p>
            </div>
        </div>
    @enderror

    <form
        action="{{ route('loginProcess') }}"
        method="POST"
        class="space-y-5"
    >
        @csrf
        @method('POST')

        <div>
            <label
                for="email"
                class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2"
            >Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i
                        data-feather="mail"
                        class="w-4 h-4 text-slate-400"
                    ></i>
                </div>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border {{ $errors->has('email') ? 'border-red-300' : 'border-slate-200' }} rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all"
                    placeholder="name@company.com"
                    required
                >
            </div>
            @error('email')
                <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex justify-between items-center mb-2">
                <label
                    for="password-input"
                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider"
                >Password</label>
            </div>
            <div
                class="relative group"
                x-data="{ show: false }"
            >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i
                        data-feather="lock"
                        class="w-4 h-4 text-slate-400"
                    ></i>
                </div>
                <input
                    :type="show ? 'text' : 'password'"
                    name="password"
                    id="password-input"
                    class="block w-full pl-10 pr-12 py-2.5 bg-slate-50 border {{ $errors->has('password') ? 'border-red-300' : 'border-slate-200' }} rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all"
                    placeholder="••••••••"
                    required
                >
                <button
                    type="button"
                    id="password-addon"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-emerald-600 transition-colors"
                    onclick="togglePassword()"
                >
                    <i
                        id="eye-icon"
                        data-feather="eye"
                        class="w-4 h-4"
                    ></i>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input
                type="checkbox"
                name="remember"
                id="auth-remember-check"
                checked
                class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500 accent-emerald-600"
            >
            <label
                for="auth-remember-check"
                class="ml-2 block text-sm text-slate-600"
            >
                Ingat saya di perangkat ini
            </label>
        </div>

        <div class="pt-2">
            <button
                type="submit"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-emerald-200 active:transform active:scale-[0.98] transition-all flex items-center justify-center gap-2 group"
            >
                <span>Sign In to Dashboard</span>
                <i
                    data-feather="arrow-right"
                    class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                ></i>
            </button>
        </div>
    </form>

    <script>
        function togglePassword() {
            const input = document.getElementById('password-input');
            const icon = document.getElementById('eye-icon');

            if (input.type === 'password') {
                input.type = 'text';
                // Ganti icon ke eye-off jika pakai feather
                // Untuk demo sederhana tetap eye
            } else {
                input.type = 'password';
            }
        }
    </script>
</x-layouts.auth>
