@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">

        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.users.index'),'text' => 'Settings'])
        <form method="post" action="{{ route('admin.membership_plans.update') }}"  enctype="multipart/form-data">
            @csrf
            <div class="col-lg">
                @if (session('status'))
                    @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
                @endif
                @if (session('error'))
                    @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
                @endif

                {{--1--}}
                <div class="form-group row">
                    <div class="col-sm-6">
                        <div class="row">
                            <label for="site_realestate_post_price" class="col-sm-4 col-form-label">Real Estate Per Post Price<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="site_realestate_post_price" id="site_realestate_post_price" value="{{$settings['site_realestate_post_price']}}" placeholder="Enter Real Estate Post Price" required>
                                @include('admin.components.error',['error' => 'site_realestate_post_price'])
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <label for="site_realestate_post_day" class="col-sm-4 col-form-label">Post for days<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="site_realestate_post_day" id="slug" value="{{old('site_realestate_post_day',$settings['site_realestate_post_day'])}}" placeholder="Enter Real Estate Post Day" required>
                                @include('admin.components.error',['error' => 'site_realestate_post_day'])
                            </div>
                        </div>
                    </div>
                </div>
                {{--2--}}
                <div class="form-group row">
                    <div class="col-sm-6">
                        <div class="row">
                            <label for="site_obituary_post_price" class="col-sm-4 col-form-label">Obituary Per Post Price<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="site_obituary_post_price" id="site_obituary_post_price" value="{{old('site_obituary_post_price',$settings['site_obituary_post_price'])}}" placeholder="Enter Obituary Post Price" required>
                                @include('admin.components.error',['error' => 'site_obituary_post_price'])
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <label for="site_obituary_post_day" class="col-sm-4 col-form-label">Post for days<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="site_obituary_post_day" id="slug" value="{{old('site_obituary_post_day',$settings['site_obituary_post_day'])}}" placeholder="Enter Obituary Post Price" required>
                                @include('admin.components.error',['error' => 'site_obituary_post_day'])
                            </div>
                        </div>
                    </div>
                </div>
                {{--3--}}
                <div class="form-group row">
                    <div class="col-sm-6">
                        <div class="row">
                            <label for="site_legal_notice_post_price" class="col-sm-4 col-form-label">Legal Notice Per Post Price<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="site_legal_notice_post_price" id="site_legal_notice_post_price" value="{{old('site_legal_notice_post_price',$settings['site_legal_notice_post_price'])}}" placeholder="Enter Legal Notice Post Price" required>
                                @include('admin.components.error',['error' => 'site_legal_notice_post_price'])
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <label for="site_legal_notice_post_day" class="col-sm-4 col-form-label">Post for days<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="site_legal_notice_post_day" id="slug" value="{{old('site_legal_notice_post_day',$settings['site_legal_notice_post_day'])}}" placeholder="Enter Legal Notice Post Day" required>
                                @include('admin.components.error',['error' => 'site_legal_notice_post_day'])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>
            </div>

        </form>
    </div>
@endsection
@section('js')
    <script src="{{asset('js/slugify.js')}}"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            putSlugInInputField('#display_name','#slug');
        }); //ready
    </script>


@endsection
