@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.categories.index'),'text' => 'Create Category'])
        <form method="post" action="{{ route('admin.categories.store') }}"  enctype="multipart/form-data">
            @csrf
            @if (session('status'))
                @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
            @endif
            @if (session('error'))
                @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
            @endif
            <div class="form-group row w-100">
                <div id="image-container" class="text-center mb-5 d-flex gap-4 w-100">
                    <div class="col-sm-3">
                        <label class="col-form-label"> Category Image </label>
                    </div>
                    <div class="w-100 border-dashed p-10 col-sm-9">
                        <label class="col-form-label w-100 cursor-pointer" for="icons">
                            <img width="100px" height="100px" id="image_preview" class="object-cover img-space" onerror="this.onerror=null; this.src=this.style.display = 'none'" src="" alt="Category Image">

                            <div id="edit-icon" class="edit-icon  translate-middle hidden">
                                <div><i class="fas fa-image"></i> Please upload feature image</div>
                            </div>

                        </label>
                        <p class="text-gray-500">Note: Only png,jpeg,gif and bmp file format are allowed.</p>
                        <input id="icons"  name="icons" type="file" accept="image/png,image/jpg,image/jpeg,image/webp"  class="d-none" />
                        @include('admin.components.error',['error' => 'icons'])
                    </div>
                </div>
            </div>

            @include('admin.components.form.input', [ 'fieldId' => 'category_name', 'fieldTitle' => 'Category Name','placeholder' => 'Enter category name', 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9','autofocus' => true,'required' => true, 'autocomplete' => 'name'])

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
