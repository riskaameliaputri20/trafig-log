@props(['blog'])
<div class="col-md-6">
    <div class="blog-item wow fadeInUp" data-wow-delay=".25s"
        style="visibility: visible; animation-delay: 0.25s; animation-name: fadeInUp;">
        <span class="blog-date"><i class="far fa-calendar-alt"></i> {{ $blog->created_at->format('M d, Y') }}</span>
        <div class="blog-item-img">
            <img src="{{ $blog->thumbnail }}" alt="Thumb">
        </div>
        <div class="blog-item-info">
            <h4 class="blog-title">
                <a href="{{ route('landing.blog.detail' , ['slug' => $blog->slug] ) }}">
                    {{ $blog->title }}
                </a>
            </h4>
            <p>{!! $blog->description !!}</p>

        </div>
    </div>
</div>
