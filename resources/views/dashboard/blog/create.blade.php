<x-layouts.dashboard title="Create Post">
    <div class="mb-8">
        <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic">Write <span class="text-emerald-500">Post</span></h2>
    </div>

    <form action="{{ route('dashboard.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Title</label>
                        <input type="text" name="title" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all" placeholder="Enter post title">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Short Description</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all"></textarea>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Article Content</label>
                        <textarea name="content" rows="10" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all"></textarea>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-4">Thumbnail</label>
                        <div class="relative group" x-data="{ photoPreview: null }">
                            <div class="aspect-video bg-slate-100 rounded-2xl overflow-hidden border-2 border-dashed border-slate-200 flex items-center justify-center">
                                <template x-if="!photoPreview">
                                    <i class="ri-image-add-line text-4xl text-slate-300"></i>
                                </template>
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                            </div>
                            <input type="file" name="thumbnail" class="absolute inset-0 opacity-0 cursor-pointer"
                                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file); }">
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Category</label>
                        <select name="blog_category_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-bold appearance-none">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-6 border-t border-slate-50">
                        <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200">
                            Publish Article
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layouts.dashboard>
