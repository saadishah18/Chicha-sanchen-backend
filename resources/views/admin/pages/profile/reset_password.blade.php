@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Update password</h1>
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')
            <div class="col-lg-9">

                @if (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Password updated!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="current_password" class="form-label">Old Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password"  placeholder="Enter your current password" required autofocus autocomplete="current-password">
                    @error('current_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password"  placeholder="Enter your new password" required autofocus autocomplete="new-password">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"  placeholder="Enter your new password" required autofocus autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary bg-theme">Reset Password</button>
                </div>


            </div>
        </form>
    </div>
@endsection
