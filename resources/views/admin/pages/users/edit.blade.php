@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.users.index'),'text' => 'Edit User'])
        <form method="post" action="{{ route('admin.users.update',['id' => $user->user_id]) }}"  enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="col-lg-9">

                @if (session('status') === 'created')
                    @include('admin.pages.partials.alert',['type' => 'success', 'message' => 'User details updated Successfully'])
                @endif

                <div class="form-group row">
                    <label for="display_name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="display_name" name="display_name" value="{{old('display_name', $user->display_name)}}" placeholder="Enter your name" required autofocus autocomplete="name">
                        @include('admin.components.error',['error' => 'display_name'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" id="slug" value="{{old('username', $user->username)}}" placeholder="Username" required>
                        @include('admin.components.error',['error' => 'username'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user_role" class="col-sm-2 col-form-label">Role<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" id="user_role" name="user_role">
                            <option value="">
                                Select Role
                            </option>
                            @foreach(\App\Models\UserRole::all() as $r)
                                <option value="{{$r->role_id}}" {{in_array($r->role_id,[$user->user_role,old('user_role')]) ? 'selected' : ''}}>
                                    {{$r->role_name}}
                                </option>
                            @endforeach

                        </select>
                        @include('admin.components.error',['error' => 'user_role'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" readonly disabled id="email" placeholder="Enter your email" value="{{$user->email}}">
                        @include('admin.components.error',['error' => 'email'])
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Gender</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="maleRadio" value="male" {{$user->gender == 'male' ? 'checked' : ''}} required>
                            <label class="form-check-label" for="maleRadio">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="femaleRadio" value="female" {{$user->gender == 'female' ? 'checked' : ''}} required>
                            <label class="form-check-label" for="femaleRadio">Female</label>
                        </div>
                        @include('admin.components.error',['error' => 'gender'])
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>


            </div>
        </form>

    </div>
@endsection
@section('js')
    <script src="{{asset('js/slugify.js')}}"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            putSlugInInputField('#display_name','#slug');
        }); //ready
    </script>
@endsection
