@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.roles.index'),'text' => 'Add New Role'])
        @include('admin.components.errors')
        <form method="post" action="{{ route('admin.roles.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-9">

                @include('admin.components.partials.session_statuses')

                @include('admin.components.form.input', [
                    'fieldId' => 'role_name',
                    'fieldTitle' => 'Role Name',
                    'placeholder' => 'Enter Role name',
                    'required' => true,
                    'autofocus' => true,
                    'autocomplete' => null,
                    'mainDivClasses' => 'mt-3',
                    'labelCols' => 'col-sm-3',
                    'inputCols' => 'col-sm-9'
                ])

                <!-- Add permissions selection field -->
                <div class="form-group row">
                    <label for="permissions" class="col-sm-3 col-form-label">Permissions</label>
                    <div class="col-sm-9">
                        <select name="permissions[]" id="permissions" class="form-control" multiple>
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>

            </div>
        </form>

    </div>
@endsection
