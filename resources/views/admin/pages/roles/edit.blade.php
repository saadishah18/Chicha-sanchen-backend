@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow', [
            'backRoute' => route('admin.roles.index'),
            'text' => 'Edit Role',
        ])
        @include('admin.components.errors')

        <form method="post" action="{{ route('admin.roles.update', ['id' => $role->role_id]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="col-lg-12">

                @if (session('status'))
                    @include('admin.pages.partials.alert', [
                        'type' => 'success',
                        'message' => session('status'),
                    ])
                @endif
                @if (session('error'))
                    @include('admin.pages.partials.alert', [
                        'type' => 'danger',
                        'message' => session('error'),
                    ])
                @endif

                <div class="form-group row">
                    <label for="role_name" class="col-sm-3 col-form-label">Role Name<span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="role_name" id="role_name"
                            value="{{ old('role_name', $role->role_name) }}" placeholder="Title" required>
                        @include('admin.components.error', ['error' => 'role_name'])
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">
                        <h3>Permissions</h3>
                    </label>
                    <div class="d-flex flex-wrap permission-list h-100">
                        @foreach ($permissionGroups as $category => $permissions)
                            <div class="category mx-2 my-4">
                                <h3>{{ $category }}</h3>
                                <label>
                                    <input type="checkbox" class="mark-all">
                                    Mark All
                                </label>
                                <ul class="list-group">
                                    @foreach ($permissions as $permissionName)
                                        <li class="list-group-item">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="{{ $permissionName }}"
                                                    {{ in_array($permissionName, $selectedPermissions) ? 'checked' : '' }}>
                                                {{ str_replace('_', ' ', ucfirst($permissionName)) }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mb-3 text-center">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary" id="markAll">Mark All</button>
                        <button type="button" class="btn btn-primary" id="unmarkAll">Unmark All</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
            </div>
    </div>
    </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add event listener for "Mark All" button
            $('.mark-all').click(function() {
                var categoryElement = $(this).closest('.category');
                var checkboxes = categoryElement.find('input[name="permissions[]"]');
                checkboxes.prop('checked', this.checked);
            });

            // Add event listener for "Mark All" button at the bottom
            $('#markAll').click(function() {
                $('.category').each(function() {
                    markOrUnmarkPermissions(this, true);
                });
            });

            // Add event listener for "Unmark All" button at the bottom
            $('#unmarkAll').click(function() {
                $('.category').each(function() {
                    markOrUnmarkPermissions(this, false);
                });
            });

            // Function to mark or unmark permissions in a category
            function markOrUnmarkPermissions(categoryElement, checked) {
                var checkboxes = $(categoryElement).find('input[name="permissions[]"]');
                checkboxes.prop('checked', checked);
            }
        });
    </script>
@endsection
