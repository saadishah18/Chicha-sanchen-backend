{{--ui 6 e.g. usvi ports hub--}}
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
            {{--col 2--}}
            <div class="col">
                <div class="shimmer-container">
                    <h5>Main Story Col 2</h5>
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_image')
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 10])
                </div>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 5])
                </div>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 5])
                </div>
                <div class="shimmer-container">
                    @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 5 ])
                </div>
            </div>
        </div>
    </div>
    {{--right--}}
    <div class="col">
        <h5>Ads</h5>
        <div class="shimmer-container">
            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 4])
        </div>
        <div class="shimmer-container">
            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_ad_image')
        </div>
        <div class="shimmer-container">
            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 5])
        </div>
        <div class="shimmer-container">
            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 5])
        </div>
        <div class="shimmer-container">
            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmer_lines',['lines' => 6])
        </div>
        <div class="shimmer-container">
            @include('admin.pages.sortables.homepage_customization.components.shimmers.shimmering_image')
        </div>
    </div>
</section>
