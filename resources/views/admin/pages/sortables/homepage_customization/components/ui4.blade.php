{{--ui 4 e.g. government--}}
<section class="row mb-3 shimmer-container">
    <div class="col-12 col-lg-8">
        <div class="section-title mb-3 shimmer-line shimmer"></div>
        {{--left--}}
        <div class="row">
            {{--col 1--}}
            <div class="col">
                <div class="shimmer-container">
                    <h5>Main Story Col 1</h5>
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_image')
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 10])
                </div>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                </div>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                </div>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                </div>
            </div>
            {{--col 2--}}
            <div class="col">
                <div class="shimmer-container">
                    <h5>Main Story Col 2</h5>
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_image')
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 10])
                </div>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                </div>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                </div>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
                </div>
            </div>
        </div>
    </div>
    {{--right--}}
    @include('admin.pages.sortables.homepage_customization.components.shimmer_more_ads')
</section>
