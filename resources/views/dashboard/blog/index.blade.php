<x-layouts.dashboard title="Management Blog">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic">
                Blog <span class="text-emerald-500">Management</span>
            </h2>
            <p class="text-sm text-slate-500 font-medium italic">Create, edit, and organize your articles</p>
        </div>
        <a href="{{ route('dashboard.blog.create') }}"
           class="px-5 py-2.5 bg-slate-900 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200 flex items-center gap-2">
            <i class="ri-add-line text-lg"></i> Create New Post
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Article</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($blogs as $blog)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $blog->thumbnail }}" class="size-12 rounded-xl object-cover border border-slate-100 shadow-sm">
                                <div class="max-w-xs xl:max-w-md">
                                    <h5 class="text-sm font-black text-slate-900 truncate tracking-tight">{{ $blog->title }}</h5>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $blog->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded text-[9px] font-black uppercase tracking-widest border border-emerald-100">
                                {{ $blog->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase italic">
                            {{ $blog->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('dashboard.blog.edit', $blog->id) }}" class="size-8 bg-slate-50 text-slate-400 rounded-lg flex items-center justify-center hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <form action="{{ route('dashboard.blog.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="size-8 bg-slate-50 text-slate-400 rounded-lg flex items-center justify-center hover:bg-rose-50 hover:text-rose-600 transition-colors">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            {{ $blogs->links() }}
        </div>
    </div>
</x-layouts.dashboard>
