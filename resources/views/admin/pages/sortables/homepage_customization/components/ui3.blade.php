{{--ui 3 e.g. caribbean--}}
<section class="row mb-3 shimmer-container">
    <div class="col-12 col-lg-8">
        <div class="section-title mb-3 shimmer-line shimmer"></div>
        {{--left--}}
        <div class="row">
            {{--col 1--}}
            <div class="col">
                <div class="shimmer-container mb-0">
                    <h5>More news</h5>
                    <div class="row">
                        <div class="col-6">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_large_square_image')
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 2])
                        </div>
                        <div class="col-6">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_large_square_image')
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 2])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_large_square_image')
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 2])
                        </div>
                        <div class="col-6">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_large_square_image')
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 2])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_large_square_image')
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 2])
                        </div>
                        <div class="col-6">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_large_square_image')
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 2])
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{--right--}}
    @include('admin.pages.sortables.homepage_customization.components.shimmer_ads')
</section>
