@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.components.errors')
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.galleries.index'),'text' => 'Add New Gallery'])
        <div class="col-lg">
            <div class="form-group row">
                <div  class="col-sm-3 form-label">Upload Gallery Image</div>
                <div class="col-sm-9">
                    <form method="post" action="{{url('/admin/images/upload')}}" enctype="multipart/form-data"
                          class="dropzone" id="dropzone">
                        @csrf
                    </form>
                </div>
            </div>
            <form method="post" action="{{ route('admin.galleries.store') }}"  enctype="multipart/form-data" id="gallery_form">
                @csrf
                @if (session('status'))
                    @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
                @endif
                @if (session('error'))
                    @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
                @endif
                <input type="hidden" name="images" value="" id="images">

                @include('admin.components.form.input',
                        [
                            'fieldId' => 'title',
                            'fieldTitle' => 'Gallery Name',
                            'placeholder' => 'Enter gallery name',
                            'required' => true,
                            'autofocus' => true,
                            'autocomplete' => null,
                            'mainDivClasses' => ' mt-3',
                            'labelCols' => 'col-sm-3',
                            'inputCols' => 'col-sm-9'
                          ])

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
            $.ajax({
                url: "/admin/images",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Loop through the files and display them
                        for (var i = 0; i < response.files.length; i++) {
                            var file = response.files[i];
                            var mockFile = { filename: file.filename, size: file.size };

                            dz.options.addedfile.call(dz, mockFile);
                            dz.options.thumbnail.call(dz, mockFile, file.path);
                            dz.files.push(mockFile);
                            imagesToUpload.push(file.filename);
                        }
                    } else {
                        console.error(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
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
                        url: '{{ url("/admin/images/delete") }}',
                        data: {filename: name},
                        success: function (data){
                            console.log("File has been successfully removed!!");
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
                    // var dz = this;
                    // Load existing files on page load
                    // loadExistingFiles(dz);
                }
            };
        Dropzone.discover();

        $(document).ready(function (e){
            $('#submit_gallery_form').on('click',function (e){
                e.preventDefault();
                $('#images').val(imagesToUpload);
                if (!imagesToUpload.length){
                    Swal.fire({
                        toast:true,
                        position: 'top',
                        icon: 'error',
                        title: '',
                        text: 'please upload images',
                        showConfirmButton: false,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    return;
                }
                if (!$('#title').val()){
                    Swal.fire({
                        toast:true,
                        position: 'top',
                        icon: 'error',
                        title: '',
                        text: 'please enter title',
                        showConfirmButton: false,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    return;
                }
                $('#gallery_form').submit();
            });
        });
    </script>

@endsection
