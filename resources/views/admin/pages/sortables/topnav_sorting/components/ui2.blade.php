{{--ui 2 business--}}
<section class="row mb-3 shimmer-container">
    <div class="col-12 col-lg-8">
        <div class="section-title mb-3 shimmer-line shimmer"></div>
        {{--left--}}
        <div class="row">
            {{--col 1--}}
            <div class="col">
                <div class="shimmer-container mb-0">
                    <h5>Main Stories</h5>
                    <div class="row">
                        <div class="col-4">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_square_image')
                        </div>
                        <div class="col-8 pt-0 mt-0">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                        </div>
                    </div>
                </div>
                <div class="shimmer-container ">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 3])
                </div>
                <div class="shimmer-container mb-0">
                    <div class="row">
                        <div class="col-4">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_square_image')
                        </div>
                        <div class="col-8 pt-0 mt-0">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                        </div>
                    </div>
                </div>
                <div class="shimmer-container ">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 3])
                </div>
                <div class="shimmer-container mb-0">
                    <div class="row">
                        <div class="col-4">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_square_image')
                        </div>
                        <div class="col-8 pt-0 mt-0">
                            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                        </div>
                    </div>
                </div>
                <div class="shimmer-container ">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 3])
                </div>


            </div>
        </div>
    </div>
    {{--right--}}
    @include('admin.pages.sortables.homepage_customization.components.shimmer_more_news')
</section>
