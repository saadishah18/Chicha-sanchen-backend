@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.components.errors')
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.vi_videos.index'),'text' => 'Edit Video'])
        <form method="post" action="{{ route('admin.vi_videos.update',['id' => $video->content_id]) }}"  enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="col-lg-9">

                @if (session('error'))
                    @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
                @endif
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="type">Place<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="type" id="type" class="form-control select2 @error('type') is-invalid @enderror" data-placeholder="Select Place" required>
                            <option value="">Select Place </option>
                            @foreach(\App\Models\NewsType::whereIn('type',[2,3])->select('news_type_id','news_type')->get() as $newsType)
                                <option value="{{$newsType->news_type_id}}" {{  $newsType->news_type_id == $video->type  ? 'selected' : ''}}>{{$newsType->news_type}}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error',['error' => 'type'])
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="title" value="{{$video->title}}" placeholder="Title" required>
                        @include('admin.components.error',['error' => 'title'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slug" class="col-sm-2 col-form-label">Slug<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="slug" id="slug" value="{{$video->slug}}" placeholder="Slug" required>
                        @include('admin.components.error',['error' => 'slug'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="content" class="col-sm-2 col-form-label">Content<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="form-control content" id="content" name="content"  placeholder="" >{{$video->content}}</textarea>
                        @include('admin.components.error',['error' => 'content'])
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Live Stream</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="mark_as_live" id="mark_as_live" value="1" {{$video->mark_as_live == '1' ? 'checked' : ''}} required>
                            <label class="form-check-label" for="mark_as_live">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="mark_as_live" id="not_live" value="0" {{$video->mark_as_live == '0' ? 'checked' : ''}} required>
                            <label class="form-check-label" for="not_live">No</label>
                        </div>
                    </div>
                    @include('admin.components.error',['error' => 'mark_as_live'])
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">

                            <input class="form-check-input" type="radio" name="is_published" id="is_published" value="1" {{$video->is_published == '1' ? 'checked' : ''}} required>
                            <label class="form-check-label" for="is_published">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="save" value="0" {{$video->is_published == '0' ? 'checked' : ''}} required>
                            <label class="form-check-label" for="save">Save</label>
                        </div>
                    </div>
                    @include('admin.components.error',['error' => 'is_published'])
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>


            </div>
        </form>

    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.0/tinymce.min.js" integrity="sha512-XaygRY58e7fVVWydN6jQsLpLMyf7qb4cKZjIi93WbKjT6+kG/x4H5Q73Tff69trL9K0YDPIswzWe6hkcyuOHlw==" crossorigin="anonymous"></script>
    <script src="{{asset('js/slugify.js')}}"></script>
    <script src="{{asset('admin/js/select2.min.js')}}"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            $('.select2').select2();
            putSlugInInputFieldForRealEstate('#title','#slug','#type',$('#type').val());
            tinymce.init({
                selector: "textarea.content",
                relative_urls: false,
                menubar: false,
                theme: "silver",
                convert_urls: false,
                height: 400,
                plugins: [
                    "media"
                ],
                toolbar1: "",
                toolbar2: "media",

            });

        }); //ready
    </script>
@endsection

@section('css')
    <link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet" />
@endsection

