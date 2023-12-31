@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.pages.index'),'text' => 'Add New Page'])
        @include('admin.components.errors')
        <form method="post" action="{{ route('admin.pages.store') }}"  enctype="multipart/form-data">
            @csrf
            <div class="col-lg-9">

                @if (session('status') === 'created')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Created!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif



                @include('admin.components.form.input',['fieldId' => 'title','fieldTitle' => 'Title', 'placeholder' => 'Title','required' => true, 'autofocus' => true,'autocomplete' => null])
                @include('admin.components.form.input',['fieldId' => 'slug','fieldTitle' => 'Slug', 'placeholder' => 'Slug','required' => true, 'autofocus' => false,'autocomplete' => null])

                <div class="form-group row">
                    <label for="content" class="col-sm-2 col-form-label">Content<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="form-control content" id="content" name="content"  placeholder="Enter content" >{{old('content','some content')}}</textarea>
                        @error('content')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="is_published" value="1" {{old('is_published') == '1' ? 'checked' : ''}} required>
                            <label class="form-check-label" for="is_published">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="save" value="0" {{old('is_published') == '0' ? 'checked' : 'checked'}} required>
                            <label class="form-check-label" for="save">Save</label>
                        </div>
                    </div>
                    @error('is_published')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
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
