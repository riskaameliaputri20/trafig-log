<x-layouts.landing>


    <!-- blog area -->
    <div class="blog-area2 mb-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8 col-12">
                    <div class="row g-4">
                        @foreach ($blogs as $blog)
                            <x-card.blog-card :blog="$blog" />
                        @endforeach
                    </div>
                    <!-- pagination -->
                    <div class="pagination-area mt-60">
                        <div aria-label="Page navigation example d-flex">
                            {{ $blogs->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                    <!-- pagination end -->
                </div>
                <div class="col-lg-4 col-12">
                    <x-layouts.landing.sidebar-category />
                </div>
            </div>
        </div>
    </div>
    <!-- blog area end -->
</x-layouts.landing>
