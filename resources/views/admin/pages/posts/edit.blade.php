@extends('admin.layouts.admin')
@section('content')
    @php
        $categories = \App\Models\SidebarCategory::where('open_status', 1)->select('category_id', 'category_name')->orderBy('category_name')->get()->toArray();
    @endphp
    <div class="container-fluid">
        @include('admin.components.errors')
        @include('admin.pages.partials.back_arrow', [
            'backRoute' => route('admin.posts.index', ['newsTypeId' => ((int) $post->type)]),
            'text' => 'Edit Post',
        ])
        <form method="post" action="{{ route('admin.posts.update', ['id' => $post->content_id]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="col-lg-9">

                <input type="hidden" name="newsTypeId" value="{{ (int) $post->type }}">
                @if (session('status'))
                    @include('admin.pages.partials.alert', [
                        'type' => 'success',
                        'message' => session('status'),
                    ])
                @endif
                @if (session('error'))
                    @include('admin.pages.partials.alert', [
                        'type' => 'danger',
                        'message' => session('error'),
                    ])
                @endif
                @php
                    $newsTypeId = $post->type;
                    if (in_array($post->type, [1, 2, 3, 4, 7])) {
                        $newsTypeId = 6;
                    }
                @endphp

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="type"><strong>Place</strong><span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="type[]" id="type" multiple="multiple"
                            class="form-control select2 @error('type') is-invalid @enderror"
                            data-placeholder="Select Place">
                            @foreach (\App\Models\NewsType::whereIn('type', [2, 3])->select('news_type_id', 'news_type')->get() as $newsType)
                                @php
                                    $selected = in_array($newsType->news_type_id, (array) old('type', (array) $newsTypeId)) ? 'selected' : '';
                                @endphp
                                <option value="{{ $newsType->news_type_id }}" {{ $selected }}>{{ $newsType->news_type }}
                                </option>
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
                            @foreach ($categories as $category)
                                <option value="{{ $category['category_id'] }}"
                                    {{ in_array($category['category_id'], array_merge(old('category_id') ? [old('category_id')] : [], [$post->category_id])) ? 'selected' : '' }}>
                                    {{ $category['category_name'] }}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error', ['error' => 'category_id'])
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="other_categorys"><strong>Sub Category</strong></label>
                    <div class="col-sm-10">
                        @php
                            $otherCategoriesArray = explode(',', $post->other_categorys);
                        @endphp
                        <select name="other_categorys[]" multiple="multiple" id="other_categorys"
                            class="form-control select2 @error('other_categorys') is-invalid @enderror">
                            <option value="">Sub Category</option>
                            @foreach (\App\Models\SidebarCategory::where('open_status', 1)->where('alias', '!=', 'picture_sque')->select('category_id', 'category_name')->orderBy('category_name')->get()->toArray() as $subCategory)
                                <option value="{{ $subCategory['category_id'] }}"
                                    {{ in_array($subCategory['category_id'], array_merge(old('other_categorys') ?? [], $otherCategoriesArray)) ? 'selected' : '' }}>
                                    {{ $subCategory['category_name'] }}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error', ['error' => 'other_categorys'])
                    </div>

                </div>
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="title"
                            value="{{ old('title', $post->title) }}" placeholder="Title" required>
                        @include('admin.components.error', ['error' => 'title'])
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Subtitle<span class="text-danger"></span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="subtitle" id="subtitle"
                            value="{{ old('subtitle', $post->subtitle) }}" placeholder="Subtitle">
                        @include('admin.components.error', ['error' => 'subtitle'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slug" class="col-sm-2 col-form-label">Slug<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="slug" id="slug-edit"
                            value="{{ old('slug', $post->slug) }}" placeholder="Slug" readonly required>
                        @include('admin.components.error', ['error' => 'slug'])
                        @php
                            $alias = $post->category_alias;
                            $type = $post->type;
//                            dd($post);
                            if($type == '5'){
                                $url = url('/'.'vi-'.$alias.'/'.$post->slug);
                            }else{
                                if($alias == ''){
                                 $categories_ids = collect($categories)->pluck('category_id')->toArray();
                                  $category = in_array($post->category_id, $categories_ids);
                                   $category_name = collect($categories)->where('category_id',$post->category_id)->first();
                                    if($category_name){
                                        $alias = lcfirst($category_name['category_name']);
                                    }
                                }
                                $url = url('/'.'caribbean-'.$alias.'/'.$post->slug);
                            }
                        @endphp
                        <a href="{{$url}}" target="_blank">
                            <p> {{$url}}</p>
                          </a>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="tags" class="col-sm-2 col-form-label">Tags </label>
                    <div class="col-sm-10">
                        @php
                            $tagSlugsArray = explode(',', $post->tags);
                        @endphp
                        <select name="tags[]" id="tags"
                            class="form-control select2 @error('tags') is-invalid @enderror" multiple="multiple"
                            data-placeholder="Select Tags">
                            <option disabled>Select Tags </option>
                            @foreach (\App\Models\Tag::select('slug', 'name', 'tag_id')->orderBy('slug')->get()->toArray() as $slug)
                                <option value="{{ $slug['tag_id'] }}"
                                    {{ in_array($slug['tag_id'], old('tags') ?? []) || in_array($slug['slug'], array_merge(old('tags') ?? [], $tagSlugsArray)) ? 'selected' : '' }}>
                                    {{ $slug['name'] }} </option>
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
                                    {{ old('user_id', $post->user_id) == $author->user_id ? 'selected' : '' }}>
                                    {{ $author->display_name . ' (' . $author->username . ')' }}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error', ['error' => 'user_id'])
                    </div>
                </div>



                <div class="form-group row">
                    <label for="content" class="col-sm-2 col-form-label">Content<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="form-control content" id="content" name="content" placeholder="Enter content">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="attachment" class="col-sm-2 col-form-label">Featured Image</label>
                    <div class="col-sm-10">

                        <textarea class="form-control attachement" id="attachment" name="attachment" placeholder="Upload Featured Image">{{ old('attachment', view('components.partials.image', ['url' => $post->getAttachmentUrl(), 'class' => '', 'errorUrl' => ''])->render()) }}</textarea>
                        @error('attachment')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="attachment_title" class="col-sm-2 col-form-label">Attachment Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="attachment_title" id="attachment_title"
                            value="{{ old('attachment_title', $post->attachment_title) }}"
                            placeholder="Attachment Title">
                        @include('admin.components.error', ['error' => 'attachment_title'])
                    </div>
                </div>
                <div class="form-group row">
                    <label for="attachment_credit" class="col-sm-2 col-form-label">Attachment Credit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="attachment_credit" id="attachment_credit"
                            value="{{ old('attachment_credit', $post->attachment_credit) }}"
                            placeholder="Attachment Credit">
                        @include('admin.components.error', ['error' => 'attachment_credit'])
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Make Breaking News</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_breaking_news" id="is_breaking_news"
                                value="1" {{$post->is_breaking_news == 1 ? 'checked' : '' }} required>
                            <label class="form-check-label" for="is_breaking_news">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_breaking_news"
                                id="not_breaking_news" value="0"
                                {{ $post->is_breaking_news== 0 ? 'checked' : '' }} required>
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
                                value="1" {{ $post->is_published == 1 ? 'checked' : '' }} required>
                            <label class="form-check-label" for="is_published">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="save"
                                value="0" {{ $post->is_published == 0 ? 'checked' : '' }} required>
                            <label class="form-check-label" for="save">Save</label>
                        </div>
                    </div>
                    @error('is_published')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row" style="min-height: 21rem;">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_scheduled" id="is_scheduled"
                                value="yes"
                                {{ old('is_scheduled') == 'yes' || $post->schedule_date ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_scheduled">Schedule</label>
                            <input type="hidden" name="is_schedule_val" id="is_schedule_val"
                                value="{{ $post->schedule_date }}">
                            <input type="hidden" name="schedule_date" id="schedule_date"
                                value="{{ $post->schedule_date }}">
                        </div>

                        <div class="form-check form-check-inline">
                            <label id="is_schedule_lbl">{{ $post->schedule_date }}</label>
                        </div>
                        <div class="form-check form-check-inline d-none" id="toggle_calendar">
                            <div class="form-check-input" id="schedule_calendar"></div>
                        </div>

                    </div>
                    @error('is_published')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- <div class="form-group row d-flex" id="placementAndNumber">
                    <label class="col-sm-2 col-form-label">Placement:</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="placement" id="left"
                                value="left_post_order"
                                {{ old('placement', $post->schedule_place_order) === 'left_post_order' ? 'checked' : '' }}>
                            <label class="form-check-label" for="left">Left</label>
                        </div>
                        <!-- Other placement options here... -->
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="placement" id="center"
                                value="center_featured_post_order"
                                {{ old('placement', $post->schedule_place_order) === 'center_featured_post_order' ? 'checked' : '' }}>
                            <label class="form-check-label" for="center">Center</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="placement" id="top"
                                value="top_post_order"
                                {{ old('placement', $post->schedule_place_order) === 'top_post_order' ? 'checked' : '' }}>
                            <label class="form-check-label" for="top">Top</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="placement" id="politics"
                                value="politics_post_order"
                                {{ old('placement', $post->schedule_place_order) === 'politics_post_order' ? 'checked' : '' }}>
                            <label class="form-check-label" for="politics">Politics</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row d-flex" id="numberField">
                    <label class="col-sm-2 col-form-label" for="number">Number:</label>
                    <div class="col-sm-4">
                        <input type="number" id="number" name="number" min="0" class="form-control"
                            value="{{ old(
                                'number',
                                $post->schedule_place_order === 'left_post_order'
                                    ? $post->left_post_order
                                    : ($post->schedule_place_order === 'center_featured_post_order'
                                        ? $post->center_featured_post_order
                                        : ($post->schedule_place_order === 'top_post_order'
                                            ? $post->top_post_order
                                            : ($post->schedule_place_order === 'politics_post_order'
                                                ? $post->politics_post_order
                                                : ''))),
                            ) }}">
                    </div>
                </div>
 --}}

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
            putSlugInInputFieldForPost('#title', '#slug', {{ $newsTypeId }});
            $("#tags").select2({
                tags: true,
                tokenSeparators: [',']
            });
            postDateTimePicker(new Date(
                '{{ $post->schedule_date }}')); //code in post_date_time_picker_js.blade.php
            if ("{{ $post->schedule_date }}") {
                $('#toggle_calendar').removeClass('d-none');
            }
            window.onbeforeunload = function() {
            return "Are you sure you want to leave this page?";
        };

        // Optionally, you can remove the confirmation dialog when a form is submitted
        $('form').submit(function() {
            window.onbeforeunload = null;
        });
        }); //ready

        function formIsEmpty() {



       }
    </script>
{{--    <script>--}}
{{--        const scheduleCheckbox = document.getElementById('is_scheduled');--}}
{{--        const placementAndNumberDiv = document.getElementById('placementAndNumber');--}}
{{--        const numberField = document.getElementById('numberField');--}}

{{--        // Function to toggle visibility of placement and number fields--}}
{{--        function togglePlacementAndNumber() {--}}
{{--            if (scheduleCheckbox.checked) {--}}
{{--                placementAndNumberDiv.style.display = 'block';--}}
{{--                numberField.style.display = 'block';--}}
{{--            } else {--}}
{{--                placementAndNumberDiv.style.display = 'none';--}}
{{--                numberField.style.display = 'none';--}}
{{--            }--}}
{{--        }--}}

{{--        // Initially call the function to set the initial state--}}
{{--        togglePlacementAndNumber();--}}

{{--        // Add an event listener to the "Schedule" checkbox--}}
{{--        scheduleCheckbox.addEventListener('change', togglePlacementAndNumber);--}}
{{--    </script>--}}
@endsection

@section('css')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/css/jquery.datetimepicker.min.css') }}" rel="stylesheet" />
@endsection
