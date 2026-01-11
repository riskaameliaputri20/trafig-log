<x-layouts.dashboard title="Blog Categories">
    <div class="mb-8">
        <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic">
            Category <span class="text-emerald-500">Management</span>
        </h2>
        <p class="text-sm text-slate-500 font-medium italic">Add and organize your blog topics in one place</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <div class="lg:col-span-4 sticky top-8">
            <div class="{{ $categoryEdit ? 'border-emerald-200 bg-emerald-50/20' : 'border-slate-100 bg-white' }} p-8 rounded-[2rem] border shadow-sm relative overflow-hidden transition-all duration-500">
                <div class="absolute -right-4 -top-4 size-20 {{ $categoryEdit ? 'bg-emerald-200' : 'bg-emerald-50' }} rounded-full opacity-50"></div>

                <h5 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em] mb-6 relative z-10 flex items-center gap-2">
                    <i class="{{ $categoryEdit ? 'ri-edit-circle-line text-emerald-600' : 'ri-add-circle-line text-emerald-500' }} text-lg"></i>
                    {{ $categoryEdit ? 'Edit Category' : 'Create New Category' }}
                </h5>

                <form action="{{ $categoryEdit ? route('dashboard.category.update', $categoryEdit->id) : route('dashboard.category.store') }}" method="POST">
                    @csrf
                    @if($categoryEdit) @method('PUT') @endif

                    <div class="space-y-6 relative z-10">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Category Name</label>
                            <input type="text" name="name"
                                   value="{{ old('name', $categoryEdit->name ?? '') }}"
                                   class="w-full px-4 py-4 bg-white border {{ $categoryEdit ? 'border-emerald-200' : 'border-slate-200' }} rounded-2xl text-sm font-bold focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none"
                                   placeholder="e.g. Technology" autofocus>
                            @error('name')
                                <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest animate-pulse">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <button type="submit" class="w-full py-4 {{ $categoryEdit ? 'bg-emerald-600' : 'bg-slate-900' }} text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:opacity-90 transition-all shadow-lg flex items-center justify-center gap-2">
                                <i class="{{ $categoryEdit ? 'ri-save-3-line' : 'ri-save-line' }}"></i>
                                {{ $categoryEdit ? 'Update Category' : 'Save Category' }}
                            </button>

                            @if($categoryEdit)
                                <a href="{{ route('dashboard.category.index') }}" class="w-full py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-600 transition-colors">
                                    Cancel & Create New
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            </div>

        <div class="lg:col-span-8">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/30 flex items-center justify-between">
                    <h5 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em]">Existing Categories</h5>
                    <span class="text-[10px] font-bold text-slate-400 uppercase italic">{{ $categories->total() }} Total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <th class="px-6 py-4">#</th>
                                <th class="px-6 py-4">Category Name</th>
                                <th class="px-6 py-4 text-center">Articles</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($categories as $cat)
                            <tr class="hover:bg-slate-50/50 transition-colors group {{ $categoryEdit && $categoryEdit->id == $cat->id ? 'bg-emerald-50/50' : '' }}">
                                <td class="px-6 py-4 text-xs font-bold text-slate-300">
                                    {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 font-black text-slate-700 uppercase tracking-tight">{{ $cat->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black border border-emerald-100">
                                        {{ $cat->blogs_count }} <span class="opacity-60">Posts</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('dashboard.category.index', ['edit' => $cat->id, 'page' => $categories->currentPage()]) }}"
                                           class="size-9 {{ $categoryEdit && $categoryEdit->id == $cat->id ? 'bg-emerald-600 text-white' : 'bg-slate-50 text-slate-400' }} rounded-xl flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                            <i class="ri-edit-line text-lg"></i>
                                        </a>
                                        <form action="{{ route('dashboard.category.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="size-9 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                                <i class="ri-delete-bin-line text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-slate-50/50 border-t border-slate-50">
                    {{ $categories->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
