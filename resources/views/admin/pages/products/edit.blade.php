@extends('admin.layouts.admin')
@section('css')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow', [
            'backRoute' => route('admin.products.index'),
            'text' => 'Edit Product',
        ])
        <form method="post" action="{{ route('admin.products.update', ['id' => $product->id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-9">
                {{--                <input type="hidden" name="newsTypeId" value="{{ $newsTypeId }}">--}}
                @include('admin.components.partials.session_statuses')

                <div class="form-group row" id ="form">
                    <label class="col-sm-2 col-form-label" for="type"><strong>Place</strong><span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="category_id" id="parent_category_id"
                                class="form-control select2 @error('parent_category_id') is-invalid @enderror"
                                data-placeholder="Select Category">
                            <option value="">Select Parent Category </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"{{ (old('parent_category_id') == $category->id || $product->category_id == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @include('admin.components.error', ['error' => 'parent_category_id'])
                    </div>
                </div>

                {{--                <div class="form-group row">--}}
                {{--                    <label class="col-sm-2 col-form-label" for="other_categorys"><strong>Sub Category</strong></label>--}}
                {{--                    <div class="col-sm-10">--}}
                {{--                        <select name="other_categorys[]" multiple="multiple" id="other_categorys"--}}
                {{--                                class="form-control select2 @error('other_categorys') is-invalid @enderror">--}}
                {{--                            <option value="">Sub Category</option>--}}
                {{--                            @foreach (\App\Models\SidebarCategory::where('open_status', 1)->where('alias', '!=', 'picture_sque')->select('category_id', 'category_name')->orderBy('category_name')->get()->toArray() as $subCategory)--}}
                {{--                                <option value="{{ $subCategory['category_id'] }}"--}}
                {{--                                    {{ old('other_categorys') && in_array($subCategory['category_id'], old('other_categorys')) ? 'selected' : '' }}>--}}
                {{--                                    {{ $subCategory['category_name'] }}</option>--}}
                {{--                            @endforeach--}}
                {{--                        </select>--}}
                {{--                        @include('admin.components.error', ['error' => 'other_categorys'])--}}
                {{--                    </div>--}}

                {{--                </div>--}}
{{--                @dd($product);--}}
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="name"
                               value="{{ old('name', $product->name) }}" placeholder="Name" required>
                        @include('admin.components.error', ['error' => 'name'])
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="form-control content" id="description" name="description" placeholder="Enter content">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="attachment" class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-10">
                        <img src="{{imagePath($product->image)}}" width="200px" height="200px">
                        <input type="file" name="image" class="form-control" accept=".png, .jpg, .jpeg">
                        @error('attachment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Price<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="price" id="price"
                               value="{{ old('name', $product->price) }}" placeholder="Price" required>
                        @include('admin.components.error', ['error' => 'price'])
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                                   value="yes" {{ old('is_featured') == 'yes' || $product->is_featured == 1 ? 'checked' : '' }} >
                            <label class="form-check-label" for="is_scheduled">Featured</label>

                        </div>
                    </div>
                    @error('is_featured')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="in_stock" id="in_stock"
                                   value="yes" {{ old('in_stock') == 'yes' || $product->in_stock == 1 ? 'checked' : '' }} >
                            <label class="form-check-label" for="in_stock">Is Available</label>

                        </div>
                    </div>
                    @error('in_stock')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
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


