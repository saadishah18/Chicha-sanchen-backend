@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.categories.index'),'text' => 'Edit Category'])
        <form method="post" action="{{ route('admin.categories.update',['id' => $category->category_id]) }}"  enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="form-group row w-100">
                <div id="image-container" class="text-center mb-5 d-flex gap-4 w-100">
                    <div class="col-sm-3">
                        <label class="col-form-label"> Category Image </label>
                    </div>
                    <div class="w-100 border-dashed p-10 col-sm-9">
                        <label for="icons" class="col-form-label w-100 cursor-pointer">

                            <img width="100px" height="100px" id="image_preview" class="object-cover img-space" onerror="this.onerror=null; this.src=this.src=this.style.display = 'none'" src="{{$category->getAttachmentUrl()}}" alt="Category Image">
                            <div id="edit-icon" class="edit-icon translate-middle hidden">
                                <div><i class="fas fa-image"></i> {{$category->icons ? 'Change': 'Please upload'}} feature image</div>
                            </div>
                        </label>
                        <p class="text-gray-500">Note: Only png,jpeg,gif and bmp file format are allowed.</p>
                        <input id="icons" name="icons" type="file" accept="image/png,image/jpg,image/jpeg,image/webp"  class="d-none" />
                        @include('admin.components.error',['error' => 'icons'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                    <label for="category_name" class="col-sm-3 form-label">Category Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="{{old('category_name', $category->category_name)}}" placeholder="Enter your name" required autofocus autocomplete="name">
                        @include('admin.components.error',['error' => 'category_name'])
                    </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
            </div>
        </form>

    </div>
@endsection
@section('js')

    <script>
        const userImage = document.getElementById('image_preview');
        const editIcon = document.getElementById('edit-icon');
        const uploadInput = document.getElementById('icons');

        userImage.addEventListener('mouseover', () => {
            editIcon.classList.remove('hidden');
        });

        userImage.addEventListener('mouseout', () => {
            editIcon.classList.add('hidden');
        });

        uploadInput.addEventListener('change', () => {
            $('#image_preview').css('display','block');
            const file = uploadInput.files[0];
            const reader = new FileReader();

            reader.onload = () => {
                userImage.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        });
    </script>


@endsection
@section('css')
    <style>
        .border-dashed{
            border:dashed;
        }
        .p-10{
            padding: 4rem;
        }
        .cursor-pointer{
            cursor: pointer;
        }
        .img-space{
            margin: 1rem auto 1rem auto;
        }
    </style>
@endsection
