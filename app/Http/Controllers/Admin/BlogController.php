<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\BlogCategory;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(10);
        return view('dashboard.blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('dashboard.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'description' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('blogs', 'public');
        }

        Blog::create($data);
        sweetalert('Artikel berhasil diterbitkan', 'success');
        return redirect()->route('dashboard.blog.index');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        return view('dashboard.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'description' => 'required',
            'content' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:10048',
        ]);

        if ($request->hasFile('thumbnail')) {
            // AMBIL PATH ASLI dari database (bukan URL dari Accessor)
            $oldPath = $blog->getRawOriginal('thumbnail');

            // Hapus file lama jika path-nya ada di database dan filenya benar-benar ada di storage
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Simpan file baru
            $data['thumbnail'] = $request->file('thumbnail')->store('blogs', 'public');
        }

        $blog->update($data);

        sweetalert('Artikel berhasil diperbarui', 'success');
        return redirect()->route('dashboard.blog.index');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->thumbnail)
            Storage::disk('public')->delete($blog->thumbnail);
        $blog->delete();
        sweetalert('Artikel berhasil dihapus', 'success');
        return back();
    }
}
