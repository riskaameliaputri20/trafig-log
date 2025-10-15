<aside class="sidebar">
    <!-- category -->
    <div class="widget category">
        <h5 class="widget-title">Category</h5>
        <div class="category-list">
            @foreach ($categories as $blogCategory)
                <a href="{{ route('landing.blog.category' , ['name' => $blogCategory->name]) }}">
                    <i class="far fa-arrow-right"></i>
                    {{ Str::title($blogCategory->name) }}
                    <span>
                        ({{ $blogCategory->blogs->count() }})
                    </span>
                </a>
            @endforeach
        </div>
    </div>
    <!-- recent post -->
    <div class="widget recent-post">
        <h5 class="widget-title">Recent Post</h5>
        @foreach ($racentPosts as $blog)
            <div class="recent-post-item">
                <div class="recent-post-img">
                    <img src="{{ $blog->thumbnail }}" alt="thumb" >
                </div>
                <div class="recent-post-bio">
                    <h6>
                        <a href="{{ route('landing.blog.detail' , ['slug' => $blog->slug]) }}">
                            {{ $blog->title }}
                        </a>
                    </h6>
                    <span><i class="far fa-clock"></i>{{ $blog->created_at->format('F d, Y') }}</span>
                </div>
            </div>
        @endforeach

    </div>
</aside>
