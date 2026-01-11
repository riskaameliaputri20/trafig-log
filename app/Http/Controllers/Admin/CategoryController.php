<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori untuk tabel (dengan paginasi)
        $categories = BlogCategory::withCount('blogs')->latest()->paginate(10);

        // Cek apakah ada request 'edit' (ID kategori yang ingin diedit)
        $categoryEdit = null;
        if ($request->has('edit')) {
            $categoryEdit = BlogCategory::find($request->edit);
        }

        return view('dashboard.category.index', compact('categories', 'categoryEdit'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:blog_categories,name|max:100',
        ]);

        BlogCategory::create($data);
        sweetalert('Kategori berhasil ditambahkan', 'success');
        return redirect()->route('dashboard.category.index');
    }

    public function update(Request $request, BlogCategory $category)
    {
        $data = $request->validate([
            'name' => 'required|max:100|unique:blog_categories,name,' . $category->id,
        ]);

        $category->update($data);
        sweetalert('Kategori berhasil diperbarui', 'success');
        return redirect()->route('dashboard.category.index');
    }

    public function destroy(BlogCategory $category)
    {
        // Proteksi: Jangan hapus jika ada blog
        if ($category->blogs()->count() > 0) {
            sweetalert('Gagal! Kategori masih memiliki artikel.', 'error');
            return back();
        }

        $category->delete();
        sweetalert('Kategori berhasil dihapus', 'success');
        return back();
    }
}
