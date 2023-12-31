@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.components.errors')
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.galleries.index'),'text' => 'Update Gallery'])
        <div class="col-lg">
            <div class="form-group row mt-3">
                <div class="col-sm-3 form-label">Gallery Images</div>
                <div class="col-sm-9">
                    <form method="post" action="{{url('/admin/images/upload')}}" enctype="multipart/form-data"
                          class="dropzone" id="dropzone">
                        @csrf
                    </form>
                </div>
            </div>
            <form method="post" action="{{ route('admin.galleries.update',['id' => $gallery->gallery_id]) }}"  enctype="multipart/form-data" id="gallery_form">
                @csrf
                @method('PATCH')
                @if (session('status'))
                    @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
                @endif
                @if (session('error'))
                    @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
                @endif
                <input type="hidden" name="images" value="" id="images">
                <div class="form-group row mt-3">
                    <label for="title" class="col-sm-3 form-label">Gallery Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title',$gallery->title)}}" placeholder="Enter gallery name"  autofocus autocomplete="name">

                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="m-3 text-center">
                    <button type="submit" id="submit_gallery_form" class="btn btn-primary bg-theme">Save changes</button>
                </div>
            </form>
        </div>

    </div>
@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript">

        var imagesToUpload = [];
        function loadExistingFiles(dz){

            let galleryImages = {!! json_encode($gallery->images) !!};
            if (galleryImages.length) {
                // Loop through the files and display them
                for (var i = 0; i < galleryImages.length; i++) {
                    var file = galleryImages[i];
                    var mockFile = { filename: file.filename, size: file.size };

                    dz.options.addedfile.call(dz, mockFile);
                    dz.options.thumbnail.call(dz, mockFile, file.path);
                    dz.files.push(mockFile);
                    imagesToUpload.push(file.filename);
                }
            }
        }
        Dropzone.options.dropzone =
            {
                url:'/admin/images/upload',
                maxFilesize: 12,
                renameFile: function(file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time+file.name.replaceAll(' ','_');
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                dictDefaultMessage :'<span class="bigger-100 bolder"><i class="ace-icon fa fa-caret-right red"></i> Drop Images</span> to upload \
				<span class="smaller-80 grey">(or click)</span> <br /> \
				<i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>',
                timeout: 50000,
                removedfile: function(file)
                {
                    var name = file.filename || file.upload.filename;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}"
                        },
                        type: 'POST',
                        url: '{{ url("/admin/images/delete/".$gallery->gallery_id) }}',
                        data: {filename: name},
                        success: function (data){
                            let index = imagesToUpload.indexOf(name);
                            if (index !== -1) {
                                imagesToUpload.splice(index, 1);
                            }
                        },
                        error: function(e) {
                            console.log(e);
                        }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },

                success: function(file, response)
                {
                    imagesToUpload.push(response.image_path)
                },
                error: function(file, response)
                {
                    return false;
                },
                init: function() {
                    var dz = this;
                    // Load existing files on page load
                    loadExistingFiles(dz);
                }
            };
        Dropzone.discover();

        $(document).ready(function (e){
            $('#submit_gallery_form').on('click',function (e){
                e.preventDefault();
                $('#images').val(imagesToUpload);
                if (!imagesToUpload.length){
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        text: 'please upload images',
                    })
                    return;
                }
                if (!$('#title').val()){
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        text: 'please enter title',
                    })
                    return;
                }
                $('#gallery_form').submit();
            });
        });
    </script>

@endsection
