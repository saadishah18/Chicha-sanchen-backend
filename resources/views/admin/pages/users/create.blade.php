@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">

        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.users.index'),'text' => 'Create User'])
        <form method="post" action="{{ route('admin.users.store') }}"  enctype="multipart/form-data">
            @csrf
            <div class="col-lg-9">
                @include('admin.components.partials.session_statuses')

                    @include('admin.components.form.input',
                        [
                            'fieldId' => 'display_name',
                            'fieldTitle' => 'Display Name',
                            'placeholder' => 'Enter Display Name',
                            'required' => true,
                            'autofocus' => false,
                          ])
                @include('admin.components.form.input',
                        [
                            'fieldId' => 'slug',
                            'fieldTitle' => 'Username',
                            'fieldName' => 'username',
                            'placeholder' => 'Enter Username',
                            'required' => true,
                            'autofocus' => false,
                            'errorKey' => 'username'
                          ])

                <div class="form-group row">
                    <label for="user_role" class="col-sm-2 col-form-label">Role<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" id="user_role" name="user_role">
                            <option value="">
                                Select Role
                            </option>
                            @foreach(\App\Models\UserRole::all() as $r)
                                <option value="{{$r->role_id}}" {{old('user_role') == $r->role_id ? 'selected' : ''}}>
                                    {{$r->role_name}}
                                </option>
                            @endforeach

                        </select>
                        @include('admin.components.error',['error' => 'user_role'])
                    </div>
                </div>
                @include('admin.components.form.input',
                        [
                            'inputType' => 'email',
                            'fieldId' => 'email',
                            'fieldTitle' => 'Email',
                            'fieldName' => 'email',
                            'placeholder' => 'Enter email address',
                            'required' => true,
                            'autocomplete' => 'email'
                          ])

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Gender<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="maleRadio" value="male" {{old('gender') == 'male' ? 'checked' : 'checked'}} required>
                            <label class="form-check-label" for="maleRadio">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="femaleRadio" value="female" {{old('gender') == 'female' ? 'checked' : ''}} required>
                            <label class="form-check-label" for="femaleRadio">Female</label>
                        </div>
                    </div>
                    @error('gender')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                @include('admin.components.form.input',
                        [
                            'inputType' => 'password',
                            'fieldId' => 'password',
                            'fieldTitle' => 'Password',
                            'fieldName' => 'password',
                            'placeholder' => 'Enter password',
                            'required' => true,
                          ])
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
