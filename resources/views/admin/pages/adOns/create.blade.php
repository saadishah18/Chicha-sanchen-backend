@extends('admin.layouts.admin')
@section('content')
    <style>
        <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet" />
    </style>
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow', [
            'backRoute' => route('admin.products.index'),
            'text' => 'Create Product',
        ])
        <form method="post" action="{{ route('admin.addons.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-9">
                @include('admin.components.partials.session_statuses')
                @include('admin.components.form.input', [
                    'fieldId' => 'name',
                    'fieldTitle' => 'Name',
                    'placeholder' => 'Please enter ad on name',
                    'required' => true,
                    'autofocus' => true,
                    'autocomplete' => null,
                ])
                @include('admin.components.form.input', [
                    'fieldId' => 'price',
                    'fieldTitle' => 'Price',
                    'placeholder' => 'Price',
                    'required' => true,
                    'autofocus' => false,
                    'autocomplete' => null,
                    '$inputType' => 'number',
                ])
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary bg-theme">Create</button>
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
    <script>
        // const scheduleCheckbox = document.getElementById('is_scheduled');
        // const placementAndNumberDiv = document.getElementById('placementAndNumber');
        // const numberField = document.getElementById('numberField');

        // // Function to toggle visibility of placement and number fields
        // function togglePlacementAndNumber() {
        //     if (scheduleCheckbox.checked) {
        //         placementAndNumberDiv.style.display = 'block';
        //         numberField.style.display = 'block';
        //     } else {
        //         placementAndNumberDiv.style.display = 'none';
        //         numberField.style.display = 'none';
        //     }
        // }

        // // Initially call the function to set the initial state
        // togglePlacementAndNumber();

        // // Add an event listener to the "Schedule" checkbox
        // scheduleCheckbox.addEventListener('change', togglePlacementAndNumber);
    </script>
@endsection


