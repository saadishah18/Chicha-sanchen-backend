@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.comments.index'),'text' => 'Edit Comment'])
        <form method="post" action="{{ route('admin.comments.update',['id' => $comment->comment_id]) }}"  enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="col-lg-9">

                @include('admin.components.partials.session_statuses')
                @include('admin.components.form.input',
                    [
                        'fieldId' => 'user_thoughts',
                        'fieldTitle' => 'Title',
                        'placeholder' => 'Enter Title',
                        'required' => true,
                        'autofocus' => true,
                        'autocomplete' => null,
                        'value' => $comment->user_thoughts
                    ])

                <div class="mb-3">
                    <label for="comment" class="form-label">Description</label>
                    <textarea class="form-control" id="comment" name="comment"  placeholder="Enter your comment" >{{old('comment', $comment->comment)}}</textarea>
                    @error('comment')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>


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
