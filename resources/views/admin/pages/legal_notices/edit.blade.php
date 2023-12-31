@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.legal_notices.index'),'text' => 'Edit Legal Notice Post'])
        <form method="post" action="{{ route('admin.legal_notices.update',['id' => $legalNotice->legal_notice_id]) }}"  enctype="multipart/form-data">
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
                    <label class="col-sm-2 col-form-label" for="type">Place<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="type" id="type" class="form-control select2 @error('type') is-invalid @enderror" data-placeholder="Select Place">
                            <option value="">Select Place </option>
                            @foreach(\App\Models\NewsType::whereIn('type',[2,3])->select('news_type_id','news_type')->get() as $newsType)
                                <option value="{{$newsType->news_type_id}}" {{old('type',$legalNotice->type) ==  $newsType->news_type_id  ? 'selected' : ''}}>{{$newsType->news_type}}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error',['error' => 'type'])
                    </div>
                </div>



                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="title" value="{{old('title',$legalNotice->title)}}" placeholder="Title" required>
                        @include('admin.components.error',['error' => 'title'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slug" class="col-sm-2 col-form-label">Slug<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="slug" id="slug" value="{{old('slug',$legalNotice->slug)}}" placeholder="Slug" required>
                        @include('admin.components.error',['error' => 'slug'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tags" class="col-sm-2 col-form-label">Author<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="user_id" id="user_id" class="form-control select2 @error('user_id') is-invalid @enderror" data-placeholder="Select Author">
                            <option disabled>Select Author</option>
                            @foreach(getAuthors() as $author)
                                <option value="{{$author->user_id}}" {{(old('user_id',$legalNotice->user_id) == $author->user_id) ? 'selected' : ''}}>{{$author->display_name . ' ('.$author->username.')'}}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error',['error' => 'user_id'])
                    </div>
                </div>



                <div class="form-group row">
                    <label for="content" class="col-sm-2 col-form-label">Content<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="form-control content" id="content" name="content"  placeholder="Enter content" >{{old('content',$legalNotice->content)}}</textarea>
                        @include('admin.components.error',['error' => 'content'])
                    </div>
                </div>


                <div class="form-group row">
                    <label for="attachment" class="col-sm-2 col-form-label">Featured Image</label>
                    <div class="col-sm-10">

                        <textarea class="form-control attachement" id="attachment" name="attachment"  placeholder="Upload Featured Image" >{{old('attachment',view('components.partials.image',['url' => $legalNotice->getAttachmentUrl(),'class' => '','errorUrl' => ''])->render())}}</textarea>
                        @include('admin.components.error',['error' => 'attachment'])
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="is_published" value="1" {{$legalNotice->is_published == 1 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="is_published">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="save" value="0" {{$legalNotice->is_published == 0 ? 'checked' : ''}} required>
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
    <script src="{{asset('admin/js/select2.min.js')}}"></script>
    <script src="{{asset('js/slugify.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
            putSlugInInputFieldForRealEstate('#title','#slug','#type',$('#type').val());
        }); //ready
    </script>
@endsection

@section('css')
    <link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet" />
@endsection
