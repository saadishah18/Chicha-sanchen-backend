@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.components.errors')
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.manage_plaza.index'),'text' => 'Update Plaza Extra East'])
        <div class="col-lg">

            <form method="post" action="{{ route('admin.manage_plaza.update',['id' => $poster->id]) }}"  enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                @if (session('status'))
                    @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
                @endif
                @if (session('error'))
                    @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
                @endif
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="p_type">Section<span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="p_type" id="p_type" class="form-control select2 @error('p_type') is-invalid @enderror" data-placeholder="Select Place">
                            <option value="">Select Place </option>
                            @foreach(\App\Models\NewsType::whereIn('type',[2,3])->select('news_type_id','news_type')->get() as $newsType)
                                <option value="{{$newsType->news_type_id}}" {{old('p_type',$poster->p_type) ==  $newsType->news_type_id  ? 'selected' : ''}}>{{$newsType->news_type}}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error',['error' => 'p_type'])
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <label for="title" class="col-sm-3 form-label">Plaza Extra East Title</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title',$poster->title)}}" placeholder="Enter gallery name"  autofocus autocomplete="name">

                        @include('admin.components.error',['error' => 'title'])
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Plaza extra east Image</label>
                    <div class="col-sm-9">
                        <img class="img-thumbnail" src="{{$poster->getPosterUrl()}}" onerror="this.onerror=null; this.src=this.src=this.style.display = 'none'" alt="plaza_extra_east_img" id="plaza_extra_east_img_preview">
                        <div class="pt-2 bg-gray-100 mt-2">
                            <input type="file" name="plaza_extra_east_img" id="plaza_extra_east_img" accept="image/*">
                        </div>
                        @include('admin.components.error',['error' => 'plaza_extra_east_img'])
                    </div>
                </div>

                <div class="m-3 text-center">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>
            </form>
        </div>

    </div>
@endsection
@section('js')
    <script>
        const puebloImageInput = document.getElementById('plaza_extra_east_img');
        const puebloImagePreview = document.getElementById('plaza_extra_east_img_preview');

        puebloImageInput.addEventListener('change', () => {
            $('#plaza_extra_east_img_preview').css('display','block');
            const file = puebloImageInput.files[0];
            const reader = new FileReader();
            reader.onload = () => {
                puebloImagePreview.src = reader.result;
            };
            if (file) {
                reader.readAsDataURL(file);
            }
        });

    </script>
@endsection
