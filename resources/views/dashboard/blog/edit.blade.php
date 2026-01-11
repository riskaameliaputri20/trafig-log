<x-layouts.dashboard title="Edit Article: {{ $blog->title }}">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic">
                Edit <span class="text-emerald-500">Article</span>
            </h2>
            <p class="text-xs text-slate-500 font-medium">Updating: {{ $blog->title }}</p>
        </div>
        <a href="{{ route('dashboard.blog.index') }}" class="text-xs font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest flex items-center gap-2">
            <i class="ri-arrow-left-line"></i> Back to List
        </a>
    </div>

    <form action="{{ route('dashboard.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Article Title</label>
                        <input type="text" name="title" value="{{ old('title', $blog->title) }}"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all shadow-sm">
                        @error('title') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Short Summary</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all shadow-sm">{{ old('description', $blog->description) }}</textarea>
                        @error('description') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Full Content</label>
                        <textarea name="content" id="editor" rows="12"
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all shadow-sm">{{ old('content', $blog->content) }}</textarea>
                        @error('content') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm space-y-8">

                    <div x-data="{ photoPreview: null }">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-4">Update Thumbnail</label>
                        <div class="relative group">
                            <div class="aspect-video bg-slate-100 rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 flex items-center justify-center transition-all group-hover:border-emerald-300">
                                <template x-if="!photoPreview">
                                    <img src="{{ $blog->thumbnail }}" class="w-full h-full object-cover">
                                </template>
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover animate-in fade-in duration-300">
                                </template>
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-slate-900/40 backdrop-blur-sm rounded-2xl cursor-pointer">
                                <i class="ri-camera-switch-line text-white text-3xl"></i>
                            </div>
                            <input type="file" name="thumbnail" class="absolute inset-0 opacity-0 cursor-pointer"
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file); }">
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold uppercase mt-3 text-center tracking-tighter italic">Click image to change (Max 2MB)</p>
                        @error('thumbnail') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest text-center">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Category</label>
                        <select name="blog_category_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold appearance-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $blog->blog_category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                        <div class="flex justify-between items-center text-[10px] font-bold">
                            <span class="text-slate-400 uppercase">Slug:</span>
                            <span class="text-slate-600 truncate max-w-[120px]">{{ $blog->slug }}</span>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-bold">
                            <span class="text-slate-400 uppercase">Created:</span>
                            <span class="text-slate-600">{{ $blog->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4">
                        <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
                            <i class="ri-save-3-line text-sm"></i> Update Changes
                        </button>
                        <button type="reset" class="w-full py-3 bg-white text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:text-rose-600 transition-colors">
                            Discard Edits
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layouts.dashboard>
