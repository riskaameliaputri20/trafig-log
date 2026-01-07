<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(4);
        return view('landing.blog.index', ['blogs' => $blogs]);
    }
    public function category($name)
    {
        // Ambil kategori terlebih dahulu
        $category = BlogCategory::whereName($name)->first();

        if (!$category) {
            abort(404, 'Kategori tidak ditemukan');
        }

        // Ambil semua blog yang termasuk kategori ini
        $blogs = Blog::where('blog_category_id', $category->id)->paginate(4);

        if ($blogs->isEmpty()) {
            abort(404, 'Belum ada blog dalam kategori ini');
        }

        // Kirim ke view
        return view('landing.blog.category', [
            'blogs' => $blogs
        ]);
    }
    public function detail($slug)
    {
        $blog = Blog::findBySlug($slug);
        if (!$blog) {
            abort(404);
        }
        return view('landing.blog.detail', ['blog' => $blog]);
    }
}
