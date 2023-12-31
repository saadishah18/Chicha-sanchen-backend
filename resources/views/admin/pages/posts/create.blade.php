@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow', [
            'backRoute' => route('admin.posts.index', ['newsTypeId' => $newsTypeId ?? 5]),
            'text' => 'Create Post',
        ])
        <form method="post" action="{{ route('admin.posts.store', ['newsTypeId' => $newsTypeId ?? 5]) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="col-lg-9">

                <input type="hidden" name="newsTypeId" value="{{ $newsTypeId }}">
                @include('admin.components.partials.session_statuses')
                @php
                    if ($newsTypeId == 6) {
                        $newsTypeId = 1;
                    }
                @endphp

                <div class="form-group row" id ="form">
                    <label class="col-sm-2 col-form-label" for="type"><strong>Place</strong><span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="type[]" id="type" multiple="multiple"
                            class="form-control select2 @error('type') is-invalid @enderror"
                            data-placeholder="Select Place">
                            <option value="">Select Place </option>
                            @foreach (\App\Models\NewsType::whereIn('type', [2,3])->select('news_type_id', 'news_type')->get() as $newsType)
                                <option value="{{ $newsType->news_type_id }}"
                                    {{ (old('type') && in_array($newsType->news_type_id, old('type'))) || $newsTypeId == $newsType->news_type_id ? 'selected' : '' }}>
                                    {{ $newsType->news_type }}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error', ['error' => 'place'])
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="category_id"><strong>Main Category</strong><span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="category_id" id="category_id"
                            class="form-control select2 @error('category_id') is-invalid @enderror">
                            <option value="">Select Main Category</option>
                            @foreach (\App\Models\SidebarCategory::where('open_status', 1)->select('category_id', 'category_name')->orderBy('category_name')->get()->toArray() as $category)
                                <option value="{{ $category['category_id'] }}"
                                    {{ old('category_id') && old('category_id') == $category['category_id'] ? 'selected' : '' }}>
                                    {{ $category['category_name'] }}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error', ['error' => 'category_id'])
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="other_categorys"><strong>Sub Category</strong></label>
                    <div class="col-sm-10">
                        <select name="other_categorys[]" multiple="multiple" id="other_categorys"
                            class="form-control select2 @error('other_categorys') is-invalid @enderror">
                            <option value="">Sub Category</option>
                            @foreach (\App\Models\SidebarCategory::where('open_status', 1)->where('alias', '!=', 'picture_sque')->select('category_id', 'category_name')->orderBy('category_name')->get()->toArray() as $subCategory)
                                <option value="{{ $subCategory['category_id'] }}"
                                    {{ old('other_categorys') && in_array($subCategory['category_id'], old('other_categorys')) ? 'selected' : '' }}>
                                    {{ $subCategory['category_name'] }}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error', ['error' => 'other_categorys'])
                    </div>

                </div>

                @include('admin.components.form.input', [
                    'fieldId' => 'title',
                    'fieldTitle' => 'Title',
                    'placeholder' => 'Title',
                    'required' => true,
                    'autofocus' => true,
                    'autocomplete' => null,
                ])
                @include('admin.components.form.input', [
                    'fieldId' => 'subtitle',
                    'fieldTitle' => 'Subtitle',
                    'placeholder' => 'Subtitle',
                    'required' => false,
                    'autofocus' => false,
                    'autocomplete' => null,
                ])
                @include('admin.components.form.input', [
                    'fieldId' => 'slug',
                    'fieldTitle' => 'Slug',
                    'placeholder' => 'Slug',
                    'required' => true,
                    'autofocus' => false,
                    'autocomplete' => null,
                ])
                <div class="form-group row">
                    <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                    <div class="col-sm-10">
                        <select name="tags[]" id="tags"
                            class="form-control select2 @error('tags') is-invalid @enderror" multiple="multiple"
                            data-placeholder="Select Tags">
                            <option disabled>Select Tags</option>
                            @foreach (\App\Models\Tag::select('slug', 'name', 'tag_id')->orderBy('slug')->get()->toArray() as $slug)
                                <option value="{{ $slug['tag_id'] }}"
                                    {{ old('tags') && in_array($slug['tag_id'], old('tags')) ? 'selected' : '' }}>
                                    {{ $slug['name'] }}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error', ['error' => 'tags'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tags" class="col-sm-2 col-form-label">Author<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="user_id" id="user_id"
                            class="form-control select2 @error('user_id') is-invalid @enderror"
                            data-placeholder="Select Author">
                            <option disabled>Select Author</option>
                            @foreach (getAuthors() as $author)
                                <option value="{{ $author->user_id }}"
                                    {{ old('user_id') && old('user_id') == $author->user_id ? 'selected' : '' }}>
                                    {{ $author->display_name . ' (' . $author->username . ')' }}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error', ['error' => 'user_id'])
                    </div>
                </div>



                <div class="form-group row">
                    <label for="content" class="col-sm-2 col-form-label">Content<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="form-control content" id="content" name="content" placeholder="Enter content">{{ old(htmlentities('content'), 'some content') }}</textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="attachment" class="col-sm-2 col-form-label">Featured Image</label>
                    <div class="col-sm-10">
                        <textarea class="form-control attachement" id="attachment" name="attachment" placeholder="Upload Featured Image">{{ old('attachment') }}</textarea>
                        @error('attachment')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @include('admin.components.form.input', [
                    'fieldId' => 'attachment_title',
                    'fieldTitle' => 'Attachment Title',
                    'placeholder' => 'Attachment Title',
                    'required' => false,
                    'autofocus' => false,
                    'autocomplete' => null,
                ])
                @include('admin.components.form.input', [
                    'fieldId' => 'attachment_credit',
                    'fieldTitle' => 'Attachment Credit',
                    'placeholder' => 'Attachment Credit',
                    'required' => false,
                    'autofocus' => false,
                    'autocomplete' => null,
                ])

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Make Breaking News</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_breaking_news" id="is_breaking_news"
                                value="1" {{ old('is_breaking_news') == 'yes' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="is_breaking_news">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_breaking_news" id="not_breaking_news"
                                value="0" {{ old('is_breaking_news') == 'no' ? 'checked' : 'checked' }} required>
                            <label class="form-check-label" for="not_breaking_news">No</label>
                        </div>
                    </div>
                    @error('is_breaking_news')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="is_published"
                                value="1" {{ old('is_published') == '1' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="is_published">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="save"
                                value="0" {{ old('is_published') == '0' ? 'checked' : 'checked' }} required>
                            <label class="form-check-label" for="save">Save</label>
                        </div>
                    </div>
                    @error('is_published')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_scheduled" id="is_scheduled"
                                value="yes" {{ old('is_scheduled') == 'yes' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_scheduled">Schedule</label>

                            <input type="hidden" name="is_schedule_val" id="is_schedule_val" value="">
                            <input type="hidden" name="schedule_date" id="schedule_date">
                        </div>

                        <div class="form-check form-check-inline">
                            <label id="is_schedule_lbl"></label>
                        </div>
                        <div class="form-check form-check-inline d-none" id="toggle_calendar">
                            <div class="form-check-input" id="schedule_calendar"></div>
                        </div>

                    </div>
                    @error('schedule_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row d-flex" id="placementAndNumber">
                    <label class="col-sm-2 col-form-label">Placement:</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="placement" id="left"
                                value="left_post_order" {{ old('placement') == 'left_post_order' ? 'checked' : '' }} >
                            <label class="form-check-label" for="left">Left</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="placement" id="top"
                                value="center_featured_post_order" {{ old('placement') == 'center_featured_post_order' ? 'checked' : '' }} >
                            <label class="form-check-label" for="top">Top</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="placement" id="center"
                                value="top_post_order" {{ old('placement') == 'top_post_order' ? 'checked' : '' }} >
                            <label class="form-check-label" for="center">Center</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="placement" id="politics"
                                value="politics_post_order" {{ old('placement') == 'politics_post_order' ? 'checked' : '' }} >
                            <label class="form-check-label" for="politics">Politics</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row d-flex" id="numberField">
                    <label class="col-sm-2 col-form-label" for="number">Number:</label>
                    <div class="col-sm-4">
                        <input type="number" id="number" name="number" min="0" class="form-control">
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>
            </div>
        </form>

    </div>
@endsection
@section('js')
    @include('admin.pages.partials.post_tiny_mce')
    @include('admin.pages.partials.post_date_time_picker_js')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/slugify_4.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery/jquery.datetimepicker.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
            putSlugInInputFieldForPost('#title', '#slug',{{ $newsTypeId }});
            $("#tags").select2({
                tags: true,
                tokenSeparators: [',']
            });
            postDateTimePicker(); //code in post_date_time_picker_js.blade.php
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

@section('css')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/css/jquery.datetimepicker.min.css') }}" rel="stylesheet" />
@endsection
