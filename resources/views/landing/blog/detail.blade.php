<x-layouts.landing>
    <div class="blog-area py-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-single-wrap">
                        <div class="blog-single-content">
                            <div class="blog-thumb-img text-center">
                                <img src="{{ $blog->thumbnail }}"
                                    alt="thumb">
                            </div>
                            <div class="blog-info">
                                <div class="blog-meta">
                                    <div class="blog-meta-left">

                                    </div>
                                    <div class="blog-meta-right">

                                    </div>
                                </div>
                                <div class="blog-details">
                                    <h3 class="blog-details-title mb-20">
                                        {{ $blog->title }}
                                    </h3>
                                    <p class="mb-10">
                                       {!! $blog->content !!}
                                    </p>

                                    <hr>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <x-layouts.landing.sidebar-category />
                </div>
            </div>
        </div>
    </div>
</x-layouts.landing>
