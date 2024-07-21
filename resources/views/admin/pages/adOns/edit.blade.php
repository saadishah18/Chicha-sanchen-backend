@extends('admin.layouts.admin')
@section('content')
    <style>
        <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet" />
    </style>
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow', [
            'backRoute' => route('admin.addons.index'),
            'text' => 'Edit add on',
        ])
        <form method="post" action="{{ route('admin.addons.update', ['id' => $adOn->id]) }}" enctype="multipart/form-data">
            @include('admin.components.partials.session_statuses')
            @csrf
            <div class="row">
                @foreach($adOn->values as $key => $value)
{{--                    @dd($value);--}}
                <div class="col-lg-6">
                    <div class="col-lg-2">
                        <label for="title" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="value[{{$value->id}}]" id="value-{{$value->id}}"
                               value="{{ old('value', $value->value) }}" placeholder="Name" required>
                        @include('admin.components.error', ['error' => 'value'])
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="col-lg-2">
                        <label for="title" class="col-sm-2 col-form-label">Price<span class="text-danger">*</span></label>
                    </div>

                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="price[{{$value->id}}]" id="value-{{$value->id}}"
                               value="{{ old('price', $value->price ?? 0) }}" placeholder="Price" required>
                        @include('admin.components.error', ['error' => 'price'])
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary bg-theme">Update</button>
            </div>
        </form>

    </div>
@endsection
@section('js')
    @include('admin.pages.partials.post_tiny_mce')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();

            window.onbeforeunload = function() {
                return "Are you sure you want to leave this page?";
            };

            // Optionally, you can remove the confirmation dialog when a form is submitted
            $('form').submit(function() {
                window.onbeforeunload = null;
            });

        });

        // Function to check if the form is empty

    </script>
@endsection


