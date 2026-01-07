<?php

namespace App\View\Components\Layouts\Landing;

use App\Models\Blog;
use App\Models\BlogCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarCategory extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = BlogCategory::with('blogs')->orderBy('name')->get();
        $racentPosts = Blog::latest()->take(3)->get();
        return view('components.layouts.landing.sidebar-category' , [
            'categories' => $categories,
            'racentPosts' => $racentPosts,
        ]);
    }
}
