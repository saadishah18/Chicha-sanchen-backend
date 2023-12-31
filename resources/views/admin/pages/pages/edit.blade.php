@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.pages.index'),'text' => 'Edit Page'])
        @include('admin.components.errors')
        <form method="post" action="{{ route('admin.pages.update',['id' => $page->page_id]) }}"  enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="col-lg-9">


                @if (session('status'))
                    @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
                @endif
                @if (session('error'))
                    @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
                @endif


                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="title" value="{{old('title',$page->title)}}" placeholder="Title" required>
                        @include('admin.components.error',['error' => 'title'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slug" class="col-sm-2 col-form-label">Slug<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="slug" id="slug" value="{{old('slug',$page->slug)}}" placeholder="Slug" required>
                        @include('admin.components.error',['error' => 'slug'])
                    </div>
                </div>


                <div class="form-group row">
                    <label for="content" class="col-sm-2 col-form-label">Content<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="form-control content" id="content" name="content"  placeholder="Enter content" >{{old('content',$page->content)}}</textarea>
                        @include('admin.components.error',['error' => 'content'])
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="is_published" value="1" {{$page->is_published == 1 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="is_published">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="save" value="0" {{$page->is_published == 0 ? 'checked' : ''}} required>
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
    @include('admin.pages.partials.post_tiny_mce')
    <script src="{{asset('js/slugify.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            putSlugInInputField('#title','#slug');
        }); //ready
    </script>
@endsection
