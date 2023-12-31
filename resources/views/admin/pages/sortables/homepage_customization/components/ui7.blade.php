{{--ui 7 .e.g videos--}}
<section class="row mb-3 shimmer-container">
    <div class="col-12 col-lg-12">
        <div class="section-title mb-3 shimmer-line shimmer"></div>
        {{--left--}}
        <div class="row">
            {{--col 1--}}
            <div class="col-lg-8 col-md-8">
                <div class="shimmer-container">
                    <h5>Main Video</h5>
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_image')
                </div>
                <div class="shimmer-container">
                @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_bold_lines',['lines' => 1])

                </div>
            </div>
            {{--col 2--}}
            <div class="col-lg-4 col-md-4">
                <h5>Other videos</h5>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                </div>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                </div>
                <div class="shimmer-container">
{{--                    @include('admin.pages.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])--}}
                </div>
            </div>
        </div>
    </div>
    {{--right--}}
{{--    @include('admin.pages.homepage_customization.components.shimmer_ads')--}}
</section>
