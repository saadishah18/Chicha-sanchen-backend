@extends('admin.layouts.admin')
@section('css')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow', [
            'backRoute' => route('admin.products.index'),
            'text' => 'Assign Add on to '. $product->name,
        ])
        <form method="post" action="{{ route('admin.products.update', ['id' => $product->id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-9">
                {{--                <input type="hidden" name="newsTypeId" value="{{ $newsTypeId }}">--}}
                @include('admin.components.partials.session_statuses')
                @foreach($add_ons as $key => $addon)
                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="add_on_id[]" id="add_on_id"
                                   value="{{$addon->id}}" {{--{{ old('name') || $addon->is_featured == 1 ? 'checked' : '' }}--}} >
                            <label class="form-check-label" for="is_scheduled">{!! $addon->name !!}</label>
                        </div>
                        <ul>
                        @foreach($addon->values as $i => $value)
                            <li>
                                <p><b>name:</b> {!! $value->value !!}  &nbsp; <span><b>Price</b> {!! $value->price ?? 0 !!}</span></p>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                    @error('is_featured')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                @endforeach
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary bg-theme">Update</button>
                </div>
            </div>
        </form>

    </div>
@endsection
@section('js')
    @include('admin.pages.partials.post_tiny_mce')
    {{--    @include('admin.pages.partials.post_date_time_picker_js')--}}
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    {{--    <script src="{{ asset('js/slugify_4.js') }}"></script>--}}
    {{--    <script src="{{ asset('admin/vendor/jquery/jquery.datetimepicker.js') }}"></script>--}}

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


