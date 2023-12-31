@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.components.errors')
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.massive_videos.index'),'text' => 'Add new video'])
        <form method="post" action="{{ route('admin.massive_videos.store') }}"  enctype="multipart/form-data">
            @csrf
            <div class="col-lg-9">


                @include('admin.components.form.input',['fieldId' => 'title','fieldTitle' => 'Title', 'placeholder' => 'Title','required' => true, 'autofocus' => true])
                @include('admin.components.form.input',['fieldId' => 'heading','fieldTitle' => 'Heading', 'required' => true])

                <div class="form-group row">
                    <label for="video" class="col-sm-2 col-form-label">Video<span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <img src="" onerror="this.onerror=null; this.src=this.src=this.style.display = 'none'" alt="video" id="video_preview">
                        <div class="pt-2 bg-gray-100 mt-2">
                            <input type="file" name="video" id="video" accept="video/*">
                        </div>
                        @include('admin.components.error',['error' => 'video'])
                    </div>
                </div>


                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>


            </div>
        </form>

    </div>
@endsection

