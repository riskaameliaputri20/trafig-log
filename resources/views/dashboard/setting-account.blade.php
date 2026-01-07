<x-layouts.dashboard title="Setting Account">
    <form action="{{ route('dashboard.setting.account.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <div class="relative -mx-4 -mt-4 h-48 md:h-64 overflow-hidden rounded-b-[2rem] shadow-inner bg-slate-900">
            <img src="{{ asset('dashboard/assets/images/profile-bg.jpg') }}" 
                 class="w-full h-full object-cover opacity-50 transition-transform duration-700 hover:scale-110" 
                 alt="Profile Background">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 -mt-16 md:-mt-24 relative z-10 px-2">
            
            <div class="lg:col-span-4">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8 text-center transition-all hover:shadow-2xl">
                    <div class="relative inline-block group" x-data="{ photoPreview: null }">
                        <div class="size-32 md:size-40 rounded-full ring-8 ring-white shadow-2xl overflow-hidden bg-slate-100 mx-auto">
                            <img :src="photoPreview ? photoPreview : '{{ Storage::url(auth()->user()->profile) }}'" 
                                 id="profile-display"
                                 class="w-full h-full object-cover" 
                                 alt="User Profile">
                        </div>

                        <label for="profile-img-file-input" class="absolute bottom-2 right-2 size-10 bg-emerald-600 text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:bg-emerald-700 hover:scale-110 transition-all border-4 border-white">
                            <i class="ri-camera-fill text-lg"></i>
                            <input id="profile-img-file-input" name="profile" type="file" class="hidden" accept="image/*"
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file); }">
                        </label>
                    </div>

                    <div class="mt-6">
                        <h5 class="text-xl font-black text-slate-900 uppercase tracking-tight italic">{{ auth()->user()->name }}</h5>
                        <p class="text-[10px] font-black text-emerald-600 bg-emerald-50 inline-block px-3 py-1 rounded-full uppercase tracking-[0.2em] mt-2 border border-emerald-100">
                            Administrator
                        </p>
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-50 flex justify-around text-center">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Account Status</p>
                            <p class="text-xs font-bold text-emerald-500 mt-1 uppercase">Verified</p>
                        </div>
                        <div class="w-px h-8 bg-slate-100"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">System Access</p>
                            <p class="text-xs font-bold text-slate-700 mt-1 uppercase">Full Access</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-50 bg-slate-50/30 flex items-center gap-3">
                        <div class="size-8 bg-slate-900 text-white rounded-lg flex items-center justify-center shadow-sm">
                            <i class="ri-settings-3-line"></i>
                        </div>
                        <h5 class="text-xs font-black text-slate-900 uppercase tracking-widest">Account Configuration</h5>
                    </div>

                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Full Name</label>
                            <div class="relative group">
                                <i class="ri-user-line absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                <input type="text" name="name" value="{{ $user->name }}"
                                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all"
                                       placeholder="Enter your name">
                            </div>
                            @error('name') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Email Address</label>
                            <div class="relative group">
                                <i class="ri-mail-line absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                <input type="email" name="email" value="{{ $user->email }}"
                                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all"
                                       placeholder="Enter your email">
                            </div>
                            @error('email') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">New Password (optional)</label>
                            <div class="relative group">
                                <i class="ri-lock-password-line absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                <input type="password" name="password"
                                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all"
                                       placeholder="Leave blank to keep current password">
                            </div>
                            @error('password') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-6 border-t border-slate-50 flex items-center justify-end gap-3">
                            <button type="reset" class="px-6 py-3 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">
                                Reset Changes
                            </button>
                            <button type="submit" class="px-8 py-3 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200 flex items-center gap-2">
                                <i class="ri-save-line text-sm"></i> Update Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layouts.dashboard>