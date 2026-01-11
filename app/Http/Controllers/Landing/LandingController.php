<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil artikel terbaru untuk Featured Post
        $featured = Blog::latest()->first();

        // Ambil sisa artikel dengan paginasi, kecualikan ID featured post
        $posts = Blog::with('category')
            ->when($featured, function ($query) use ($featured) {
                return $query->where('id', '!=', $featured->id);
            })
            ->latest()
            ->paginate(10);

        return view('landing.index', compact('featured', 'posts'));
    }

    public function show(Blog $blog)
    {
        return view('landing.show', compact('blog'));
    }

    public function features() {
    return view('landing.features');
}

public function about() {
    return view('landing.about');
}
}
