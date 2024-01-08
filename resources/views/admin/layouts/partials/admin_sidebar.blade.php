<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" style="line-height: 10px" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    {{-- @php
        $userPermissions = userPermissions(Auth::id()); // Assuming Auth::id() returns the authenticated user's ID
    @endphp --}}

    {{-- @can('access_admin_panel')
        yes
    @else
        no
    @endcan --}}
    {{-- @if (auth()->user()->can('access_admin_panel')) --}}
{{--    <li class="nav-item   {{ request()->is('*/dashboard') ? 'active' : '' }}" style="min-height: 45px;">--}}

{{--        <a class="nav-link  {{ request()->is('*/dashboard') ? '' : 'collapsed' }}" href="#" data-toggle="collapse"--}}
{{--            data-target="#dashboardDropdown" aria-expanded="{{ request()->is('*/dashboard') ? 'true' : 'false' }}"--}}
{{--            aria-controls="dashboardDropdown">--}}
{{--            <i class="fas fa-fw fa-tachometer-alt"></i>--}}
{{--            <span>Dashboard</span>--}}
{{--        </a>--}}
{{--    </li>--}}
    <li class="nav-item mb-0 {{ request()->is('*/dashboard*') ? 'active' : 'collapsed' }}" style="min-height: 45px;">
        <a class="nav-link "
           href="{{route('admin.dashboard')}}"
        >
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item mb-0 {{ request()->is('*/categories*') ? 'active' : 'collapsed' }}" style="min-height: 45px;">
            <a class="nav-link "
               href="{{route('admin.categories.index')}}"
            >
                <i class="fas fa-fw fa-pencil-alt "></i>
                <span>Categoris</span>
            </a>
    </li>

    <li class="nav-item {{ request()->is('*users*') ? 'active' : '' }}" style="min-height: 45px;">
{{--        @can('create_comments', 'edit_own_comments', 'edit_any_comments', 'delete_own_comments', 'delete_any_comments')--}}
            <a class="nav-link" href="{{route('admin.users.index')}}"><i
                    class="fas fa-fw fa-user-alt"></i><span>Users</span></a>
{{--        @endcan--}}
    </li>
    <li class="nav-item {{ request()->is('*products*') ? 'active' : '' }}" style="min-height: 45px;">
{{--        @can('create_comments', 'edit_own_comments', 'edit_any_comments', 'delete_own_comments', 'delete_any_comments')--}}
            <a class="nav-link" href="{{route('admin.products.index')}}"><i
                    class="fas fa-fw fa-user-alt"></i><span>Products</span></a>
{{--        @endcan--}}
    </li>

    @php
        // Check if the user has permissions for any of the sub-options
        $hasCategoriesAccess = Gate::allows('categories_access');
        $hasCreatePostsAccess = Gate::allows('create_posts');
        $hasEditAnyPostsAccess = Gate::allows('edit_any_posts');
        $hasDeleteAnyPostsAccess = Gate::allows('delete_any_posts');
        $hasTagsAccess = Gate::allows('edit_tags') || Gate::allows('delete_tags');
        $hasUsersAccess = Gate::allows('view_users');
        $hasRolesAccess = Gate::allows('edit_roles');
    @endphp

    @if (
        $hasCategoriesAccess ||
            $hasCreatePostsAccess ||
            $hasEditAnyPostsAccess ||
            $hasDeleteAnyPostsAccess ||
            $hasTagsAccess)
        <li class="nav-item {{ request()->is(['*/posts/type*', '*admin/posts/create*']) ? 'active' : '' }}"
            style="min-height: 45px;">
            <a class="nav-link {{ request()->is(['*/posts/type*', '*admin/posts/create*']) ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#postViewDropdown"
                aria-expanded="{{ request()->is(['*/posts/type*', '*admin/posts/create*']) ? 'true' : 'false' }}"
                aria-controls="postViewDropdown">
                <i class="fas fa-fw fa-pencil-alt"></i>
                <span>Posts</span>
            </a>

            <div id="postViewDropdown"
                class="collapse {{ $hasCategoriesAccess || $hasCreatePostsAccess || $hasEditAnyPostsAccess || $hasDeleteAnyPostsAccess ? (request()->is(['*/posts/type*', '*/post-rankings/type*', '*admin/categories*', '*tags*', '*admin/posts/create*', '*admin/posts/edit*']) ? 'show' : '') : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($hasCreatePostsAccess)
                        <ul class="navbar-nav accordion" id="allPostsAccordion">
                            <li class="nav-item mb-0" style="min-height: 45px;">
                                <div>
                                    <a class="nav-link text-dark {{ request()->is(['*/posts/type*', '*admin/posts/create*']) ? '' : 'collapsed' }}"
                                        href="#" data-toggle="collapse" data-target="#allpostsDropdown"
                                        aria-expanded="{{ request()->is(['*/posts/type*', '*admin/posts/create*']) ? 'true' : 'false' }}"
                                        aria-controls="allpostsDropdown">
                                        <i class="fas fa-fw fa-newspaper text-dark"></i>
                                        <span>All Posts</span>
                                    </a>

                                    <div id="allpostsDropdown"
                                        class="collapse {{ request()->is(['*/posts/type*', '*admin/posts/create*', '*admin/posts/edit/*']) ? 'show' : '' }}"
                                        aria-labelledby="headingThree" data-parent="#allPostsAccordion">
                                        <div class="collapse-inner rounded">
                                            @foreach (\App\Models\NewsType::whereIn('admin_order', [0, 1])->orderBy('admin_order')->get() as $nt)
                                                <a class="collapse-item pl-0 pb-0 {{ request()->is(['*/posts/type/' . $nt->news_type_id, '*admin/posts/create/' . $nt->news_type_id]) ? 'active' : '' }}"
                                                    href="{{ route('admin.posts.index', ['newsTypeId' => $nt->news_type_id]) }}">
                                                    <i class="fas fa-fw fa-list-ul text-dark"></i>
                                                    {{ $nt->news_type }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endif
                    @if ($hasEditAnyPostsAccess)
                        <ul class="navbar-nav accordion p-0 m-0" id="ManagePostsRankingAccordion">
                            <li class="nav-item mb-0" style="min-height: 45px;">
                                <div>
                                    <a class="nav-link text-dark {{ request()->is('*post-rankings/type*') ? '' : 'collapsed' }}"
                                        href="#" data-toggle="collapse" data-target="#managePostsRankingDropdown"
                                        aria-expanded="{{ request()->is('*post-rankings/type*') ? 'true' : 'false' }}"
                                        aria-controls="managePostsRankingDropdown">
                                        <i class="fas fa-fw fa-newspaper text-dark"></i>
                                        <span>Manage Post Ranking</span>
                                    </a>

                                    <div id="managePostsRankingDropdown"
                                        class="collapse {{ request()->is('*post-rankings/type*') ? 'show' : '' }}"
                                        aria-labelledby="headingThree" data-parent="#ManagePostsRankingAccordion">
                                        <div class="collapse-inner rounded">
                                            @foreach (\App\Models\NewsType::whereIn('admin_order', [0, 1])->orderBy('admin_order')->get() as $nt)
                                                <a class="collapse-item pl-0 pb-0 {{ request()->is('admin/post-rankings/type/' . $nt->news_type_id) ? 'active' : '' }}"
                                                    href="{{ route('admin.post_rankings.index', ['newsTypeId' => $nt->news_type_id]) }}">
                                                    <i class="fas fa-fw fa-list-ul text-dark"></i>
                                                    {{ $nt->news_type }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endif

                    @can('categories_access')
                        <a class="collapse-item {{ request()->is('*admin/categories*') ? 'active' : '' }}"
                            href="{{ route('admin.categories.index') }}"><i class="fas fa-fw fa-sitemap text-dark"></i>
                            Categories</a>
                    @endcan

                    @can('edit_tags', 'delete_tags')
                        <a class="collapse-item {{ request()->is('*tags*') ? 'active' : '' }}"
                            href="{{ route('admin.tags.index') }}"><i class="fas fa-fw fa-tags text-dark"></i> Tags</a>
                    @endcan
                </div>
            </div>
        </li>
    @endif

    @can('view_comments')
        <li class="nav-item {{ request()->is('*comments*') ? 'active' : '' }}" style="min-height: 45px;">
            @can('create_comments', 'edit_own_comments', 'edit_any_comments', 'delete_own_comments', 'delete_any_comments')
                <a class="nav-link" href="{{ route('admin.comments.index') }}"><i
                        class="fas fa-fw fa-comments"></i><span>All Comments</span></a>
            @endcan
        </li>
    @endcan

    @can('create_real_estate_listings', 'edit_own_real_estate_listings', 'edit_any_real_estate_listings',
        'delete_own_real_estate_listings', 'delete_any_real_estate_listings', 'view_real_estate_listings')
        <li class="nav-item {{ request()->is('*real-estates*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.real_estates.index') }}"><i
                    class="fas fa-fw fa-home"></i><span>Manage Real Estate</span></a>
        </li>
    @endcan

    @can('create_obituaries', 'edit_own_obituaries', 'edit_any_obituaries', 'delete_own_obituaries',
        'delete_any_obituaries', 'view_obituaries')
        <li class="nav-item {{ request()->is('*obituaries*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.obituaries.index') }}"><i
                    class="fas fa-fw fa-list"></i><span>Manage Obituary</span></a>
        </li>
    @endcan

    @can('create_legal_notices', 'edit_own_legal_notices', 'edit_any_legal_notices', 'delete_own_legal_notices',
        'delete_any_legal_notices', 'view_legal_notices')
        <li class="nav-item {{ request()->is('*legal-notices*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.legal_notices.index') }}"><i
                    class="fas fa-fw fa-list"></i><span>Manage Legal Notice</span></a>
        </li>
    @endcan

    @can('create_galleries', 'edit_own_galleries', 'edit_any_galleries', 'delete_own_galleries', 'delete_any_galleries',
        'view_galleries')
        <li class="nav-item {{ request()->is('*galleries*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.galleries.index') }}"><i
                    class="fas fa-fw fa-photo-video"></i><span>Manage Galleries</span></a>
        </li>
    @endcan

    @if ($hasUsersAccess || $hasRolesAccess)
        <li class="nav-item mb-0 {{ request()->is('*admin/users*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link  {{ request()->is('*admin/users*') ? '' : 'collapsed' }}" href="#"
                data-toggle="collapse" data-target="#manageUsersDropdown"
                aria-expanded="{{ request()->is('*admin/users*') ? 'true' : 'false' }}"
                aria-controls="manageUsersDropdown">
                <i class="fas fa-fw fa-users"></i>
                <span>Manage Users</span>
            </a>
            <div id="manageUsersDropdown"
                class="collapse {{ request()->is(['*admin/users*', '*admin/roles*']) ? 'show' : '' }}"
                aria-labelledby="headingTwo">
                <div class="bg-white py-2 collapse-inner rounded">

                    @can('edit_roles', 'delete_roles')
                        <a class="collapse-item pl-0 pb-0 {{ request()->is('*admin/roles*') ? 'active' : '' }}"
                            href="{{ route('admin.roles.index') }}"><i class="fas fa-fw fa-user"></i> <span>User
                                Roles</span></a>
                    @endcan
                    @can('create_users', 'edit_users', 'delete_users', 'view_users', 'toggle_user_activity')
                        <a class="collapse-item pl-0 pb-0 {{ request()->is('*admin/users*') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}"><i class="fas fa-fw fa-users"></i> <span>All
                                Users</span></a>
                    @endcan
                </div>
            </div>
        </li>
    @endif


    @can('create_pages', 'edit_own_pages', 'edit_any_pages', 'delete_own_pages', 'delete_any_pages', 'view_pages')
        <li class="nav-item {{ request()->is('*pages*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.pages.index') }}"><i class="fas fa-fw fa-file"></i><span>Manage
                    Pages</span></a>
        </li>
    @endcan

    @can('process_payments', 'refund_payments', 'view_payment_history')
        <li class="nav-item {{ request()->is('*membership-plans*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.membership_plans.index') }}"><i
                    class="fas fa-fw fa-money-bill"></i><span>Manage Payments</span></a>
        </li>
    @endcan


    @can('modify_application_settings', 'configure_system_preferences')
        <li class="nav-item mb-0 {{ request()->is('*admin/settings*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link {{ request()->is('*admin/settings*') ? '' : 'collapsed' }}" href="#"
                data-toggle="collapse" data-target="#settingsDropdown"
                aria-expanded="{{ request()->is('*admin/settings*') ? 'true' : 'false' }}"
                aria-controls="settingsDropdown">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Settings</span>
            </a>
            <div id="settingsDropdown" class="collapse {{ request()->is(['*admin/settings*']) ? 'show' : '' }}"
                aria-labelledby="headingTwo">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item px-0 pl-0 {{ request()->is('*admin/settings/general*') ? 'active' : '' }}"
                        href="{{ route('admin.settings.general') }}"><i class="fas fa-fw fa-wrench"></i>
                        <span>General
                            Settings</span></a>
                    <a class="collapse-item px-0 pl-0 {{ request()->is('*admin/settings/facebook-ads*') ? 'active' : '' }}"
                        href="{{ route('admin.settings.facebook_ads') }}"><i class="fas fa-fw fa-cog"></i>
                        <span>Facebook
                            Ads Settings</span></a>
                    <a class="collapse-item px-0 pl-0 {{ request()->is('*admin/settings/abusive-words*') ? 'active' : '' }}"
                        href="{{ route('admin.settings.abusive_words') }}"><i class="fas fa-fw fa-cog"></i>
                        <span>Abusive
                            Words Settings</span></a>
                    <a class="collapse-item px-0 pl-0 {{ request()->is('*admin/settings/featured-marketing*') ? 'active' : '' }}"
                        href="{{ route('admin.settings.featured_marketing') }}"><i class="fas fa-fw fa-cog"></i>
                        <span>Featured Marketing</span></a>
                </div>
            </div>
        </li>
    @endcan
    @can('create_advertisements', 'edit_own_advertisements', 'edit_any_advertisements', 'delete_own_advertisements',
        'delete_any_advertisements', 'view_advertisements')
        <li class="nav-item {{ request()->is('*/advertisement*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.ads.index') }}"><i
                    class="fas fa-fw fa-bullhorn"></i><span>Advertisement</span></a>
        </li>
    @endcan

    @can('upload_videos', 'edit_own_videos', 'edit_any_videos', 'delete_own_videos', 'delete_any_videos', 'view_videos')
        <li class="nav-item {{ request()->is('*/videos*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.videos.index') }}"><i class="fas fa-fw fa-video"></i><span>Manage
                    Videos</span></a>
        </li>
    @endcan

    @can('create_vic_regional_news', 'edit_vic_regional_news', 'delete_vic_regional_news', 'view_vic_regional_news')
        <li class="nav-item {{ request()->is('*vi-videos*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.vi_videos.index') }}"><i class="fas fa-fw fa-video"></i><span>VIC
                    Regional News</span></a>
        </li>
    @endcan

    @can('upload_massive_videos_for_homepage', 'edit_massive_videos_at_homepage', 'delete_massive_videos_at_homepage',
        'view_massive_videos_at_homepage')
        <li class="nav-item {{ request()->is('*massive-videos*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.massive_videos.index') }}"><i
                    class="fas fa-fw fa-video"></i><span>Massive Video at Home page</span></a>
        </li>
    @endcan

    @can('manage_pueblo_section_content', 'edit_pueblo_content', 'delete_pueblo_content', 'view_pueblo_content')
        <li class="nav-item {{ request()->is('*manage-pueblo*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.manage_pueblo.index') }}"><i
                    class="fas fa-fw fa-image"></i><span>Manage Pueblo</span></a>
        </li>
    @endcan

    @can('manage_plaza_extra_east_section_content', 'edit_plaza_extra_east_content', 'delete_plaza_extra_east_content',
        'view_plaza_extra_east_content')
        <li class="nav-item {{ request()->is('*manage-plaza*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.manage_plaza.index') }}"><i
                    class="fas fa-fw fa-image"></i><span>Plaza Extra East</span></a>
        </li>
    @endcan


    @can('create_survey_questions', 'edit_survey_questions', 'delete_survey_questions', 'view_survey_questions')
        <li class="nav-item mb-0 {{ request()->is(['*admin/questions*', '*admin/survey']) ? 'active' : '' }}"
            style="min-height: 45px;">
            <a class="nav-link  {{ request()->is(['*admin/questions*', '*admin/survey']) ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#surveyDropdown"
                aria-expanded="{{ request()->is(['*admin/questions*', '*admin/survey']) ? 'true' : 'false' }}"
                aria-controls="surveyDropdown">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Survey Questions</span>
            </a>
            <div id="surveyDropdown"
                class="collapse {{ request()->is(['*admin/questions*', '*admin/survey']) ? 'show' : '' }}"
                aria-labelledby="surveyDropdown">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item px-0 pl-0 {{ request()->is(['*admin/questions*']) ? 'active' : '' }}"
                        href="{{ route('admin.questions.index') }}"><i class="fas fa-fw fa-list"></i> <span>Manage
                            survey
                            questions</span></a>
                    <a class="collapse-item px-0 pl-0 {{ request()->is('*admin/survey*') ? 'active' : '' }}"
                        href="{{ route('admin.survey.index') }}"><i class="fas fa-fw fa-info"></i> <span>Question
                            survey
                            details</span></a>
                </div>
            </div>
        </li>
    @endcan

    @can('customize_homepage_layout', 'manage_homepage_content', 'view_homepage_settings')
        <li class="nav-item {{ request()->is('*homepage-customization*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.homepage.customization') }}"><i
                    class="fas fa-fw fa-list"></i><span>Customize Homepage</span></a>
        </li>
    @endcan

    @can('customize_top_navigation', 'manage_top_navigation_links', 'view_top_navigation_settings')
        <li class="nav-item {{ request()->is('*topnav-customization*') ? 'active' : '' }}" style="min-height: 45px;">
            <a class="nav-link" href="{{ route('admin.topnav.sorting') }}"><i
                    class="fas fa-fw fa-list"></i><span>Customize Top Nav</span></a>
        </li>
    @endcan


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
