@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Facebook Ads Settings</h1>
        <form class="mt-3" method="post" action="{{ route('admin.settings.update') }}"  enctype="multipart/form-data">
            @csrf
            <div class="col-lg">
                @if (session('status'))
                    @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
                @endif
                @if (session('error'))
                    @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
                @endif
                <input type="hidden" name="tab" value="general">

                {{--1--}}
                <div class="form-group row text-center">
                    <label class="col-sm-3 col-form-label">Facebook Like Popup Enable</label>
                    <div class="col-sm-9">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="facebook_like_model" id="yesRadio" value="1" {{$settings['facebook_like_model'] == 1 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="yesRadio">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="facebook_like_model" id="noRadio" value="0" {{$settings['facebook_like_model'] == 0 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="noRadio">No</label>
                        </div>
                    </div>
                    @include('admin.components.error',['error' => 'facebook_like_model'])
                </div>
                {{--2--}}
                <div class="form-group row text-center">
                    <label class="col-sm-3 col-form-label">First Ads Popup Enable</label>
                    <div class="col-sm-9">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="first_ads_model" id="yesRadio1" value="1" {{$settings['first_ads_model'] == 1 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="yesRadio">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="first_ads_model" id="noRadio1" value="0" {{$settings['first_ads_model'] == 0 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="noRadio">No</label>
                        </div>
                    </div>
                    @include('admin.components.error',['error' => 'first_ads_model'])
                </div>
                {{--3--}}
                <div class="form-group row text-center">
                    <label class="col-sm-3 col-form-label">First Ads Popup Enable</label>
                    <div class="col-sm-9">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="news_letter_model" id="yesRadio2" value="1" {{$settings['news_letter_model'] == 1 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="yesRadio">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="news_letter_model" id="noRadio2" value="0" {{$settings['news_letter_model'] == 0 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="noRadio">No</label>
                        </div>
                    </div>
                    @include('admin.components.error',['error' => 'news_letter_model'])
                </div>

                <div class="mb-5 mt-5">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>
            </div>

        </form>
    </div>
@endsection
