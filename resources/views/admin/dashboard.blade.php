@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <h4 class="h6 mb-0 text-gray-800">Control Panel</h4>
        </div>

        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            @can('view_users')
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Users</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="text-center bg-gray-100 pb-0 mb-0"><a href="{{ route('admin.users.index') }}">More Info<i
                                    class="fas fa-arrow-circle-right text-gray-300 ml-2"></i> </a></div>
                    </div>
                </div>
            @endcan

            <!-- Earnings (Annual) Card Example -->
{{--            @can('categories_access')--}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Categories</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
{{--                                        {{ \App\Models\SidebarCategory::count() }}--}}
                                        234
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-grip-lines fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="text-center bg-gray-100 pb-0 mb-0"><a href="#">More
                                Info<i class="fas fa-arrow-circle-right text-gray-300 ml-2"></i> </a></div>
                    </div>
                </div>
{{--            @endcan--}}

            <!-- Posts -->
{{--            @can('view_posts')--}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Posts</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
{{--                                        {{ \App\Models\NewsContent::count() }}--}}
                                        234
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
{{--                        <div class="text-center bg-gray-100 pb-0 mb-0"><a--}}
{{--                                href="{{ route('admin.posts.index', ['newsTypeId' => 5]) }}">More Info<i--}}
{{--                                    class="fas fa-arrow-circle-right text-gray-300 ml-2"></i> </a></div>--}}

                        <div class="text-center bg-gray-100 pb-0 mb-0"><a
                                href="#">More Info<i
                                    class="fas fa-arrow-circle-right text-gray-300 ml-2"></i> </a></div>
                    </div>
                </div>
{{--            @endcan--}}

            <!-- Pending Requests Card Example -->
{{--            @can('view_comments')--}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Comments</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
{{--                                        {{ \App\Models\Comment::count() }}--}}
                                        234
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>

                                </div>
                            </div>
                        </div>
                        <div class="text-center bg-gray-100 pb-0 mb-0"><a href="#">More Info<i
                                    class="fas fa-arrow-circle-right text-gray-300 ml-2"></i> </a></div>
                    </div>
                </div>
            </div>
{{--        @endcan--}}


    </div>
@endsection
