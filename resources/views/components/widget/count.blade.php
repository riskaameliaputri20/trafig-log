@props(['title', 'count', 'icon', 'class' => 'col-xl-6 col-md-6'])
<div class="{{ $class }}">
    <div class="card card-animate">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="fw-medium text-muted mb-0">{{ Str::title($title) }}</p>
                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                            data-target="{{ $count }}">{{ $count }}</span></h2>
                </div>
                <div>
                    <div class="avatar-sm text-white text-center rounded-circle bg-info">
                        <i class="{{ $icon }} " style="font-size: 36px"></i>
                    </div>
                </div>
            </div>
        </div><!-- end card body -->
    </div> <!-- end card-->
</div>
