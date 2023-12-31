@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Edit profile</h1>
        <form method="post" action="{{ route('admin.profile.update') }}"  enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="col-lg-3">
                <div id="image-container" class="position-relative w-100 text-center">
                    <label for="profile_pic">

                        <img width="100px" height="100px" id="image_preview" class="object-cover" onerror="this.onerror=null; this.src='/img/no-user-profile.svg'" src="{{$user->getProfilePictureUrl()}}" alt="User Image">
                        <div id="edit-icon" class="edit-icon position-absolute top-50 start-50 translate-middle hidden">
                            <i class="fas fa-edit "></i>
                        </div>
                    </label>
                    <input id="profile_pic" name="profile_pic" type="file" accept="image/png,image/jpg,image/jpeg,image/webp"  class="d-none" />
                </div>
            </div>
            <div class="col-lg-9">

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Profile updated!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="display_name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="display_name" name="display_name" value="{{old('display_name', $user->display_name)}}" placeholder="Enter your name" required autofocus autocomplete="name">
                    @error('display_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" readonly disabled id="email" placeholder="Enter your email" value="{{$user->email}}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" id="location" placeholder="Enter your location" value="{{old('location', $user->location)}}" required>
                    @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="maleRadio" value="male" {{$user->gender == 'male' ? 'checked' : ''}} required>
                            <label class="form-check-label" for="maleRadio">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="femaleRadio" value="female" {{$user->gender == 'female' ? 'checked' : ''}} required>
                            <label class="form-check-label" for="femaleRadio">Female</label>
                        </div>
                    </div>
                    @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob"  id="dob" value="{{old('dob', $user->dob)}}" required>
                    @error('dob')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mobile_no" class="form-label">Mobile Number</label>
                    <input type="tel" class="form-control" name="mobile_no"  id="mobile_no" value="{{old('mobile_no', $user->mobile_no)}}" placeholder="Enter your mobile number" required>
                    @error('mobile_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="zipcode" class="form-label">Zip Code</label>
                    <input type="text" class="form-control" name="zipcode"  id="zipcode" value="{{old('zipcode', $user->zipcode)}}" placeholder="Enter your zip code">
                    @error('zipcode')
                    <div class="invalid-feedback">{{ $message }}</div>
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
        const uploadInput = document.getElementById('profile_pic');

        userImage.addEventListener('mouseover', () => {
            editIcon.classList.remove('hidden');
        });

        userImage.addEventListener('mouseout', () => {
            editIcon.classList.add('hidden');
        });

        uploadInput.addEventListener('change', () => {
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
