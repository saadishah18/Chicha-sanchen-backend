@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Featured Marketing Analytics</h1>
        @include('admin.pages.post_views.featured_marketing.datatable',['id' => 'datatable1'])
    </div>
@endsection



